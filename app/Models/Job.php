<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_CLOSED = 'closed';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_PUBLISHED,
        self::STATUS_CLOSED,
    ];

    public const JOB_TYPES = [
        'full_time',
        'part_time',
        'contract',
        'temporary',
        'internship',
    ];

    public const WORK_SETUPS = [
        'onsite',
        'hybrid',
        'remote',
    ];

    protected $fillable = [
        'employer_id',
        'title',
        'location',
        'job_type',
        'work_setup',
        'salary_min',
        'salary_max',
        'currency',
        'status',
        'description',
        'requirements',
        'required_skills',
        'published_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'closed_at' => 'datetime',
            'required_skills' => 'array',
        ];
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(JobView::class);
    }

    public function scopeVisibleToSeekers(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }
}
