<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_revenues', function (Blueprint $table) {
            $table->id();

            $table->enum('type',['expense','revenues'])->nullable()->comment('expense مصوفات');

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


            $table->double('total_price')->nullable()->default(0);
            
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
        Schema::dropIfExists('expense_revenues');
    }
}
