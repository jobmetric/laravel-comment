<?php

namespace JobMetric\Comment\Exceptions;

use Exception;
use Throwable;

class ModelHasCommentNotFoundException extends Exception
{
    public function __construct(string $model, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct(trans('comment::base.exceptions.model_has_comment_not_found', [
            'model' => $model
        ]), $code, $previous);
    }
}
