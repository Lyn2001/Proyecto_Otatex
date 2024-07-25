<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Order extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    
    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function product(){
        return $this->hasOne('App\Models\Product','id','pro_id');
    }
}