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
        'item_id',
        'amount',
        'code',
        'unit',
        'created_by',
        'status',
        'type',
        'begin_at',
        'end_at',
    ];

    public function detail_item() {
        return $this->belongsTo(DetailItem::class, 'detail_item_id', 'id');
    }
}
