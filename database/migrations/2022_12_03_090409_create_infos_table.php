<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('email',45)->unique();
            $table->string('mobile',20);
          
            $table->string('birthdate',20);
            $table->string('nationality',20);
            $table->string('experience',20);
            $table->text('languages');
           
            $table->boolean('freelance_active')->default(false);
            $table->string('facebook_url',200);
            $table->string('skybe',200);
            $table->string('dribbble',200);
            $table->string('twitter_url',200);
            $table->string('youtube_url');
            $table->string('image')->nullable;
            $table->string('cv')->nullable;
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
        Schema::dropIfExists('infos');
    }
}
