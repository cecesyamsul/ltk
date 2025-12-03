<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // status_order = 0=pending,1=kirim bukti bayar,2=konfirmasi bukti bayar,3= selesai packing,4=kirim,5=selesai
        Schema::create('transactions.orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->integer('total')->default(0);
            $table->integer('status_order')->default(0);
            $table->boolean('is_active')->default(true); 
            $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('payment_proof')->nullable(); 
            $table->timestamps();
            $table->foreign('user_id')

                ->references('id')->on('master.users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions.orders');
    }
};
