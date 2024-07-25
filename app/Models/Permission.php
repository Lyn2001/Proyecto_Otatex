<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Permission extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];


    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    // }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    // }
    public function roles()
{
    return $this->belongsToMany(Role::class, 'role_permissions');
}
}
