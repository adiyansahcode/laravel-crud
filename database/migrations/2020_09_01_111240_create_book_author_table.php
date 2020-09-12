<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_author', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('author_id')->nullable()->index('author_id_pk_idx');
            $table->bigInteger('book_id')->nullable()->index('book_id_fk1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_author');
    }
}
