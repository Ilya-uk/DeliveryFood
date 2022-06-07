@extends('layouts.app')

@section('title', 'Доставка')



@section('content')
    <section class="container__carousel">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">

                    <img src="../img/banner.png" class="d-block w-100" alt="...">
                    <div class="position-absolute top-50 start-50 translate-middle text-white text-center rounded-3"
                         style="background: rgba(0,0,0,0.5)"><h3>Планируете отметить <br>День рождения?</h3>
                        <p>Дарим скидку 15%</p>
                        <p>В день рождения, три дня
                            до три дня после. Акции
                            и скидки не суммируются.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="../img/banner2.png" class="d-block w-100" alt="...">
                    <div class="position-absolute top-50 start-50 translate-middle text-white text-center rounded-3"
                         style="background: rgba(0,0,0,0.5)">
                        <h3>Планируете отметить <br>День рождения?</h3>
                        <p>Дарим скидку 15%</p>
                        <p>В день рождения, три дня
                            до три дня после. Акции
                            и скидки не суммируются.</p>
                    </div>
                </div>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Предыдущий</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Следующий</span>
            </button>
        </div>
    </section>


    <section id="menu">
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded" aria-label="Eleventh navbar example">
            <div class="container">
                <button class="navbar-toggler collapsed " type="button" data-bs-toggle="collapse"
                        data-bs-target="#filter_dishes" aria-controls="filter_dishes" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="h3-menu-header ">
                    <h3>Меню</h3>
                </div>

                <div class="basket__cart cart" tabindex="0">
                    <div class="cart__text d-flex ">
                        <a style="text-decoration: none; color: black; display: flex" href="{{route('basket')}}">
                            <h3>Корзина</h3>
                        </a>
                    </div>
                </div>
                <div class="sticky-header navbar-collapse justify-content-center collapse" id="filter_dishes">
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link " data-filter="all" style="cursor: pointer">Все блюда</a>
                        </li>
                        @foreach($categories as $category)
                            <li class="nav-item">
                                <a style="cursor: pointer" class="nav-link "
                                   data-filter="{{$category->name}}">{{$category->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
    </section>
    <section id="product" class="container">
        <div class="bg-light mb-4 p-2 rounded-bottom ">
            <form method="GET" action="{{route('home')}}">
                <div class="filters row">
                    <div class="col-sm-6 col-md-3">
                        <label for="price_from">Цена от
                            <input type="text" name="price_from" id="price_from" size="6"
                                   value="{{ request()->price_from}}">
                        </label>
                        <label for="price_to">до
                            <input type="text" name="price_to" id="price_to" size="6" value="{{ request()->price_to }}">
                        </label>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <label for="hit">
                            <input type="checkbox" name="hit" id="hit" @if(request()->has('hit')) checked @endif> Хит
                            продаж
                        </label>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <label for="new">
                            <input type="checkbox" name="new" id="new" @if(request()->has('new')) checked @endif>
                            Новинка
                        </label>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <label for="discount">
                            <input type="checkbox" name="discount" id="discount"
                                   @if(request()->has('discount')) checked @endif> Скидка
                        </label>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" class="btn btn-success">Фильтр</button>
                        <a href="{{ route('home') }}" class="btn btn-warning">Сброс</a>
                    </div>
                </div>
            </form>
        </div>
        @if(session()->has('success'))
            <p class="po alert alert-success text-center">{{session()->get('success')}}</p>
        @endif
        @if(session()->has('warning'))
            <p class="po alert alert-warning text-center">{{session()->get('warning')}}</p>
        @endif
        @if($bestProducts->count() >= 3)
            <div class="top-products">
                <h3 class="text-center text-white">Популярные продукты</h3>
                <div class="d-md-flex justify-content-between gap-md-3">
                    @foreach($bestProducts as $product)
                        <div class="card mb-3" style="width: 415px; cursor: pointer;"
                             data-bs-toggle="modal" data-bs-target="#exampleModal{{ $product->article }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <img @if(!is_null($product->img)) src="{{Storage::url($product->img)}}"
                                         @else src="/storage/products/no-image.png" @endif class="card-img-top"
                                         alt="{{$product->name}}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body-top">
                                        <h5 class="card-title text-center">{{$product->name}}</h5>
                                        <p class="card-text">{{$product->price}}₽</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif


        <div class="row row-cols-1 row-cols-md-3 g-4 ">
            @foreach($products as $product)


                <div class="modal fade" id="exampleModal{{ $product->article }}" tabindex="-1"
                     aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card ">
                                <div class="labels">
                                    @if($product->isNew())
                                        <span class="badge bg-success">Новинка</span>
                                    @endif

                                    @if($product->isHit())
                                        <span class="badge bg-danger">Хит продаж!</span>
                                    @endif
                                    @if($product->isDiscount())
                                        <span class="badge bg-warning">Акция</span>
                                    @endif
                                </div>
                                <img @if(!is_null($product->img)) src="{{Storage::url($product->img)}}"
                                     @else src="/storage/products/no-image.png" @endif class="card-img-top" alt="..."
                                     data-bs-toggle="modal"
                                     data-bs-target="#exampleModal">
                                <div class="card-body">
                                    <h4 class="text-center">{{$product->name}}</h4>
                                    <p style="font-size: 16px;">Состав: {{ $product->composition }}</p>
                                    <div class="col-12 mt-4 d-flex justify-content-between">
                                        <div class="d-flex col-10">
                                            <span class="card-text card-price">{{$product->price}}₽</span>
                                            @if($product['old_price'] != 0)
                                                <span
                                                    class="card-text card-price fs-5 text-decoration-line-through price__disabled">{{$product->old_price}}₽</span>
                                            @endif
                                        </div>
                                        <div class="card-text-weight col-2 mt-3">
                                            <span>{{$product->weight}}</span>
                                        </div>
                                    </div>
                                    <form action="{{route('basket-add',$product)}}" method="post">
                                        <button type="submit" role="button"
                                                class="btn btn-warning col-12 product__btn  btn-lg">В корзину
                                        </button>
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col" data-category="{{ $product->category->name }}">
                    <div class="card ">
                        <div class="labels">
                            @if($product->isNew())
                                <span class="badge bg-success">Новинка</span>
                            @endif

                            @if($product->isHit())
                                <span class="badge bg-danger">Хит продаж!</span>
                            @endif
                            @if($product->isDiscount())
                                <span class="badge bg-warning">Акция</span>
                            @endif
                        </div>
                        <img @if(!is_null($product->img)) src="{{Storage::url($product->img)}}"
                             @else src="/storage/products/no-image.png" @endif class="card-img-top"
                             alt="{{$product->name}}" data-bs-toggle="modal"
                             data-bs-target="#exampleModal{{ $product->article }}" style="cursor: pointer">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{$product->name}}</h5>
                            <div class="row mt-4 d-flex">
                                <div class="d-flex col-6">
                                    <span class="card-text card-price">{{$product->price}}₽</span>
                                    @if($product['old_price'] != 0)
                                        <span
                                            class="card-text card-price fs-5 text-decoration-line-through price__disabled">{{$product->old_price}}₽</span>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <form action="{{route('basket-add',$product)}}" method="post">
                                        <button type="submit" role="button"
                                                class="btn btn-warning col-12 product__btn  btn-lg">В корзину
                                        </button>
                                        @csrf
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </section>

    <section class="address mt-5">
        <div class="container-wrap">
            <div class="wrap d-md-flex">
                <div class="info">
                    <div class="row no-gutters">
                        <div class="col d-flex">
                            <div class="text-white pop-up-content">
                                <h3>+7 (999) 999 9999</h3>
                                <p>Наш номер</p>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <div class="text-white pop-up-content">
                                <h3>Мы открыты каждый день</h3>
                                <p>8:00 - 23:00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social d-md-flex pl-md-5 p-4 align-items-center">
                    <div class="col d-flex">
                        <div class="text-white pop-up-content">
                            <h3>Наш адрес</h3>
                            <p>450077, г. Уфа, ул. Ленина, д.5</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about-company d-md-flex ">
        <div class="one-half img"></div>
        <div class="one-half">
            <div class="text-white text-center pop-up-content">
                <h2>«Доставка» - это место вкусной еды и хорошего настроения!</h2>
                <p>Откройте для себя богатство изысканных вкусов, воспользовавшись услугой доставки еды на дом. В нашем
                    меню каждый найдет что-то подходящее для себя.
                    Для вас – акции.
                </p>
            </div>
        </div>
    </section>
    <section class="our_services pb-5 ">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mt-5 text-white pop-up-content">
                    <h2>Наш сервис</h2>
                </div>
            </div>
            <div class="row text-center mt-5 text-white pop-up-content">
                <div class="col-md-4 ">
                    <img src="/img/salad_white.png" alt="" width="60">
                    <h3>Полезная еда</h3>
                </div>
                <div class="col-md-4">
                    <img src="/img/fast-delivery_white.png" alt="" width="60">
                    <h3>Быстрая доставка</h3>
                </div>
                <div class="col-md-4">
                    <img src="/img/recipe-book_white.png" alt="" width="60">
                    <h3>Оригинальные рецепты</h3>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer ">
        <div class="container">
            <div class="row justify-content-between pt-5 pb-5">
                <div class="col-md-4 text-white">
                    2022© Доставка — ресторан доставки в Уфе
                    Доставка еды на дом и в офис в Уфе
                    Все права защищены
                </div>

                <div class="col-md-4 ">
                    <div class="d-flex gap-2">
                        <img src="img/pin.png" width="30">
                        <a class="content text-white">
                            450077, г. Уфа,
                            ул. Ленина, д.5
                        </a>
                    </div>

                    <div class="d-flex gap-2">
                        <img src="img/mail.png" width="30">
                        <a href="mailto:example@gmail.com" class="text-white">example@gmail.com</a>
                    </div>

                    <div class="d-flex gap-2">
                        <img src="img/telephone.png" width="30">
                        <a href="tel:+89999999999" class="text-white">8(999) 999-99-99</a>
                    </div>

                </div>
            </div>
        </div>
    </footer>

@endsection

