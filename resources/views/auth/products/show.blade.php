@extends('auth.layouts.master')

@section('title', 'Продукт ' . $product->name)

@section('content')
    <div class="col-md-8 bg-light rounded-3 pb-3">
        <h2>{{ $product->name }}</h2>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Поле
                </th>
                <th>
                    Значение
                </th>
            </tr>
            <tr>
                <td>#</td>
                <td>{{ $product->article}}</td>
            </tr>
            <tr>
                <td>Цена</td>
                <td>{{ $product->price }}₽</td>
            </tr>
            <tr>
                <td>Название</td>
                <td>{{ $product->name }}</td>
            </tr>
                       <tr>
                <td>Состав</td>
                <td>{{ $product->composition }}</td>
            </tr>
            <tr>
                <td>Вес</td>
                <td>{{ $product->weight }}</td>
            </tr>

            <tr>
                <td>Изображение</td>
                <td><img alt="" @if(!is_null($product->img)) src="{{Storage::url($product->img)}}"
                         @else src="/storage/products/no-image.png" @endif height="240px"></td>
            </tr>
            <tr>
                <td>Категория</td>
                <td>{{ $product->category->name }}</td>
            </tr>
            <tr>
                <td>Теги</td>
                <td>
                    @if($product->isNew())
                        <span class="badge bg-success">Новинка</span>
                    @endif

                    @if($product->isHit())
                        <span class="badge bg-danger">Хит продаж!</span>
                    @endif
                    @if($product->isDiscount())
                        <span class="badge bg-warning">Скидка</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Дата создания</td>
                <td>{{ $product->created_at->format('d.m.Y H:i') }}</td>
            </tr>
            <tr>
                <td>Дата обновления</td>
                <td>{{ $product->updated_at->format('d.m.Y H:i') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
