<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->enum('sale_type',['normal_sale','back_sale'])->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

           $table->unsignedBigInteger('creditor_id')->nullable()->comment('الدائن');
                    $table->foreign('creditor_id')
                        ->references('id')->on('accounts')
                        ->onDelete('cascade');

            $table->unsignedBigInteger('debtor_id')->nullable()->comment('المدين');
            $table->foreign('debtor_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade');

            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')
                ->references('id')->on('coupons')
                ->onDelete('cascade');

            $table->double('total_price')->nullable()->default(0);
            $table->double('paid_price')->nullable()->default(0);
            $table->double('remaining_price')->nullable()->default(0);
            $table->double('discount_value')->nullable()->default(0);

            $table->date('date')->nullable();


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
        Schema::dropIfExists('sales');
    }
}
