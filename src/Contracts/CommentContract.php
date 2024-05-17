<?php

namespace JobMetric\Comment\Contracts;

interface CommentContract
{
    /**
     * Check if a comment for a specific model needs to be approved.
     *
     * @return bool
     */
    public function needsCommentApproval(): bool;
}
