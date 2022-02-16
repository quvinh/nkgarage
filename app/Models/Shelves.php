<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelves extends Model
{
    use HasFactory;
    protected $table = 'shelves';
    protected $fillable = [
        'name',
        'position',
        'note',
    ];

    public $timestamps = false;
}
