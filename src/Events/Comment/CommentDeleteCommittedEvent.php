<?php

namespace JobMetric\Comment\Events\Comment;

use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\DomainEventDefinition;

/**
 * Describe a committed Comment deleted outcome using allowlisted identifiers.
 */
readonly class CommentDeleteCommittedEvent implements DomainEvent
{
    /**
     * Capture identifiers without models, input values or credentials.
     *
     * @param int|string $id
     *
     * @return void
     */
    public function __construct(
        public int|string $id
    ) {
    }

    /**
     * Return the stable key used by automation consumers.
     *
     * @return string
     */
    public static function key(): string
    {
        return 'comment.comment.deleted.committed';
    }

    /**
     * Describe the outcome for translated discovery interfaces.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'comment::automation.comment_deleted.group', 'comment::automation.comment_deleted.title', 'comment::automation.comment_deleted.description', 'fas fa-bolt', ['automation', 'committed', 'comment']);
    }
}
