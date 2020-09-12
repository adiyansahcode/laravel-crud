<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book', function (Blueprint $table) {
            $table->foreign('category_id', 'category_id_fk1')->references('id')->on('category')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('language_id', 'language_id_fk1')->references('id')->on('language')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('publisher_id', 'publisher_id_fk1')->references('id')->on('publisher')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book', function (Blueprint $table) {
            $table->dropForeign('category_id_fk1');
            $table->dropForeign('language_id_fk1');
            $table->dropForeign('publisher_id_fk1');
        });
    }
}
