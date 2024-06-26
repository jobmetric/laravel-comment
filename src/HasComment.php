<?php

namespace JobMetric\Comment;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use JobMetric\Comment\Events\CommentForgetEvent;
use JobMetric\Comment\Events\CommentStoredEvent;
use JobMetric\Comment\Events\CommentUpdateEvent;
use JobMetric\Comment\Exceptions\ModelCommentContractNotFoundException;
use JobMetric\Comment\Http\Resources\CommentResource;
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
     * store comment by user
     *
     * @param int $user_id
     * @param string $text
     * @param int|null $parent_id
     *
     * @return array
     * @throws Throwable
     */
    public function commentBy(int $user_id, string $text, int $parent_id = null): array
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
    public function isCommentedByUser(int $user_id): ?int
    {
        /* @var Comment $comment */
        $comment = $this->commentTo()->where('user_id', $user_id)->first();

        return $comment?->comment ?? null;
    }

    /**
     * store comment
     *
     * @param string $text
     * @param int|null $parent_id
     * @param int|null $user_id
     *
     * @return array
     * @throws Throwable
     */
    public function comment(string $text, int $parent_id = null, int $user_id = null): array
    {
        $comment = $this->commentTo()->create([
            'user_id' => $user_id,
            'parent_id' => $parent_id,
            'text' => $text
        ]);

        event(new CommentStoredEvent($comment));

        return [
            'ok' => true,
            'message' => trans('comment::base.messages.created'),
            'data' => CommentResource::make($comment),
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

        if (!$comment) {
            return [
                'ok' => false,
                'message' => trans('comment::base.validation.not_found'),
                'status' => 404
            ];
        }

        $comment->update([
            'text' => $text
        ]);

        event(new CommentUpdateEvent($comment));

        return [
            'ok' => true,
            'message' => trans('comment::base.messages.updated'),
            'data' => CommentResource::make($comment),
            'status' => 200
        ];
    }

    /**
     * forget comment
     *
     * @param int $comment_id
     *
     * @return array
     */
    public function forgetComment(int $comment_id): array
    {
        /* @var Comment $comment */
        $comment = $this->commentTo()->where('id', $comment_id)->first();

        if (!$comment) {
            return [
                'ok' => false,
                'message' => trans('comment::base.validation.not_found'),
                'status' => 404
            ];
        }

        $data = CommentResource::make($comment);

        $comment->delete();

        event(new CommentForgetEvent($comment));

        return [
            'ok' => true,
            'message' => trans('comment::base.messages.deleted'),
            'data' => $data,
            'status' => 200
        ];
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

    /**
     * approve comment
     *
     * @param int $comment_id
     * @param int|null $user_id
     *
     * @return array
     * @throws Throwable
     */
    public function approveComment(int $comment_id, int $user_id = null): array
    {
        /** @var Comment $comment */
        $comment = $this->commentTo()->where('id', $comment_id)->first();

        if (!$comment) {
            return [
                'ok' => false,
                'message' => trans('comment::base.validation.not_found'),
                'status' => 404
            ];
        }

        $comment->update([
            'approved_at' => now(),
            'approved_by' => $user_id ?? auth()->id()
        ]);

        return [
            'ok' => true,
            'message' => trans('comment::base.messages.approved'),
            'data' => CommentResource::make($comment),
            'status' => 200
        ];
    }
}
