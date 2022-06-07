@extends('auth.layouts.master')

@isset($product)
    @section('title', 'Редактировать продукт ' . $product->name)
@else
    @section('title', 'Добавить продукт')
@endisset

@section('content')
    <div class="col-md-8 bg-light rounded-3 pb-3">
        @isset($product)
            <h2>Редактировать продукт <b>{{ $product->name }}</b></h2>
        @else
            <h2>Добавить продукт</h2>
        @endisset
        <form method="POST" enctype="multipart/form-data"
              @isset($product)
              action="{{ route('products.update', $product) }}"
              @else
              action="{{ route('products.store') }}"
            @endisset>
            <div>
                @isset($product)
                    @method('PUT')
                @endisset
                @csrf
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">
                        @error('name')
                        <div class="text-danger mx-auto col-12 ">{{$message}}</div>
                        @enderror
                        <input type="text" class="form-control" name="name" id="name"
                               value="@empty('name') {{ old ('name')}} @endempty @isset($product){{ $product->name }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="category_article" class="col-sm-2 col-form-label">Категория: </label>
                    <div class="col-sm-6">
                        <select name="category_article" id="category_article" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{$category->article}}"
                                        @isset($product) @if($product->category_article == $category->article)
                                        selected @endif @endisset>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="composition" class="col-sm-2 col-form-label">Состав:</label>
                    <div class="col-sm-6">
                        @error('composition')
                        <div class="text-danger mx-auto col-12 ">{{$message}}</div>
                        @enderror
                        <textarea name="composition" id="composition" cols="52"
                                  rows="2">@empty('composition'){{ old ('composition')}}  @endempty @isset($product){{ $product->composition }}@endisset</textarea>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="weight" class="col-sm-2 col-form-label">Вес: </label>
                    <div class="col-sm-6">
                        @error('weight')
                        <div class="text-danger mx-auto col-12 ">{{$message}}</div>
                        @enderror
                        <textarea name="weight" class="col-3" id="weight" placeholder="256г" cols="7" rows="1"
                        >@empty('weight') {{ old ('weight')}} @endempty @isset($product){{ $product->weight }}@endisset</textarea>
                    </div>
                </div>

                <br>
                <div class="input-group row">
                    <label for="price" class="col-sm-2 col-form-label">Цена: </label>
                    <div class="col-sm-2">
                        @error('price')
                        <div class="text-danger mx-auto col-12 ">{{$message}}</div>
                        @enderror
                        <input type="text" class="form-control" name="price" id="price"
                               value="@empty('price'){{ old ('price')}} @endempty @isset($product){{ $product->price }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="old_price" class="col-sm-2 col-form-label">Старая цена: </label>
                    <div class="col-sm-2">
                        @error('old_price')
                        <div class="text-danger ">{{$message}}</div>
                        @enderror
                        <input disabled type="text" class="form-control" name="old_price" id="old_price"
                               value="@empty('old_price') {{ old ('old_price')}}@endempty @isset($product){{ $product->old_price }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="img" class="col-sm-2 col-form-label">Картинка: </label>
                    <div class="col-sm-10">
                        <label for="img" style="display: none" class="btn btn-default btn-file">Загрузить</label>
                        <input type="file" name="img" id="img">
                    </div>
                </div>
                <br>
                @foreach ([
                'hit' => 'Хит',
                'new' => 'Новинка',
                'discount' => 'Акция',
                ] as $field => $title)
                    <div class="form-group row">
                        <label for="$field" class="col-sm-2 col-form-label">{{ $title }}: </label>
                        <div class="col-sm-10">
                            <input type="checkbox" name="{{$field}}" id="{{$field}}"
                                   @if(isset($product) && $product->$field === 1)
                                   checked="checked"
                                @endif
                            >
                        </div>
                    </div>
                    <br>
                @endforeach
                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
