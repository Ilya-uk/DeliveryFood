@extends('auth.layouts.master')

@section('title', 'Заказы')

@section('content')

    <div class="col-md-10 bg-light rounded-3 pb-3">
        <h2>Заказы</h2>
        @admin
        <div class="my-3">
            <form method="GET" action="{{route('orders')}}">
                <div class="filters row">
                    <div class="col-sm-8 col-md-6 d-md-flex gap-md-3">
                        <div class="mb-2">
                            <label for="price_from">Сумма от
                                <input type="text" name="price_from" id="price_from" size="6"
                                       value="{{ request()->price_from}}">
                            </label>
                            <label for="price_to">до
                                <input type="text" name="price_to" id="price_to" size="6"
                                       value="{{ request()->price_to }}">
                            </label>
                        </div>
                        <div class="mb-2">
                            <label for="status">Статус:
                                <select name="status" id="status" style="padding: 3px">
                                    <option value="">Все</option>
                                    <option @if(request()->status == 1)selected @endif value="1">В обработке</option>
                                    <option @if(request()->status == 2)selected @endif value="2">Отправлен</option>
                                    <option @if(request()->status == 3)selected @endif value="3">Завершен</option>
                                    <option @if(request()->status == 4)selected @endif value="4">Отменен</option>
                                </select>
                            </label>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-3 mb-2">
                        <button type="submit" class="btn btn-success">Фильтр</button>
                        <a href="{{ route('orders') }}" class="btn btn-warning">Сброс</a>
                    </div>
                </div>
            </form>
        </div>
        @endadmin
        <div class="table-responsive-sm">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Имя
                    </th>
                    <th>
                        Телефон
                    </th>
                    <th>
                        Дата создания
                    </th>
                    <th>
                        Сумма
                    </th>
                    <th>
                        Статус
                    </th>
                    <th>
                        Действия
                    </th>
                </tr>

                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i')}}</td>
                        <td>{{ $order->getFullPrice()}}₽
                        @if($order['status'] == 1)
                            <td>В обработке</td>
                        @endif
                        @if($order['status'] == 2)
                            <td>Отправлен</td>
                        @endif
                        @if($order['status'] == 3)
                            <td class="text-success">Завершен</td>
                        @endif
                        @if($order['status'] == 4)
                            <td class="text-danger">Отменен</td>
                        @endif
                        <td>
                            <div class="btn-group" role="group">
                                <a class="btn btn-success" type="button"
                                   @admin
                                   href="{{ route('orders.show', $order) }}"
                                   @else
                                   href="{{ route('person.orders.show', $order) }}"
                                    @endadmin
                                >Открыть</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <br>


        @admin

        <div class="row">
            <form action="{{route('admin-word')}}" method="GET">
                <h5>Журнал учета</h5>
                <div class="d-md-flex gap-2">
                    <div>
                        <span>C</span>
                        <label for="date_from">
                            <input type="date" style="width:140px" class="form-control" name="date_from">
                        </label>
                        <span>По</span>
                        <label for="date_to">
                            <input type="date" style="width:140px" class="form-control" name="date_to">
                        </label>
                    </div>
                    <button type="submit" href="{{route('admin-word',$orders) }}" class="btn btn-md btn-success">
                        Скачать
                    </button>
                </div>
            </form>

        </div>
        <br>
        @endadmin
        {{ $orders->links() }}
    </div>
    @if(session()->has('warning'))
        <script>
            alert("{{session()->get('warning')}}");
        </script>
    @endif
@endsection
