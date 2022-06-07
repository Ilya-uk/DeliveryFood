<table>
    <thead>
    <tr>
        <th style="border: red; width: 100px; text-align: center;"><b>Номер заказа</b></th>
        <th style="width: 125px; text-align: center;"><b>Имя</b></th>
        <th style="width: 125px; text-align: center;"><b>Телефон</b></th>
        <th style="width: 150px; text-align: center;"><b>Email</b></th>
        <th style="width: 125px; text-align: center;"><b>Улица</b></th>
        <th style="width: 100px; text-align: center;"><b>Дом</b></th>
        <th style="width: 100px; text-align: center;"><b>Квартира</b></th>
        <th style="width: 75px; text-align: center;"><b>Сумма</b></th>
        <th style="width: 150px; text-align: center;"><b>Дата создания</b></th>
    </tr>

    </thead>
    <tbody>

    @foreach($orders as $order)
        <tr>
            <td style=" text-align: left; ">{{ $order->id }}</td>
            <td style="text-align: left; ">{{ $order->name }}</td>
            <td style="text-align: left; ">{{ $order->phone }}</td>
            <td style="text-align: left; ">{{ $order->email }}</td>
            <td style="text-align: left; ">{{ $order->street }}</td>
            <td style="text-align: left; ">{{ $order->house }}</td>
            <td style="text-align: left; ">{{ $order->apartment }}</td>
            <td style="text-align: left; ">{{ $order->summa }}</td>
            <td style="text-align: left; ">{{ $order->created_at }}</td>
        </tr>
        <br>
    @endforeach
    </tbody>
</table>
