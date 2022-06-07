@extends('auth.layouts.master')

@section('title', 'Категории')

@section('content')
    <div class="col-md-8 bg-light rounded-3 pb-3">
        <h2>Категории</h2>
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>#</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
            @foreach($categories as $category)
                <tr>
                    <td>{{$category->article}}</td>
                    <td>{{$category->name}}</td>
                    <td>
                        <div class="btn-group" role="group">
                            @if($category->trashed())
                                <form action="{{ route('categories.restore', $category) }}" method="POST">
                                    <button class="btn btn-success" type="submit">Востановить</button>
                                    @csrf
                                </form>
                            @else
                                <form enctype="multipart/form-data"
                                      action="{{ route('categories.destroy' ,$category) }}" method="post">
                                    <a class="btn btn-warning" href="{{route('categories.edit' , $category)}}"
                                       type="button">Редактировать</a>
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Удалить">
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
        <a class="btn btn-success" type="button" href="{{ route('categories.create') }}">Добавить категорию</a>
    </div>
@endsection


