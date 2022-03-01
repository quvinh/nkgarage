<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Item extends Model
{
    use HasFactory,
        Notifiable;//

    protected $table = 'items';
    protected $fillable = [
       'id',
       'name',
       'note'
    ];

    public $incrementing = false;
    public $timestamps = false;
}
