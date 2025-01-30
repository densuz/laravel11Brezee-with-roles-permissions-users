<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roles extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'roles';
    protected $fillable = ['name', 'description'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    

    //  public function permissions()
    // {
    //     return $this->belongsToMany(Permissions::class, 'role_permissions_users', 'role_id', 'permission_id')
    //         // ->withTimestamps()
    //         ->wherePivot('deleted_at', null);
    // }

    public function permissions()
{
    return $this->belongsToMany(Permissions::class, 'role_permissions_users', 'role_id', 'permission_id');
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
