<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Transfers extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'transfers';
    protected $fillable = [
        'item_id',
        'code',
        'amount',
        'unit',
        'category_id',
        'supplier_id',
        'from_warehouse',
        'to_warehouse',
        'from_shelf',
        'to_shelf',
        'note',
        'status',
        'created_by',
    ];

    public function detail_item() {
        return $this->belongsTo(DetailItem::class, 'detail_item_id', 'id');
    }
}
