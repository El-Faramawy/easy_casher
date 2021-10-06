<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->enum('product_type',['unit','weight'])->nullable();

            $table->double('product_cost')->nullable()->default(0);
            $table->double('product_price')->nullable()->default(0);

            $table->string('sku')->unique()->nullable();
            $table->string('barcode_code')->unique()->nullable();
            $table->string('barcode_image')->unique()->nullable();

            $table->enum('stock_type',['in_stock','out_stock'])->nullable();
            $table->double('stock_amount')->nullable()->default(0);

            $table->enum('display_logo_type',['image','color'])->nullable();

            $table->string('image')->nullable();

            $table->unsignedBigInteger('color_id')->nullable();
            $table->foreign('color_id')
                ->references('id')->on('colors')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('added_by_id')->nullable();
            $table->foreign('added_by_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
