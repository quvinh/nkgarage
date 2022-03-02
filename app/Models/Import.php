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
        'code',
        'batch_code',
        'warehouse_id',
        'category_id',
        'shelf_id',
        'name',
        'amount',
        'unit',
        'price',
        'status',
        'suppliers_id',
        'created_by',
        'note'
    ];

    public function item() {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function suppliers() {
        return $this->belongsTo(Suppliers::class, 'suppliers_id', 'id');
    }
}
