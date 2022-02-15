<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRoles extends Model
{
    use HasFactory;

    protected $table = 'permission_roles';
    protected $primary_key = null;
    public $incrementing = false;
    protected $fillable = [
        'roles_id',
        'permission_id',
    ];

    public $timestamps = false;

    public function roles() {
        return $this->belongsTo(Roles::class);
    }

    public function permission() {
        return $this->belongsTo(Permissions::class);
    }
}
