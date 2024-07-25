<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'product_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    // Relación: un detalle de venta pertenece a una venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    // Relación: un detalle de venta pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
