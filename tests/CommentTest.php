<?php

namespace JobMetric\Comment\Tests;

use App\Models\Product;
use Tests\BaseDatabaseTestCase as BaseTestCase;
use Throwable;

class CommentTest extends BaseTestCase
{
    /**
     * @throws Throwable
     */
    public function testStore(): void
    {
        // store product
        /** @var Product $product */
        $product = Product::create([
            'status' => true,
        ]);

        $comment = $product->comment('test comment');

        $this->assertIsArray($comment);
        $this->assertTrue($comment['ok']);
        $this->assertEquals(201, $comment['status']);
        $this->assertIsInt($comment['data']->id);
        $this->assertDatabaseHas('comments', [
            'id' => $comment['data']->id,
            'commentable_id' => $product->id,
            'commentable_type' => Product::class,
            'text' => 'test comment',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function testUpdate(): void
    {
        // store product
        /** @var Product $product */
        $product = Product::create([
            'status' => true,
        ]);

        $comment = $product->comment('test comment');

        $updatedComment = $product->updateComment($comment['data']->id, 'updated comment');

        $this->assertIsArray($updatedComment);
        $this->assertTrue($updatedComment['ok']);
        $this->assertEquals(200, $updatedComment['status']);
        $this->assertIsInt($updatedComment['data']->id);
        $this->assertDatabaseHas('comments', [
            'id' => $updatedComment['data']->id,
            'commentable_id' => $product->id,
            'commentable_type' => Product::class,
            'text' => 'updated comment',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function testForget(): void
    {
        // store product
        /** @var Product $product */
        $product = Product::create([
            'status' => true,
        ]);

        $comment = $product->comment('test comment');

        $deleteComment = $product->forgetComment($comment['data']->id);

        $this->assertIsArray($deleteComment);
        $this->assertTrue($deleteComment['ok']);
        $this->assertEquals(200, $deleteComment['status']);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment['data']->id,
            'commentable_id' => $product->id,
            'commentable_type' => Product::class,
            'text' => 'test comment',
        ]);

        // double delete
        $deleteComment = $product->forgetComment($comment['data']->id);

        $this->assertIsArray($deleteComment);
        $this->assertFalse($deleteComment['ok']);
        $this->assertEquals(404, $deleteComment['status']);
    }

    /**
     * @throws Throwable
     */
    public function testApprove(): void
    {
        // store product
        /** @var Product $product */
        $product = Product::create([
            'status' => true,
        ]);

        $comment = $product->comment('test comment');

        $approveComment = $product->approveComment($comment['data']->id);

        $this->assertIsArray($approveComment);
        $this->assertTrue($approveComment['ok']);
        $this->assertEquals(200, $approveComment['status']);
        $this->assertDatabaseHas('comments', [
            'id' => $comment['data']->id,
            'commentable_id' => $product->id,
            'commentable_type' => Product::class,
            'text' => 'test comment',
            'approved_at' => now(),
        ]);
    }
}
