<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Venta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fecha_venta',
        'total_venta',
        'metodo_pago',
    ];

    // Relación: una venta pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: una venta tiene muchos detalles de ventas
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }
}
