<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Roles;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
{
    return $this->belongsTo(Roles::class); // Setiap user hanya memiliki 1 role
}




    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'role_permissions_users', 'user_id', 'permission_id')
            ->withPivot('role_id', 'user_id') // Menambahkan kolom pivot yang diperlukan
            ->withTimestamps()
            ->wherePivot('deleted_at', null);
    }
    
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_permissions_users', 'user_id', 'role_id')
            ->withPivot('permission_id')
            ->withTimestamps()
            ->wherePivot('deleted_at', null);
    }
}
