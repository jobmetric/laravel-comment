<?php

namespace JobMetric\Comment\Events;

use JobMetric\Comment\Models\Comment;

class CommentUpdateEvent
{
    public Comment $model;

    /**
     * Create a new event instance.
     */
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }
}
