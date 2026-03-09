<?php

namespace App\Models;

use App\Services\MediaStorageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'body',
        'attachment_path',
        'attachment_original_name',
        'attachment_file_size',
        'attachment_mime_type',
        'read_at',
    ];

    protected $appends = [
        'attachment_url',
        'body_html',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        if (! $this->attachment_path) {
            return null;
        }

        return app(MediaStorageService::class)->url($this->attachment_path);
    }

    public function getBodyHtmlAttribute(): string
    {
        if (! is_string($this->body) || trim($this->body) === '') {
            return '';
        }

        $escapedBody = e($this->body);
        $pattern = '/((https?:\/\/)[^\s<]+)/i';

        $linkified = preg_replace_callback($pattern, static function (array $matches): string {
            $url = e($matches[1]);

            return '<a href="'.$url.'" target="_blank" rel="noopener" class="underline text-blue-600 hover:text-blue-700">'.$url.'</a>';
        }, $escapedBody);

        return nl2br($linkified ?? $escapedBody);
    }
}
