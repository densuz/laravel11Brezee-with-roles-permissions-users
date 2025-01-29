<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'roles';
    protected $fillable = ['name', 'description'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    // public function users()
    // {
    //     return $this->belongsToMany('App\Models\User');
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_permissions_users')
        // return $this->belongsToMany(User::class)

            ->withPivot('permission_id', 'description')
            ->withTimestamps();
    }


    // public function permissions()
    // {
    //     return $this->belongsToMany('App\Models\Permissions');
    // }

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'role_permissions_users')
        // return $this->belongsToMany(Permissions::class)

            ->withPivot('user_id', 'description')
            ->withTimestamps();
    }



    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->first() ? true : false;
    }

    public function assignPermission($permission)
    {
        return $this->permissions()->attach($permission);
    }

    public function removePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }


    // public function assignRole($role)
    // {
    //     return $this->roles()->attach($role);
    // }

    // public function removeRole($role)
    // {
    //     return $this->roles()->detach($role);
    // }

    // public function hasRole($role)
    // {
    //     return $this->roles()->where('name', $role)->first() ? true : false;
    // }

    // public function roles()
    // {
    //     return $this->belongsToMany('App\Models\Roles');
    // }

}
