@extends('layouts.main')

@section('title', 'Мой профиль')

@section('content')
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Мой профиль</h3>
                    <span class="breadcrumb"><a href="{{route('home')}}">Home</a>  >  Мой профиль</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <!-- Основная информация о профиле -->
                <div class="card shadow border-0 mb-5">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">Мой профиль</h3>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-5">
                            <img src="{{ $user->profile_photo_url }}"
                                 alt="{{ $user->display_name }}"
                                 class="rounded-circle mb-4 shadow"
                                 style="width: 140px; height: 140px; object-fit: cover; border: 5px solid white;">

                            <h4 class="mb-1">{{ $user->display_name }}</h4>
                            <p class="text-muted mb-2">{{ $user->email }}</p>

                            @if($user->nickname)
                                <span class="badge bg-info">@ {{ $user->nickname }}</span>
                            @endif
                        </div>

                        <hr class="my-4">

                        <div class="row g-4 text-center text-md-start">
                            <div class="col-md-4">
                                <h6 class="text-muted">Имя</h6>
                                <p class="fw-bold mb-0">{{ $user->name }}</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-muted">Страна</h6>
                                <p class="fw-bold mb-0">{{ $user->country ?? '—' }}</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-muted">Баланс</h6>
                                <p class="fw-bold text-success mb-0">
                                    {{ number_format($user->balance, 2, ',', ' ') }} $
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary px-5">
                                Редактировать профиль
                            </a>
                        </div>
                    </div>
                </div>

                <!-- История заказов -->
                <div class="card shadow border-0 mb-5">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">История заказов</h5>
                    </div>

                    @if($user->orders->isEmpty())
                        <div class="card-body text-center py-5">
                            <i class="bi bi-receipt fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-2">У вас пока нет заказов</p>
                            <a href="{{ route('games.index') }}" class="btn btn-outline-primary">
                                Перейти в магазин
                            </a>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($user->orders as $order)
                                <div class="list-group-item px-4 py-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <div>
                                            <strong class="d-block mb-1">
                                                Заказ №{{ $order->order_number }}
                                            </strong>
                                            <small class="text-muted">
                                                {{ $order->created_at->format('d.m.Y H:i') }}
                                            </small>
                                        </div>

                                        <div class="text-end">
                                        <span class="badge bg-{{ $order->status === 'paid' ? 'success' : 'warning' }} mb-2">
                                            {{ $order->status === 'paid' ? 'Оплачен' : 'В обработке' }}
                                        </span>
                                            <div class="fw-bold text-primary">
                                                {{ number_format($order->total, 0, ',', ' ') }} $
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <small>
                                            @foreach($order->items as $item)
                                                {{ $item->game->title ?? 'Игра удалена' }} × {{ $item->quantity }}
                                                @if(!$loop->last) • @endif
                                            @endforeach
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Купленные игры (уникальные) -->
                <div class="card shadow border-0">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Мои купленные игры</h5>
                    </div>

                    @php
                        $purchasedGames = $user->orders->flatMap->items->pluck('game')->unique('id');
                    @endphp

                    @if($purchasedGames->isEmpty())
                        <div class="card-body text-center py-5">
                            <i class="bi bi-joystick fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-2">У вас пока нет купленных игр</p>
                            <a href="{{ route('games.index') }}" class="btn btn-outline-primary">
                                Посмотреть каталог
                            </a>
                        </div>
                    @else
                        <div class="row g-3 p-3">
                            @foreach($purchasedGames as $game)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                                        <a href="{{ route('games.show', $game->slug) }}">
                                            <img src="{{ $game->cover_image ?? asset('images/game-placeholder.jpg') }}"
                                                 class="card-img-top" alt="{{ $game->title }}"
                                                 style="height: 140px; object-fit: cover;">
                                        </a>
                                        <div class="card-body text-center p-3">
                                            <h6 class="mb-1">
                                                <a href="{{ route('games.show', $game->slug) }}" class="text-dark text-decoration-none">
                                                    {{ Str::limit($game->title, 28) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                {{ $game->platforms->pluck('name')->join(', ') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .hover-shadow:hover {
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
            transform: translateY(-3px);
            transition: all 0.2s;
        }
    </style>
@endsection
