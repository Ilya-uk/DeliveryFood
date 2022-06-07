@extends('auth.layouts.master')

@isset($courier)
    @section('title', 'Редактировать курьера ' .$courier->name)
@else
    @section('title', 'Создать курьера')
@endisset
@section('content')
    <div class="col-md-6 bg-light rounded-3 pb-3">
        @isset($courier)
            <h2>Редактировать курьера: <b>{{$courier->name}}</b></h2>
        @else
            <h2>Добавить курьера</h2>
        @endisset
        <form method="post"
              @isset($courier)action="{{route('couriers.update', $courier)}} @else action="{{route('couriers.store')}}@endisset
        ">
        <div>
            @isset($courier)
                @method('PUT')
            @endisset
            @csrf
            <div class="input-group row">
                <label for="name" class="col-sm-3 col-form-label">Имя: </label>
                <div class="col-sm-6">
                    @error('name')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                    <input type="text" class="form-control" name="name" id="name"
                           value="@isset($courier) {{$courier->name}}@endisset">
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="phone" class="col-sm-3 col-form-label">Номер телефона: </label>
                <div class="col-sm-6">
                    @error('phone')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                    <input type="tel" class="tel form-control" name="phone" id="phone"
                           value="@isset($courier) {{$courier->phone}}@endisset">
                </div>
            </div>
            <br>
            <button class="btn btn-success">Сохранить</button>
        </div>
        </form>
    </div>
@endsection
