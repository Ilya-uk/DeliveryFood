@extends('layouts.app')

@section('title', 'Потверждение почты')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Подтвердите свой Email</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">На ваш Email была отправлена ссылка для подтверждения.
                        </div>
                    @endif
                        Прежде чем продолжить, пожалуйста, проверьте свою электронную почту на наличие ссылки для подтверждения.
                        Если вы не получили электронное письмо,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">нажмите здесь, чтобы запросить письмо еще раз</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
