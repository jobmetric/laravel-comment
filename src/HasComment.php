<?php

namespace JobMetric\Comment;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use JobMetric\Comment\Events\CommentForgetEvent;
use JobMetric\Comment\Events\CommentStoredEvent;
use JobMetric\Comment\Events\CommentUpdateEvent;
use JobMetric\Comment\Exceptions\ModelCommentContractNotFoundException;
use JobMetric\Comment\Models\Comment;
use Throwable;

/**
 * @method morphOne(string $class, string $string)
 * @method morphMany(string $class, string $string)
 */
trait HasComment
{
    /**
     * boot has comment
     *
     * @return void
     * @throws Throwable
     */
    public static function bootHasComment(): void
    {
        if (!in_array('JobMetric\Comment\Contracts\CommentContract', class_implements(self::class))) {
            throw new ModelCommentContractNotFoundException(self::class);
        }
    }

    /**
     * comment has one relationship
     *
     * @return MorphOne
     */
    public function commentTo(): MorphOne
    {
        return $this->morphOne(Comment::class, 'commentable');
    }

    /**
     * comment has many relationships
     *
     * @return MorphMany
     */
    public function commentsTo(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * store comment
     *
     * @param string $text
     * @param int $parent_id
     * @param int|null $user_id
     *
     * @return array
     * @throws Throwable
     */
    public function comment(string $text, int $parent_id = 0, int $user_id = null): array
    {
        $comment = $this->commentTo()->create([
            'user_id' => $user_id,
            'text' => $text,
            'parent_id' => $parent_id
        ]);

        event(new CommentStoredEvent($comment));

        return [
            'ok' => true,
            'message' => trans('comment::base.messages.created'),
            'data' => $comment,
            'status' => 201
        ];
    }

    /**
     * update comment
     *
     * @param int $comment_id
     * @param string $text
     *
     * @return array
     * @throws Throwable
     */
    public function updateComment(int $comment_id, string $text): array
    {
        /** @var Comment $comment */
        $comment = $this->commentTo()->where('id', $comment_id)->first();

        if ($comment) {
            $comment->update([
                'text' => $text
            ]);

            event(new CommentUpdateEvent($comment));

            return [
                'ok' => true,
                'message' => trans('comment::base.messages.updated'),
                'data' => $comment,
                'status' => 200
            ];
        }

        return [
            'ok' => false,
            'message' => trans('comment::base.messages.updated'),
            'status' => 404
        ];
    }

    /**
     * store comment by user
     *
     * @param int $user_id
     * @param string $text
     * @param int $parent_id
     *
     * @return array
     * @throws Throwable
     */
    public function commentBy(int $user_id, string $text, int $parent_id = 0): array
    {
        return $this->comment($text, $parent_id, $user_id);
    }

    /**
     * comment count
     *
     * @return int
     * @throws Throwable
     */
    public function commentCount(): int
    {
        return $this->commentTo()->count();
    }

    /**
     * load comment count after a model loaded
     *
     * @return static
     */
    public function withCommentCount(): static
    {
        $this->loadCount(['commentTo as comment_count']);

        return $this;
    }

    /**
     * load comment after model loaded
     *
     * @return static
     */
    public function withComment(): static
    {
        $this->load('commentTo');

        return $this;
    }

    /**
     * load comments after models loaded
     *
     * @return static
     */
    public function withComments(): static
    {
        $this->load('commentsTo');

        return $this;
    }

    /**
     * is commented by user
     *
     * @param int $user_id
     *
     * @return int|null
     */
    public function isCommentedStatusBy(int $user_id): ?int
    {
        /* @var Comment $comment */
        $comment = $this->commentTo()->where('user_id', $user_id)->first();

        return $comment?->comment ?? null;
    }

    /**
     * forget comment
     *
     * @param int $user_id
     *
     * @return static
     */
    public function forgetComment(int $user_id): static
    {
        /* @var Comment $comment */
        $comment = $this->commentTo()->where('user_id', $user_id)->first();

        if ($comment) {
            $comment->delete();

            event(new CommentForgetEvent($comment));
        }

        return $this;
    }

    /**
     * forget comments
     *
     * @return static
     */
    public function forgetComments(): static
    {
        /* @var Comment $comment */
        $this->commentsTo()->get()->each(function ($comment) {
            $comment->delete();

            event(new CommentForgetEvent($comment));
        });

        return $this;
    }
}
