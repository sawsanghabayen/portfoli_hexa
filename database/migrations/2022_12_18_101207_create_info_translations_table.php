<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_translations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name',45);
            $table->string('nationality',20);
            $table->string('location',200);
            $table->string('job',100);
            $table->string('locale');
            $table->integer('info_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_translations');
    }
}
