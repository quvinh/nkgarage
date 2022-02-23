<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Notifications\Notifiable;

class Item extends Model
{
    use HasFactory,
        Notifiable;//
=======


class Item extends Model
{
    use HasFactory;//
>>>>>>> vvuong

    protected $table = 'items';
    protected $fillable = [
        'id',
        'name',
        'note',
    ];

    
    public $incrementing = false;
}
