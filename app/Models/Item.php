<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name', 'types_id'
    ];

    public function item_type()
    {
        return $this->belongsTo(ItemType::class, 'types_id', 'id');
    }

    public function scopeStr($query, $str)
    {
        if ($str) {
            $query->where(function($q) use($str){
                $q->where('name', 'ilike', "%$str%");
                $q->orWhereHas('item_type', function($q1) use($str) {
                    $q1->where('type_name', 'ilike', "%$str%");
                });
            });
        }
    }
}
