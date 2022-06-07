@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    <div class="container justify-content-center bg-light mt-5 pb-4">
        <h2 class="card-header">Корзина</h2>
        <p>Оформление заказа</p>
        <div class="panel">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Стоимость</th>
                </tr>
                </thead>
                @foreach($order->products as $product)
                    <tbody>
                    <tr>
                        <td>
                            <img height="46px" class="rounded-3" alt="{{$product->name}}"
                                 @if(!is_null($product->img)) src="{{Storage::url($product->img)}}" @else src="/storage/products/no-image.png" @endif>{{$product->name}}
                        </td>
                        <td>
                            <span class="cart__quantity">{{$product->pivot->count}}</span>
                            <div class="btn-group">
                                <form action="{{route('basket-remove', $product)}}" method="post">
                                    <button type="submit" class="btn btn-danger">
                                        <span>-</span>
                                    </button>
                                    @csrf
                                </form>
                                <form action="{{route('basket-add', $product)}}" method="post">
                                    <button type="submit" class="btn btn-success">
                                        <span>+</span>
                                    </button>
                                    @csrf
                                </form>
                            </div>
                        </td>
                        <td>{{$product->price}}₽</td>
                        <td>{{$product->getPriceForCount()}}₽</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Общая стоимость:</td>
                        <td>{{$order->getFullPrice()}}₽</td>
                    </tr>
                    </tbody>
            </table>
            <br>
            <a type="button" class="btn btn-success" href="{{route('home')}}">Заказать еще</a>
            <a type="button" class="btn btn-success" href="{{route('basket-place')}}">Оформить заказ</a>

        </div>
    </div>
@endsection

