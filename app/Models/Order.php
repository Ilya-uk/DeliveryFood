<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'courier_id'];

    // Многие ко многим
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count');
    }

    // Один  ко одному
    public function user()
    {
        return $this->belongsTo(User::class);
    }

//    Один ко одному
    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id')->withTrashed();
    }

    public function getFullPrice()
    {
        $sum = 0;
        foreach ($this->products()->withTrashed()->get() as $product) {
            $sum += $product->getPriceForCount();
        }
        return $sum;
    }

    public function saveOrder($name, $phone, $email, $street, $house, $apartment, $summa)
    {
        if ($this->status == 0) {
            $this->name = $name;
            $this->phone = $phone;
            $this->email = $email;
            $this->street = $street;
            $this->house = $house;
            $this->apartment = $apartment;
            $this->summa = $summa;
            $this->status = 1;
            $this->save();

            session()->forget('orderId');
            return true;
        } else {
            return false;
        }

    }
}
