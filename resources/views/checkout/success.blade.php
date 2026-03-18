@extends('layouts.main')

@section('content')
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Заказ</h3>
                    <span class="breadcrumb"><a href="{{route('home')}}">Home</a>  >  Заказ</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5 text-center">
        <div class="display-1 text-success mb-4"><i class="bi bi-check-circle-fill"></i></div>
        <h1>Спасибо за заказ!</h1>
        <h4 class="mb-4">Номер заказа: <strong>{{ $order->order_number }}</strong></h4>
        <p>Сумма: <strong>{{ number_format($order->total, 0, ',', ' ') }} ₽</strong></p>
        <p>Статус: Оплачено</p>

        <div class="my-5">
            <h5>Ваши покупки:</h5>
            <ul class="list-group">
                @foreach($order->items as $item)
                    <li class="list-group-item">
                        {{ $item->game->title }} × {{ $item->quantity }} — {{ number_format($item->subtotal, 0, ',', ' ') }} ₽
                    </li>
                @endforeach
            </ul>
        </div>

        <a href="{{ route('profile.show') }}" class="btn btn-primary btn-lg">В личный кабинет</a>
        <a href="{{ route('games.index') }}" class="btn btn-outline-secondary btn-lg ms-3">Продолжить покупки</a>
    </div>
@endsection
