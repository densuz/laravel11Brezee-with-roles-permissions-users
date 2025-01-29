<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Roles;
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

    // public function roles()
    // {
    //     return $this->belongsToMany(Roles::class);
    // }

    public function rolesAndPermissions()
    {
        return $this->belongsToMany(Roles::class, 'role_permissions_users', 'user_id', 'role_id')
        // return $this->belongsToMany(Roles::class)

            ->withPivot('permission_id', 'description')
            ->withTimestamps()
            ->wherePivot('deleted_at', null); // Hanya Mengambil data yang tidak soft delete
    }



    // OPTIONAL
    // public function roles()
    // {
    //     return $this->belongsToMany(Roles::class, 'role_permissions_users')
    //         ->withPivot('permission_id', 'description')
    //         ->withTimestamps();
    // }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permissions::class, 'role_permissions_users')
    //         ->withPivot('role_id', 'description')
    //         ->withTimestamps();
    // }
}
