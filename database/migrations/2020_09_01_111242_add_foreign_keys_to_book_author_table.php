<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBookAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_author', function (Blueprint $table) {
            $table->foreign('author_id', 'author_id_fk1')->references('id')->on('author')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('book_id', 'book_id_fk1')->references('id')->on('book')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_author', function (Blueprint $table) {
            $table->dropForeign('author_id_fk1');
            $table->dropForeign('book_id_fk1');
        });
    }
}
