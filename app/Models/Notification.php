<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $fillable = [
        'title',
        'content',
        'created_by',
        'warehouse_id',
        'send_to',
        'status',
        // 'type',
    ];
}
