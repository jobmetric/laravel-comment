<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('comment.tables.comment'), function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->index()->constrained(config('comment.tables.comment'))->cascadeOnUpdate()->cascadeOnDelete();

            $table->morphs('commentable');

            $table->longText('text')->nullable();

            $table->dateTime('approved_at')->nullable()->index();
            $table->foreignId('approved_by')->nullable()->index()->constrained(config('comment.tables.user'))->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });

        cache()->forget('comments');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('comment.tables.comment'));

        cache()->forget('comments');
    }
};
