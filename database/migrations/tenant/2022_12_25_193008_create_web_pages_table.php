<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->string('banner')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('css')->nullable();
            $table->longText('content')->nullable();
            $table->text('js')->nullable();
            $table->timestamps();
            $table->foreign('menu_id')->references('id')->on('web_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_pages');
    }
}
