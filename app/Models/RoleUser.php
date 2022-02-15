<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_users';
    protected $primary_key = null;
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'roles_id',
    ];

    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function roles() {
        return $this->belongsTo(Roles::class);
    }
}
