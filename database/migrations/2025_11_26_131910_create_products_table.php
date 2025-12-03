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

        Schema::create('transactions.products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('harga', 15, 2);
            $table->integer('stok_awal');
            $table->integer('stok');
            $table->integer('stok_semu')->default(0); 
            $table->string('image_url')->nullable(); 
            $table->boolean('is_active')->default(true); 
            $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate(); 
            $table->unsignedBigInteger('created_by')->nullable(); 
            $table->unsignedBigInteger('updated_by')->nullable(); 
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
        Schema::dropIfExists('transactions.products');
    }
};
