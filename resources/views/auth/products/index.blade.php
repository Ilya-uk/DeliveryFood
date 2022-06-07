@extends('auth.layouts.master')

@section('title', 'Продукты')

@section('content')


    <div class="col-md-12 bg-light rounded-3 pb-3">
        <h2 class="pb-2">Продукты</h2>
        <form method="GET" action="{{route('products.index')}}">
            <div class="filters row pb-3">
                <div class="col-sm-10 col-md-8 d-md-flex gap-md-3">
                    <div class="mb-2">
                        <label for="search">Поиск:
                            <input type="text" name="search" id="search" size="6"
                                   value="{{ request()->search }}">
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="category">Категория:
                            <select name="category" style="padding: 3px">
                                <option value="">Все</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->article}}"
                                            @if($category->article == request()->category) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
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
                        <label for="category_trashed">Продукты
                            <select name="category_trashed" style="padding: 3px">
                                <option value="">Без скрытых</option>
                                <option @if(request()->category_trashed == 1)selected @endif value="1">Скрытые</option>
                                <option @if(request()->category_trashed == 2)selected @endif value="2">Все</option>
                            </select>
                        </label>
                    </div>


                </div>
                <div class="col-sm-6 col-md-3">
                    <button type="submit" class="btn btn-success">Фильтр</button>
                    <a href="{{ route('products.index') }}" class="btn btn-warning">Сброс</a>
                </div>
            </div>
        </form>
        <div class="table-responsive-sm">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Название
                    </th>
                    <th>
                        Категория
                    </th>
                    <th>
                        Цена
                    </th>
                    <th>
                        Действия
                    </th>
                </tr>
                @foreach($products as $product)
                    @if(!$product->category->trashed())
                        <tr>
                            <td>{{ $product->article}}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->price }}₽</td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($product->trashed())
                                        <form action="{{ route('products.restore', $product) }}" method="POST">
                                            <button class="btn btn-success" type="submit">Востановить</button>
                                            @csrf
                                        </form>
                                    @else
                                        <form action="{{ route('products.destroy', $product) }}" method="POST">
                                            <a class="btn btn-success" type="button"
                                               href="{{ route('products.show', $product) }}">Открыть</a>
                                            <a class="btn btn-warning" type="button"
                                               href="{{ route('products.edit', $product) }}">Редактировать</a>
                                            @csrf
                                            @method('DELETE')
                                            <input class="btn btn-danger" type="submit" value="Удалить">
                                        </form>
                                    @endif
                                </div>

                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        @if($bestProducts->count() >= 3)
            <h3 class="text-center">Топ 3</h3>

            <div class="justify-content-center row row-cols-1 row-cols-md-4 g-4 text-center pt-3 pb-3">
                @foreach($bestProducts as $product)
                    <a href="{{ route('products.show', $product) }} " style="text-decoration: none; color: black">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <img @if(!is_null($product->img)) src="{{Storage::url($product->img)}}"
                                     @else src="/storage/products/no-image.png" @endif class="card-img-top"
                                     alt="{{$product->name}}" style="cursor: pointer;">
                                <h5 class="card-title text-center">{{$product->name}}</h5>
                            </div>
                        </div>
                    </div>
                    </a>
                @endforeach


            </div>
        @endif

        <br>

        {{ $products->links() }}

        <a class="btn btn-success" type="button" href="{{ route('products.create') }}">Добавить товар</a>


    </div>

@endsection
