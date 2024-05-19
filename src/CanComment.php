<?php

namespace JobMetric\Comment;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use JobMetric\Comment\Models\Comment;

/**
 * @property int id
 * @method morphMany(string $class, string $string)
 */
trait CanComment
{
    /**
     * returns all comments that this user has made.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Returns only approved comments that this user has made.
     *
     * @return MorphMany
     */
    public function approvedComments(): MorphMany
    {
        return $this->comments()->whereNotNull('approved_at');
    }

    /**
     * Returns only unapproved comments that this user has made.
     *
     * @return MorphMany
     */
    public function unapprovedComments(): MorphMany
    {
        return $this->comments()->whereNull('approved_at');
    }

    /**
     * Return only comments that this user has made that are replies.
     *
     * @return MorphMany
     */
    public function replies(): MorphMany
    {
        return $this->comments()->whereNotNull('parent_id');
    }

    /**
     * Return only comments that this user has made that are not replies.
     *
     * @return MorphMany
     */
    public function commentsWithoutReplies(): MorphMany
    {
        return $this->comments()->whereNull('parent_id');
    }

    /**
     * Return only comments that this user has made that are replies and are approved.
     *
     * @return MorphMany
     */
    public function approvedReplies(): MorphMany
    {
        return $this->replies()->whereNotNull('approved_at');
    }

    /**
     * Return only comments that this user has made that are replies and are unapproved.
     *
     * @return MorphMany
     */
    public function unapprovedReplies(): MorphMany
    {
        return $this->replies()->whereNull('approved_at');
    }

    /**
     * approves a comment that this user has made.
     *
     * @param Comment $comment
     *
     * @return Comment
     */
    public function approveComment(Comment $comment): Comment
    {
        $comment->update([
            'approved_at' => now(),
            'approved_by' => $this->id,
        ]);

        return $comment;
    }
}
