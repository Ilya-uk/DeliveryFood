<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'courier_id';

    protected $fillable = ['name', 'phone', 'status'];

    public $timestamps = false;

    //    Один ко многим
    public function orders()
    {
        return $this->hasMany(Order::class)->withTrashed();
    }


}
