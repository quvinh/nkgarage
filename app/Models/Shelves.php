<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Shelves extends Model
{
    use HasFactory,
        Notifiable;

    protected $table = 'shelves';
    protected $fillable = [
        'name',
        'position',
    ];

    public $timestamps = false;
    // public $incrementing = false;
}
