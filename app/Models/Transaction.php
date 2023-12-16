<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'items_id', 'stock', 'sold', 'dates'
    ];

    public function items()
    {
        return $this->belongsTo(Item::class, 'items_id', 'id');
    }

    public function scopeStr($query, $str)
    {
        if ($str) {
            $query->where(function($q) use($str){
                $q->whereHas('items', function($q1) use($str) {
                    $q1->where('name', 'ilike', "%$str%");
                });
            });
        }
    }

    public function scopeNameSort($query, $sort)
    {
        switch ($sort) {
            case 'asc':
                $query->orderBy('items.name', 'asc');
                break;
            
            case 'desc':
                $query->orderBy('items.name', 'desc');
                break;

            default: break;
        }
    }

    public function scopeDateSort($query, $sort)
    {
        switch ($sort) {
            case 'asc':
                $query->orderBy('transactions.dates', 'asc');
                break;
            
            case 'desc':
                $query->orderBy('transactions.dates', 'desc');
                break;

            default: break;
        }
    }
}
