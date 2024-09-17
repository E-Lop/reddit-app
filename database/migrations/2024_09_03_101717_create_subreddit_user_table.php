<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subreddit_user', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_owner');
            $table->uuid('user_id');
            $table->unsignedBigInteger('subreddit_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subreddit_id')->references('id')->on('subreddits');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subreddit_user');
    }
};
