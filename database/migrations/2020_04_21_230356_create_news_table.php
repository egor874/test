<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject');
            $table->string('author')->nullable();
            $table->string('title')->nullable();
            $table->string('url', 300)->nullable();
            $table->string('urlToImage', 300)->nullable();
            $table->timestamp('publishedAt');
            $table->text('content')->nullable();
            $table->unsignedBigInteger('source_id');
            $table->timestamps();
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
