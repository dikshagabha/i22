<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role')->default(1);
            $table->integer('user_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('device_token')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('image')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('city')->nullable();
            $table->string('pin')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('role');
          $table->dropColumn('phone_number');
          $table->dropColumn('device_token');
          $table->dropColumn('last_login');
          $table->dropColumn('image');
          $table->dropColumn('first_name');
          $table->dropColumn('last_name');
          $table->dropColumn('user_id');
           $table->dropColumn('deleted_at');
           $table->dropColumn('city');
           $table->dropColumn('pin');
      });
    }
}
