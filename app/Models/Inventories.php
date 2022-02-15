<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Inventories extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'inventories';
    protected $fillable = [
        'detail_item_id',
        'department',
        'description',
        'created_by',
    ];

    public function detail_item() {
        return $this->belongsTo(DetailItem::class, 'detail_item_id', 'id');
    }
}
