<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Import extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'imports';
    protected $fillable = [
        'item_id',
        'amount',
        'unit',
        'status',
        'created_by',
        'note'
    ];

    public function item() {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
