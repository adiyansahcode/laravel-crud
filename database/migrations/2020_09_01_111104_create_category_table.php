<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 100)->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('category_parent_id')->nullable()->index('category_parent_id_fk_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
