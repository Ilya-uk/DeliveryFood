<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BasketController extends Controller
{
    public function basket()
    {
        $order = (new Basket())->getOrder();

        return view('basket', compact('order'));
    }

    public function basketConfirm(OrderRequest $request)
    {
        $success = (new Basket())->saveOrder(
            $request->name,
            $request->phone,
            $request->email,
            $request->street,
            $request->house,
            $request->apartment,
            $request->summa, );

        if ($success) {
            session()->flash('success', 'Ваш заказ принят в обработку!');
        } else {
            session()->flash('warning', 'Ошибка!');
        }

        return redirect()->route('home');
    }


    public function basketPlace()
    {
        $order = (new Basket())->getOrder();
        return view('order', compact('order'));
    }


    public function basketAdd(Product $product)
    {
        (new Basket(true))->addProduct($product);

        session()->flash('success', 'Добавлен продукт '.$product->name);

        return redirect()->back();
    }

    public function basketRemove(Product $product)
    {

        (new Basket())->removeProduct($product);

        return redirect()->route('basket');

    }
}
