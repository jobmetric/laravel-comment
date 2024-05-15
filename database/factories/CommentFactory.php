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
            'published_at' => $this->faker->boolean ? $this->faker->dateTime : null,
            'published_by' => null
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
     * set published at
     *
     * @param string $published_at
     *
     * @return static
     */
    public function setPublishedAt(string $published_at): static
    {
        return $this->state(fn(array $attributes) => [
            'published_at' => $published_at
        ]);
    }

    /**
     * set published by
     *
     * @param int $published_by
     *
     * @return static
     */
    public function setPublishedBy(int $published_by): static
    {
        return $this->state(fn(array $attributes) => [
            'published_by' => $published_by
        ]);
    }
}
