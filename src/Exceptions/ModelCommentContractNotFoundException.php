<?php

namespace JobMetric\Comment\Exceptions;

use Exception;
use Throwable;

class ModelCommentContractNotFoundException extends Exception
{
    public function __construct(string $model, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct("Model $model not implements JobMetric\Comment\Contracts\CommentContract interface!", $code, $previous);
    }
}
