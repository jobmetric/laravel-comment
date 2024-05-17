<?php

namespace JobMetric\Comment\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\Comment\Models\Comment;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'parent_id' => null,
            'commentable_id' => null,
            'commentable_type' => null,
            'text' => $this->faker->text,
            'approved_at' => $this->faker->boolean ? $this->faker->dateTime : null,
            'approved_by' => null
        ];
    }

    /**
     * set user id
     *
     * @param int $user_id
     *
     * @return static
     */
    public function setUserId(int $user_id): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user_id
        ]);
    }

    /**
     * set parent id
     *
     * @param int $parent_id
     *
     * @return static
     */
    public function setParentId(int $parent_id): static
    {
        return $this->state(fn(array $attributes) => [
            'parent_id' => $parent_id
        ]);
    }

    /**
     * set commentable
     *
     * @param int $commentable_id
     * @param string $commentable_type
     *
     * @return static
     */
    public function setCommentable(int $commentable_id, string $commentable_type): static
    {
        return $this->state(fn(array $attributes) => [
            'commentable_id' => $commentable_id,
            'commentable_type' => $commentable_type
        ]);
    }

    /**
     * set text
     *
     * @param string $text
     *
     * @return static
     */
    public function setText(string $text): static
    {
        return $this->state(fn(array $attributes) => [
            'text' => $text
        ]);
    }

    /**
     * set approved at
     *
     * @param string $approved_at
     *
     * @return static
     */
    public function setApprove3dAt(string $approved_at): static
    {
        return $this->state(fn(array $attributes) => [
            'approved_at' => $approved_at
        ]);
    }

    /**
     * set approved by
     *
     * @param int $approved_by
     *
     * @return static
     */
    public function setApprovedBy(int $approved_by): static
    {
        return $this->state(fn(array $attributes) => [
            'approved_by' => $approved_by
        ]);
    }
}
