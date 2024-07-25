<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Role extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $fillable = [
        'rol_name',
        'rol_description',
    ];

    // Define the relationship with the Role model
    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    // }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
    
}
