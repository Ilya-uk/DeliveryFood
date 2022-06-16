@extends('auth.layouts.master')

@isset($category)
    @section('title', 'Редактировать категорию ' .$category->name)
@else
    @section('title', 'Создать категорию')
@endisset
@section('content')
    <div class="col-md-6 bg-light rounded-3 pb-3">
        @isset($category)
            <h2>Редактировать категорию: <b>{{$category->name}}</b></h2>
        @else
        <h2>Добавить категорию</h2>
        @endisset
        <form method="post" @isset($category)action="{{route('categories.update', $category)}} @else action="{{route('categories.store')}}@endisset">
            <div>
                @isset($category)
                @method('PUT')
                @endisset
                @csrf
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">
                        @error('name')
                        <div class="text-danger mx-auto col-12 ">{{$message}}</div>
                        @enderror
                        <input type="text" class="form-control" name="name" id="name" value="{{ old ('name')}} @isset($category) {{$category->name}} @endisset">
                    </div>
                </div>
                <br>
                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
