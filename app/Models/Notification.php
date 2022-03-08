<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $fillable = [
        'detail_item_id',
        'item_id',
        'item_name',
        'title',
        'content',
        'amount',
        'warehouse_id',
        'unit',
        'created_by',
        'code',
        'status',
    ];

    public function detail_item() {
        return $this->belongsTo(DetailItem::class, 'detail_item_id', 'id');
    }
}
