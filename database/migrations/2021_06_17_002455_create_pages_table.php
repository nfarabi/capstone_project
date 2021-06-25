<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt')->nullable();
            $table->text('image_name')->nullable();
            $table->text('image')->nullable();
            $table->longText('code_html')->nullable();
            $table->longText('code_css')->nullable();
            $table->longText('code_js')->nullable();
            $table->timestamp('is_featured')->nullable();
            $table->timestamp('is_homepage')->nullable();
            $table->timestamp('is_private')->nullable();
            $table->longText('meta')->nullable();
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
