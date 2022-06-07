<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'article';

    protected $fillable = ['name'];

    public $timestamps = false;

//    Один ко многим
    public function products(){
        return $this->hasMany(Product::class);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($category) {
            $category->products()->delete();
        });
    }
}
