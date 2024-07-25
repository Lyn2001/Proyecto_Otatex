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
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id(); // Primary key for the sale details
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade'); // Foreign key referencing sales
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key referencing products
            $table->integer('cantidad'); // Quantity of the product sold
            $table->decimal('precio_unitario', 10, 2); // Unit price of the product
            $table->decimal('subtotal', 10, 2); // Subtotal for this product line
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
