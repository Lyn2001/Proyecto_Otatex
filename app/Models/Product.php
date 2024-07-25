<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    //Pilas esto se subio por sugenencia del chat del video 20
    protected $fillable = [
        'pro_name',
        'pro_description',
        'pro_image',
        'pro_price',
        'category',
        'pro_stock',
    ];
    public function ventas()
    {
        return $this->belongsToMany(Venta::class)->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }
}
