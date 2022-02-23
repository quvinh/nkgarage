<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Shelves extends Model
{
<<<<<<< HEAD
    use HasFactory,
        Notifiable;

    protected $table = 'items';
    protected $fillable = [
        'id',
        'name',
        'position',
    ];

    
    public $incrementing = false;
=======
    use HasFactory;
    protected $table = 'shelves';
    protected $fillable = [
        'name',
        'position'
    ];

    public $timestamps = false;
>>>>>>> vvuong
}
