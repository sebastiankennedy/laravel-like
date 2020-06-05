<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateLikesTable
 */
class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(
            'books',
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
        Schema::dropIfExists('books');
    }
}