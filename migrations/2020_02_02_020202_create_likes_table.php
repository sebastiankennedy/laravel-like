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
class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(
            config('like.table_name'),
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger(config('like.foreign_key'));
                $table->unsignedBigInteger(config('like.morph_many_id'));
                $table->string(config('like.morph_many_type'));
                $table->timestamps();

                $table->index(config('like.foreign_key'));
                $table->index([config('like.morph_many_type'), config('like.morph_many_id')]);
            }
        );
    }

    /**
     * Rollback the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('like.table_name'));
    }
}
