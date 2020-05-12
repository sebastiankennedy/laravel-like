<?php

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
            config('like.likes_table'),
            function (Blueprint $table) {
                $name = config('like.morph_many_name') ?: 'likable';
                $foreign_key = config('like.foreign_key') ?: 'user_id';

                $table->bigIncrements('id');
                $table->unsignedBigInteger($foreign_key);
                $table->string($name . '_type');
                $table->unsignedBigInteger($name . '_id');
                $table->timestamps();

                $table->index($foreign_key);
                $table->index(["{$name}_type", "{$name}_id"]);
            }
        );
    }

    /**
     * Rollback the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('like.likes_table'));
    }
}