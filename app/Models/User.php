<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;


class User extends Authenticatable implements MustVerifyEmail, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identification',
        'firstname',
        'secondname',
        'firstlastname',
        'secondlastname',
        'email',
        'phone1',
        'phone2',
        'address',
        'password',
        'rol_id', // Agrega rol_id a los atributos asignables
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Boot function to hook into Eloquent events.
     */
    protected static function boot()
    {
        parent::boot();

        // Asignar rol por defecto al crear un nuevo usuario
        static::creating(function ($user) {
            if (!$user->rol_id) {
                $user->rol_id = Role::where('rol_name', 'user')->value('id');
            }
        });
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public function hasPermission($permission)
    {
        if (!$this->role) {
            Log::info('User has no role');
            return false;
        }

        if (!$this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
        }

        $permissions = $this->role->permissions->pluck('name')->toArray();
        Log::info('Role permissions:', ['permissions' => $permissions]);

        $hasPermission = in_array($permission, $permissions);
        Log::info('Has permission:', ['permission' => $permission, 'has' => $hasPermission]);

        return $hasPermission;
    }
    // Relación: un usuario tiene muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}

