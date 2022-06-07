<style>
    table {
        border-spacing: 0 10px;
        font-family: 'Open Sans', sans-serif;
        font-weight: bold;
    }

    th {
        padding: 10px 20px;
        background: #56433D;
        color: #F9C941;
        border-right: 2px solid;
        font-size: 0.9em;
    }

    th:first-child {
        text-align: left;
    }

    th:last-child {
        border-right: none;
    }

    td {
        vertical-align: middle;
        padding: 10px;
        font-size: 14px;
        text-align: center;
        border-top: 2px solid #56433D;
        border-bottom: 2px solid #56433D;
        border-right: 2px solid #56433D;
    }

    td:first-child {
        border-left: 2px solid #56433D;
        border-right: none;
    }

    td:nth-child(2) {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .main {
        width: 750px;
        margin: auto;
        background-color: white;
    }
</style>

<div class="main">
    <div class="text-center">
        <p>Уважаемый(ая) {{ $name }}!</p>
        <p>Благодарим вас за оформление заказа</p>
        <p>Ваш заказ на сумму {{ $fullSum }}₽ отправлен в обработку!</p>
    </div>
    <div class="info">
        <p>Информация о вашем заказе:</p>
        <hr>
        <p>Заказ №{{ $order->id }}</p>
        <p> Дата заказа {{ $order->updated_at->format('d.m.Y H:i')}}</p>
    </div>
    <div class="content">
        <p>Содержимое вашего заказа:</p>
        <hr>
        <table>
            <thead>
            <tr>
                <th style="border-left: 2px solid;" colspan="2">Название</th>
                <th>Количество</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td style="border-left: 2px solid;">
                        <img width="45" height="45"
                             @if(!is_null($product->img))src="{{ $message->embed(Storage::url($product->img))}}"
                             @else src="{{ $message->embed(public_path('/storage/products/no-image.png'))}}"
                             @endif alt="{{$product->name}}">
                    </td>
                    <td>
                        <h4>{{ $product->name }}</h4>
                    </td>
                    <td>
                        <p>{{ $product->pivot->count }}</p>
                    </td>
                    <td>{{ $product->price }}₽</td>
                </tr>
            @endforeach
            <tr>
                <td style="border-left: 2px solid; text-align: left;" colspan="3">Общая стоимость:</td>
                <td><b>{{ $fullSum }}₽</b></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="info">
        <p>Информация о платеже:</p>
        <hr>
        Способ оплаты: при получении
        <hr>
    </div>
    <div class="text-center">
        <p>Доставка еды «Доставка»</p>
        <p>450077, г. Уфа, ул. Ленина, д.5</p>
        <p>Наш телефон +7 (999) 999 9999</p>
    </div>
</div>
