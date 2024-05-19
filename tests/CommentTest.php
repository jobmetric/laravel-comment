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
}
