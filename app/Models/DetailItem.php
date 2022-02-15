<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailItem extends Model
{
    use HasFactory;

    protected $table = 'detail_items';

    protected $fillable = [
        'item_id',
        'category_id',
        'warehouse_id',
        'shelf_if'
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
        return $this->belongsTo(Warehouse::class, 'shelf_id', 'id');
    }
}
