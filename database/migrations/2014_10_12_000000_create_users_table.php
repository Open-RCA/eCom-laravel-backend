<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unique('username');
            $table->unique('email');
            $table->timestamp('email_verified_at')->nullable();
            
            $table->string('first_name');
            $table->string('last_name');

            // $table->unsignedInteger('role_id')->index();
            // $table->foreign('role_id')->references('_id')->on('roles')->onDelete('cascade');

            $table->string('phone_number');
            $table->string('password');

            $table->string('profile_picture');
            $table->enum('status', ['ACTIVE', 'INACTIVE']);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
