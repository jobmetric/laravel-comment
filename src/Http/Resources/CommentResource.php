<?php

namespace JobMetric\Comment\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed parent_id
 * @property mixed commentable_type
 * @property mixed commentable_id
 * @property mixed text
 * @property mixed approved_at
 * @property mixed approved_by
 * @property mixed created_at
 * @property mixed updated_at
 */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'commentable_type' => $this->commentable_type,
            'commentable_id' => $this->commentable_id,
            'text' => $this->text,
            'approved_at' => $this->approved_at,
            'approved_by' => $this->approved_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user' => $this->whenLoaded('user'),
            'commentable' => $this->whenLoaded('commentable'),
            'parent' => $this->whenLoaded('parent'),
            'children' => CommentResource::collection($this->whenLoaded('children')),
            'approver' => $this->whenLoaded('approver'),
        ];
    }
}
