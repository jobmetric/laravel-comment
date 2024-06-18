<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Comment Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during Comment for
    | various messages that we need to display to the user.
    |
    */

    'validation' => [
        'errors' => 'Validation errors occurred.',
        'not_found' => 'The comment not found.',
    ],

    'messages' => [
        'created' => 'The comment was created successfully.',
        'updated' => 'The comment was updated successfully.',
        'deleted' => 'The comment was deleted successfully.',
        'approved' => 'The comment was approved successfully.',
    ],

    'exceptions' => [
        'model_has_comment_not_found' => 'Model :model not use JobMetric\Comment\HasComment Trait!',
        'model_comment_contract_not_found' => 'Model :model not implements JobMetric\Comment\Contracts\CommentContract interface!',
    ],

];
