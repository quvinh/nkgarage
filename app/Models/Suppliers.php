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
    ];

    public $incrementing = false;
    
    public function import() {
        return $this->belongsTo(Import::class, 'suppliers_id', 'id');
    }
}
