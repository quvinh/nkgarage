<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $fillable = [
        'code',
        'name',
        'supplier_initials',
        'email',
        'address',
        'contact_person',
        'phone',
        'note',
    ];

    public $timestamps = false;
}
