<?php

use Illuminate\Database\Eloquent\Model;
use JobMetric\Comment\Exceptions\ModelHasCommentNotFoundException;

if (!function_exists('comment')) {
    /**
     * Store comment
     *
     * @param Model $model
     * @param string $text
     * @param int $parent_id
     * @param int|null $user_id
     *
     * @return array
     * @throws Throwable
     */
    function comment(Model $model, string $text, int $parent_id = 0, int $user_id = null): array
    {
        if (!in_array('JobMetric\Comment\HasComment', class_uses($model))) {
            throw new ModelHasCommentNotFoundException($model::class);
        }

        return $model->comment($text, $parent_id, $user_id);
    }
}
