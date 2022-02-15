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
        'detail_item_id',
        'amount',
        'unit',
        'from',
        'to',
        'note',
        'status',
        'created_by',
    ];

    public function detail_item() {
        return $this->belongsTo(DetailItem::class, 'detail_item_id', 'id');
    }
}
