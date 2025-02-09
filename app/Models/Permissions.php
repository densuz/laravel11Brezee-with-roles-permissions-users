<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissions extends Model
{
    use SoftDeletes;

    protected $table = 'permissions';
    protected $guarded = ['id'];
    protected $fillable = ['permission_name', 'description'];
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_permissions_users')
            ->withPivot('role_id', 'description')
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_permissions_users', 'permission_id', 'role_id');
    }
}
