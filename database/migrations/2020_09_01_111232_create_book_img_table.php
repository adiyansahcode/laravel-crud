<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookImgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_img', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 100)->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('book_id')->nullable()->index('book_id_fk2_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_img');
    }
}
