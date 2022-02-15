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
        'title',
        'content',
        'amount',
        'unit',
        'created_by',
    ];

    public function detail_item() {
        return $this->belongsTo(DetailItem::class, 'detail_item_id', 'id');
    }
}
