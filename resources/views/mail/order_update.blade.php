<style>
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
        <p>Заказ №{{ $order->id }}</p>
        <p>Уважаемый(ая) {{ $order->name }}!</p>
        <p>Ваш заказ на сумму {{ $order->summa }}₽ принят!</p>
        <p>Дата и время: {{ $order->updated_at->format('d.m.Y H:i')}}</p>
        <p>Примерное время доставки 60 минут</p>
    </div>
    <div class="info">
        <p>Ваши данные:</p>
        <hr>
        <p>Номер телефона: {{ $order->phone }}</p>
        <p>Улица: {{ $order->street }}</p>
        <p>Дом: {{ $order->house }}</p>
        <p>Квартира: {{ $order->apartment }}</p>
        <p>Данные курьера:</p>
        <hr>
        <p>Имя: {{ $order->courier->name }}</p>
        <p>Номер телефона: {{ $order->courier->phone }}</p>
    </div>
    <div class="info">
        <p>Информация о платеже:</p>
        <hr>
        Способ оплаты: при получении
        <hr>
    </div>
    <div class="text-center">
        <p style="text-align: center;">Доставка еды «Доставка»</p>
        <p style="text-align: center;">450077, г. Уфа, ул. Ленина, д.5</p>
        <p style="text-align: center;">Наш телефон +7 (999) 999 9999</p>
    </div>
</div>
