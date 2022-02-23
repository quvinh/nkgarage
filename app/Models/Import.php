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
<<<<<<< HEAD
        'item_id',
        // 'detail_item_id',
        'batch_code',
        'warehouse_id',
        'category_id',
        'shelf_id',
        'name',
=======
        'detail_item_id',
>>>>>>> vvuong
        'amount',
        'unit',
        'price',
        'status',
        'suppliers_id',
        'created_by',
        'note'
    ];
<<<<<<< HEAD
    public function item() {
        return $this->belongsTo(Item::class, 'item_id', 'id');
=======

    public function detail_item() {
        return $this->belongsTo(Item::class, 'detail_item_id', 'id');
>>>>>>> vvuong
    }
}
