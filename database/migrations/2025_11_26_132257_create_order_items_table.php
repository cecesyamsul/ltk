<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions.order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');   // relasi ke orders
            $table->unsignedBigInteger('product_id'); // relasi ke products
            $table->integer('qty');
            $table->integer('subtotal');
            $table->boolean('is_active')->default(true); 
            $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // foreign key constraints
            $table->foreign('order_id')
                ->references('id')
                ->on('transactions.orders')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('transactions.products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions.order_items');
    }
};
