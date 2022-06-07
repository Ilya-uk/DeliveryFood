<?php

namespace App\Classes;

use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Basket
{
    protected $order;

    /**
     *
     */
    public function __construct($createOrder = false)
    {
        $orderId = session('orderId');

        if (is_null($orderId) && $createOrder) {
            $data = [];
            if (Auth::check()) {
                $data['user_id'] = Auth::id();
            }

            $this->order = Order::create($data);
            session(['orderId' => $this->order->id]);
        } else {
            $this->order = Order::findOrFail($orderId);
        }
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function saveOrder($name, $phone, $email, $street, $house, $apartment, $summa)
    {
        Mail::to($email)->send(new OrderCreated($name, $this->getOrder()));
        return $this->order->saveOrder($name, $phone, $email, $street, $house, $apartment, $summa);
    }

    protected function getPivotRow($product)
    {
        return $this->order->products()->where('product_article', $product->article)->first()->pivot;
    }


    public function removeProduct(Product $product)
    {
        if ($this->order->products->contains($product->article)) {
            $pivotRow = $this->getPivotRow($product);
            if ($pivotRow->count < 2) {
                $this->order->products()->detach($product->article);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }
        }

    }

    public function addProduct(Product $product)
    {
        if ($this->order->products->contains($product->article)) {
            $pivotRow = $this->getPivotRow($product);
            $pivotRow->count++;
            $pivotRow->update();
        } else {
            $this->order->products()->attach($product->article);
        }

    }


}
