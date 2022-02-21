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
        'detail_item_id',
        'amount',
        'unit',
        'status',
        'created_by',
        'note'
    ];

    public function detail_item() {
        return $this->belongsTo(Item::class, 'detail_item_id', 'id');
    }
}
