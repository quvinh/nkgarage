<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailItem extends Model
{
    use HasFactory,
    SoftDeletes;

    protected $table = 'detail_items';

    protected $fillable = [
        'item_id',
        'category_id',
        'warehouse_id',
        'shelf_id',
        'batch_code',
        'amount',
        'unit',
        'price',
        'suppliers_id',
        'status',
    ];

    public $timestamps = false;

    public function item() {
        return $this->hasOne(Item::class);
    }

    public function category() {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public function shelf() {
        return $this->belongsTo(Shelves::class, 'shelf_id', 'id');
    }

    public function warehouse() {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function suppliers() {
        return $this->belongsTo(Suppliers::class, 'suppliers_id', 'id');
    }
    
}
