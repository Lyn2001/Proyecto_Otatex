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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id(); // Primary key for the sales table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key referencing users
            $table->date('fecha_venta'); // Date of the sale (changed from dateTime to date)
            $table->decimal('total_venta', 10, 2); // Total amount of the sale
            $table->string('metodo_pago'); // Payment method
            $table->decimal('iva', 8, 2); // Added IVA column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
