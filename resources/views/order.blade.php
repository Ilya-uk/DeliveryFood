@extends('layouts.app')
@section('title', 'Корзина')

@section('content')
    <div class="container text-center bg-light mt-5 p-4 col-md-5 rounded-3">
        <h1>Подтвердите заказ:</h1>
        <div class="row justify-content-center">
            <p>Общая стоимость заказа: <b>{{$order->getFullPrice()}} ₽</b></p>
            <form action="{{ route('basket-confirm') }}" method="post">
                <div>
                    <p>Укажите свои данные:</p>
                    <div class="container">
                        <div class="form-group">
                            @guest

                                <label for="name" class="control-label col-lg-offset-3 col-lg-8">Имя:</label>
                                <div class="col-lg-4 m-auto">
                                    @error('name')
                                    <div class="text-danger mx-auto col-12 ">{{$message}}</div>
                                    @enderror
                                    <input type="text" name="name" id="name" value="{{ old ('name')}}"
                                           class="form-control" required>
                                </div>

                                <label for="phone" class="control-label col-lg-offset-3 col-lg-8">Номер
                                    телефона:</label>
                                <div class="col-lg-4 m-auto">
                                    @error('phone')
                                    <div class="text-danger mx-auto col-12">{{$message}}</div>
                                    @enderror
                                    <input type="tel" name="phone" id="phone" value="{{ old ('phone')}}"
                                           placeholder="+7 (999) 999 99-99"
                                           class="tel form-control" required>
                                </div>

                                <label for="email" class="control-label col-lg-offset-3 col-lg-8">Email:</label>
                                <div class="col-lg-4 m-auto">
                                    <input type="email" name="email" id="email" value="{{ old ('email')}}"
                                           class="form-control"
                                           autocomplete="email" required>
                                </div>

                                <label for="street" class="control-label col-lg-offset-3 col-lg-8">Улица:</label>
                                <div class="col-lg-4 m-auto">
                                    @error('street')
                                    <div class="text-danger mx-auto col-12">{{$message}}</div>
                                    @enderror
                                    <input type="text" name="street" id="street" value="{{ old ('street')}}"
                                           class="form-control"
                                           required>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <label for="house" class="control-label col-lg-2">Дом:</label>
                                    <label for="apartment"
                                           class="control-label col-lg-2">Квартира:</label>
                                </div>


                                <div class="d-flex justify-content-center gap-1">
                                    <div class="col-lg-2 ">
                                        <input type="text" name="house" id="house" value="{{ old ('house')}}"
                                               class="form-control"
                                               required>
                                        @error('house')
                                        <div class="text-danger mx-auto col-12">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2 ">
                                        <input type="text" name="apartment" id="apartment"
                                               value="{{ old ('apartment')}}" class="form-control"
                                               required>
                                        @error('apartment')
                                        <div class="text-danger mx-auto col-12">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <input type="text" name="summa" id="summa" value="{{$order->getFullPrice()}}" hidden
                                       class="form-control">
                            @endguest
                            @auth
                                <label for="name" class="control-label col-lg-offset-3 col-lg-8">Имя:</label>
                                <div class="col-lg-4 m-auto">
                                    @error('name')
                                    <div class="text-danger mx-auto col-12">{{$message}}</div>
                                    @enderror
                                    @if($order['user_id'])
                                        <input type="text" name="name" id="name" value="{{$order->user->name}}"
                                               class="form-control" hidden>
                                        <div class="d-inline-flex gap-3">
                                            <p class="textName"><b>{{$order->user->name}}</b></p>
                                            <p class="nameBtn link-primary pointer">Изменить</p>
                                        </div>
                                    @else
                                        <input type="text" name="name" id="name" value="{{ old ('name')}}"
                                               class="form-control" required>
                                    @endif
                                </div>


                                <label for="phone" class="control-label col-lg-offset-3 col-lg-8">Номер
                                    телефона:</label>
                                <div class="col-lg-4 m-auto">
                                    @error('phone')
                                    <div class="text-danger mx-auto col-12">{{$message}}</div>
                                    @enderror
                                    @if($order['user_id'])
                                    <input type="tel" name="phone" id="phone" value="{{$order->user->phone}}"
                                           placeholder="+7 (999) 999 99-99"
                                           class="tel form-control" hidden>
                                    <div class="d-inline-flex gap-3">
                                        <p class="textPhone"><b>{{$order->user->phone}}</b></p>
                                        <p class="phoneBtn link-primary pointer">Изменить</p>
                                    </div>
                                    @else
                                        <input type="tel" name="phone" id="phone" value="{{ old ('phone')}}"
                                               placeholder="+7 (999) 999 99-99"
                                               class="tel form-control" required>
                                    @endif
                                </div>

                                <label for="email" class="control-label col-lg-offset-3 col-lg-8">Email:</label>
                                <div class="col-lg-4 m-auto ">
                                    @if($order['user_id'])
                                    <input type="email" name="email" id="email" value="{{$order->user->email}}"
                                           class="form-control" autocomplete="email" hidden>
                                    <div class="d-inline-flex gap-3">
                                        <p class="textEmail"><b>{{$order->user->email}}</b></p>
                                        <p class="emailBtn link-primary pointer">Изменить</p>
                                    </div>
                                    @else
                                        <input type="email" name="email" id="email" value="{{ old ('email')}}"
                                               class="form-control"
                                               autocomplete="email" required>
                                    @endif
                                </div>


                                <label for="street" class="control-label col-lg-offset-3 col-lg-8">Улица:</label>
                                <div class="col-lg-4 m-auto">
                                    @error('street')
                                    <div class="text-danger mx-auto col-12">{{$message}}</div>
                                    @enderror
                                    <input type="text" name="street" id="street" value="" class="form-control"
                                           required>
                                </div>

                                <div class="d-flex justify-content-center">

                                    <label for="house" class="control-label col-lg-2">Дом:</label>
                                    <label for="apartment"
                                           class="control-label col-lg-2">Квартира:</label>

                                </div>


                                <div class="d-flex justify-content-center gap-1">

                                    <div class="col-lg-2 ">
                                        <input type="text" name="house" id="house" value="{{ old ('house')}}"
                                               class="form-control"
                                               required>
                                        @error('house')
                                        <div class="text-danger mx-auto col-12">{{$message}}</div>
                                        @enderror
                                    </div>


                                    <div class="col-lg-2 ">
                                        <input type="text" name="apartment" id="apartment"
                                               value="{{ old ('apartment')}}" class="form-control"
                                               required>
                                        @error('apartment')
                                        <div class="text-danger mx-auto col-12">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>



                                <input type="text" name="summa" id="summa" value="{{$order->getFullPrice()}}" hidden
                                       class="form-control">
                            @endauth
                        </div>
                    </div>
                    <br>
                    @csrf
                    <input type="submit" class="btn btn-success col-lg-3" value="Подтвердить заказ">
                </div>
            </form>
        </div>
    </div>
@endsection
