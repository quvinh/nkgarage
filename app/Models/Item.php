<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Item extends Model
{
    use HasFactory,
        Notifiable,
        SoftDeletes;//

    protected $table = 'items';
    protected $fillable = [
        'id',
        'batch_code',
        'name',
        'amount',
        'unit',
        'price',
        'status',
        'note',
    ];

    public $incrementing = false;
}
