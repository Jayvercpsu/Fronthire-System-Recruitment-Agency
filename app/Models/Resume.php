<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resume extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'file_path',
        'original_name',
        'file_size',
        'mime_type',
    ];

    protected $appends = [
        'url',
        'download_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        return route('resumes.show', $this);
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('resumes.download', $this);
    }
}
