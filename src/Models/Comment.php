<?php

namespace JobMetric\Comment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property mixed user_id
 * @property mixed parent_id
 * @property mixed commentable_id
 * @property mixed commentable_type
 * @property mixed text
 * @property mixed approved_at
 * @property mixed approved_by
 * @property mixed user
 * @property mixed commentable
 */
class Comment extends Pivot
{
    protected $fillable = [
        'user_id',
        'parent_id',
        'commentable_id',
        'commentable_type',
        'text',
        'approved_at',
        'approved_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'parent_id' => 'integer',
        'text' => 'string',
        'approved_at' => 'datetime',
        'approved_by' => 'integer',
    ];

    public function getTable()
    {
        return config('comment.tables.comment', parent::getTable());
    }

    /**
     * user relationship
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * commentable relationship
     *
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * approved relationship
     *
     * @return MorphTo
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope approved.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereNotNull('approved_at');
    }

    /**
     * Scope unapproved.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeUnApproved(Builder $query): Builder
    {
        return $query->whereNull('approved_at');
    }

    /**
     * Scope text like.
     *
     * @param Builder $query
     * @param string $text
     *
     * @return Builder
     */
    public function scopeText(Builder $query, string $text): Builder
    {
        $words = explode(' ', $text);

        foreach ($words as $word) {
            $query->where('text', 'like', "%$word%");
        }

        return $query;
    }
}
