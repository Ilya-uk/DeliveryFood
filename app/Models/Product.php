<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'article';


    protected $fillable = [
        'name', 'category_article', 'price', 'old_price', 'weight', 'composition', 'img', 'new', 'hit', 'discount',
    ];
//    Один ко одному
    public function category()
    {
        return $this->belongsTo(Category::class, )->withTrashed();
    }

    public function getPriceForCount()
    {
        if (!is_null($this->pivot)){
            return $this->pivot->count * $this->price;
        }
        return $this->price;
    }

    public function setNewAttribute($value)
    {
        $this->attributes['new'] = $value === 'on' ? 1 : 0;
    }

    public function setHitAttribute($value)
    {
        $this->attributes['hit'] = $value === 'on' ? 1 : 0;
    }

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = $value === 'on' ? 1 : 0;
    }

    public function isHit() {
        return $this->hit === 1;
    }

    public function isNew() {
        return $this->new === 1;
    }
    public function isDiscount() {
        return $this->discount === 1;
    }
}
