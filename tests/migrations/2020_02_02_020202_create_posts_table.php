<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateLikesTable
 */
class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(
            'posts',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->timestamps();
            }
        );
    }

    /**
     * Rollback the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
