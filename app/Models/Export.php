<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Export extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'exports';
    protected $fillable = [
        'item_id',
        'name',
        'code',
        'warehouse_id',
        'supplier_id',
        'shelf_id',
        'amount',
        'price',
        'unit',
        'status',
        'note',
        'created_by',
    ];

    public function detail_item() {
        return $this->belongsTo(DetailItem::class, 'item_id', 'id');
    }
    public function item() {
        return $this->hasOne(Item::class);
    }
}
