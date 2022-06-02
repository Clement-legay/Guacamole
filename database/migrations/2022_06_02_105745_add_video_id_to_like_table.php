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
        Schema::table('like', function (Blueprint $table) {
            $table->unsignedBigInteger('id_video')->nullable()->after('like');
            $table->foreign('id_video')->references('id')->on('video');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('like', function (Blueprint $table) {
            $table->dropForeign(['id_video']);
            $table->dropColumn('id_video');
        });
    }
};
