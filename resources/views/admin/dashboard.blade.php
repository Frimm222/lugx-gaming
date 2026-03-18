@extends('layouts.admin')

@php
    use App\Models\Game;
    use App\Models\User;
    use App\Models\Order;
@endphp

@section('title', 'Дашборд')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">Добро пожаловать в админ-панель</h1>

        <div class="row g-4">
            <!-- Статистика (можно расширить) -->
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Игр в каталоге</h5>
                        <h2>{{ Game::count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Пользователей</h5>
                        <h2>{{ User::count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Заказов</h5>
                        <h2>{{ Order::count() ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Выручка</h5>
                        <h2>{{ number_format(Order::where('status', 'paid')->sum('total') ?? 0, 2) }} $</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-4">
            <i class="bi bi-info-circle me-2"></i>
            Используйте боковое меню слева для перехода к управлению играми и пользователями.
        </div>
    </div>
@endsection
