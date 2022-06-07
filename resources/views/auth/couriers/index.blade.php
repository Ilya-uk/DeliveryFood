@extends('auth.layouts.master')

@section('title', 'Курьеры')

@section('content')
    <div class="col-md-8 bg-light rounded-3 pb-3">
        <h2>Курьеры</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Номер телефона</th>
                    <th>Активные заказы</th>
                    <th>Действия</th>
                </tr>
                @foreach($couriers as $courier)
                    <tr>
                        <td>{{$courier->courier_id}}</td>
                        <td>{{$courier->name}}</td>
                        <td>{{$courier->phone}}</td>
                        <td>{{$courier->count_orders}}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <form enctype="multipart/form-data" action="{{ route('couriers.destroy' ,$courier) }}"
                                      method="post">
                                    <a class="btn btn-warning" href="{{route('couriers.edit' , $courier)}}"
                                       type="button">Редактировать</a>
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Удалить">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <br>
        {{ $couriers->links() }}
        <a class="btn btn-success" type="button" href="{{ route('couriers.create') }}">Добавить курьера</a>
    </div>
@endsection


