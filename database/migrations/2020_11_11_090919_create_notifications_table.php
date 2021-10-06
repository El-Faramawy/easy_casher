<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->longText('body')->nullable();

            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->foreign('to_user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('date')->nullable();

            $table->enum('is_read',['read','unread'])
                ->default('unread')->nullable();

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
        Schema::dropIfExists('notifications');
    }
}
