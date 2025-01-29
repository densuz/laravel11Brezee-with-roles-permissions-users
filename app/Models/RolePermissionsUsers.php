<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermissionsUsers extends Model
{
    use SoftDeletes;
    
    protected $table = 'role_permissions_users';
    protected $fillable = ['role_id', 'permission_id', 'description'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $guarded = ['id'];
    public $timestamps = true;
    public $incrementing = true;
    protected $dates = ['deleted_at'];
}
