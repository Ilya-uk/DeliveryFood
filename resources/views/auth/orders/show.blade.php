@extends('auth.layouts.master')

@section('title', 'Заказ ' . $order->id)

@section('content')
    <div class="justify-content-center col-md-10 bg-light rounded-3 pb-3">
        <h2>Заказ №{{ $order->id }}</h2>
        <p>Заказчик: <b>{{ $order->name }}</b></p>
        <p>Номер телeфона: <b>{{ $order->phone }}</b></p>
        <p>Email: <b>{{ $order->email }}</b></p>
        <p>Адрес: <b> ул.{{ $order->street }} д.{{ $order->house }} кв.{{ $order->apartment }}</b></p>
        @if($order['status'] == 1)
            <p>Статус: <b>В обработке</b></p>
        @endif
        @if($order['status'] == 2)
            <p>Статус: <b>Отправлен</b></p>
        @endif
        @if($order['status'] == 3)
            <p>Статус: <b>Завершен</b></p>
        @endif
        @if($order['status'] == 4)
            <p>Статус: <b>Отменен</b></p>
        @endif
        @if($order['status'] == 2 || $order['status'] == 3)
            <p>Курьер: <b>{{$order->courier->name}}</b></p>
            <p>Курьер: <b>{{$order->courier->phone}}</b></p>
        @endif
        <p>Дата создания: <b>{{ $order->created_at->format('d.m.Y H:i')}}</b></p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <img height="56px" alt=""
                             @if(!is_null($product->img)) src="{{Storage::url($product->img)}}"
                             @else src="/storage/products/no-image.png" @endif>
                        {{ $product->name }}
                    </td>
                    <td><span class="cart__quantity">{{$product->pivot->count}}</span></td>
                    <td>{{ $product->price }}₽</td>
                    <td>{{ $product->getPriceForCount()}}₽</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Общая стоимость:</td>
                <td>{{ $order->getFullPrice() }}₽</td>
            </tr>
            </tbody>
        </table>
        @admin
        <br>
        @if($order['status'] == 1)

            <h3>Назначить курьера</h3>
            <form method="POST" action="{{ route('orders.update', $order) }}">

                <div class="input-group row">
                    <label for="courier_id" class="col-sm-1 col-form-label">Курьер: </label>
                    <div class="col-sm-2">
                        <select name="courier_id" id="courier_id" class="form-control">
                            @foreach($couriers as $courier)
                                <option value="{{$courier->courier_id}}"
                                        @isset($order) @if($order->courier_id == $courier->courier_id)
                                        selected @endif @endisset>{{$courier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <button class="btn btn-success">Назначить</button>
                @csrf
            </form>
            <br>
            <form method="POST" action="{{ route('orders.cancel', $order) }}">
                <button class="btn btn-danger">Отменить</button>
                @csrf
            </form>
        @endif



        @if($order['status'] == 2)
            <form method="POST" action="{{ route('orders.complete', $order) }}">
                <button class="btn btn-success">Завершить</button>
                @csrf
            </form>
        @endif
        @else
            @if($order['status'] == 3)
                <a href="{{route('person.word',$order) }}" class="btn btn-md btn-success">Скачать чек</a>
            @endif
            @if($order['status'] == 1)
                <form method="POST" action="{{ route('person.orders.cancel', $order) }}">
                    <button class="btn btn-danger">Отменить</button>
                    @csrf
                </form>
            @endif
            @endadmin
    </div>
@endsection
