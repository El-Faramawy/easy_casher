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
            $table->id();

            $table->enum('user_type',['parent','child'])
                ->default('parent')
                ->nullable();

            $table->string('name')->nullable();
            $table->string('code')->nullable()->unique();

            $table->string('email')->nullable()->unique();
            $table->string('phone_code')->default('0020')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('password')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->string('logo')->nullable();
            $table->string('banner')->nullable();

            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->enum('is_confirmed',['new','accepted','refused'])
                ->default('new');

            $table->enum('is_block',['blocked','not_blocked'])
                ->default('not_blocked')
                ->nullable();

            $table->enum('is_login',['connected','not_connected'])
                ->default('not_connected')
                ->nullable();

            $table->integer('logout_time')->nullable();
            $table->enum('notification_status',['on','off'])
                ->default('on')
                ->nullable();

            $table->string('email_verification_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->enum('software_type',['ios','android','web'])
                ->default('web')
                ->nullable();

            $table->softDeletes();
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
