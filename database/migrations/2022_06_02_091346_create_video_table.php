<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('thumbnail');
            $table->string('video');
            $table->integer('progress')->default(0);
            $table->Integer('duration');
            $table->enum('status', ['pending', 'downloading', 'downloaded', 'processing', 'processed', 'failed', 'online']);
            $table->enum('type', ['public', 'private', 'unlisted']);
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
        Schema::dropIfExists('videos');
    }
};
