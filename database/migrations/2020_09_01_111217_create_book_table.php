<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->timestamps();
            $table->softDeletes();
            $table->string('isbn', 20)->nullable();
            $table->string('title', 100)->nullable();
            $table->date('publication_date')->nullable();
            $table->integer('weight')->nullable()->default(0);
            $table->integer('wide')->nullable()->default(0);
            $table->integer('long')->nullable()->default(0);
            $table->integer('page')->nullable()->default(0);
            $table->text('description')->nullable();
            $table->bigInteger('publisher_id')->nullable()->index('publisher_id_fk1_idx');
            $table->bigInteger('language_id')->nullable()->index('language_id_fk1_idx');
            $table->bigInteger('category_id')->nullable()->index('category_id_fk1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book');
    }
}
