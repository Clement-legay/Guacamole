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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('isAdmin')->default(0);
            $table->tinyInteger('canWatchVideos')->default(1);
            $table->tinyInteger('canCreateVideo')->default(1);
            $table->tinyInteger('canUpdateVideo')->default(1);
            $table->tinyInteger('canUpdateOthersVideo')->default(0);
            $table->tinyInteger('canDeleteVideo')->default(1);
            $table->tinyInteger('canDeleteOthersVideo')->default(0);
            $table->tinyInteger('canViewUser')->default(0);
            $table->tinyInteger('canCreateUser')->default(0);
            $table->tinyInteger('canUpdateUserSelf')->default(1);
            $table->tinyInteger('canUpdateUserOther')->default(0);
            $table->tinyInteger('canDeleteUserSelf')->default(1);
            $table->tinyInteger('canDeleteUserOther')->default(0);
            $table->tinyInteger('canUpdateUserRole')->default(0);
            $table->tinyInteger('canViewRoles')->default(0);
            $table->tinyInteger('canCreateRole')->default(0);
            $table->tinyInteger('canUpdateRole')->default(0);
            $table->tinyInteger('canDeleteRole')->default(0);
            $table->tinyInteger('canViewComments')->default(0);
            $table->tinyInteger('canCreateComment')->default(1);
            $table->tinyInteger('canUpdateCommentSelf')->default(1);
            $table->tinyInteger('canUpdateCommentOther')->default(0);
            $table->tinyInteger('canDeleteCommentSelf')->default(1);
            $table->tinyInteger('canDeleteCommentOther')->default(0);
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
        Schema::dropIfExists('roles');
    }
};
