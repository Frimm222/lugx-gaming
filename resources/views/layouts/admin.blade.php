<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — Админ-панель</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @stack('styles')
</head>
<body>

<div class="d-flex">
    <!-- Боковое меню (sidebar) -->
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white" style="width: 280px; min-height: 100vh;">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i class="bi bi-controller fs-3 me-2"></i>
            <span class="fs-4">Админ-панель</span>
        </a>
        <hr class="text-white">

        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-house-door me-2"></i> Дашборд
                </a>
            </li>
            <li>
                <a href="{{ route('admin.games.index') }}" class="nav-link text-white {{ request()->routeIs('admin.games.*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-joystick me-2"></i> Игры
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-people me-2"></i> Пользователи
                </a>
            </li>
            <!-- Можно добавить позже: Заказы, Отзывы, Жанры и т.д. -->
        </ul>

        <hr class="text-white">

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle fs-4 me-2"></i>
                <strong>Администратор</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Выйти
                    </a></li>
            </ul>

            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Основной контент -->
    <div class="flex-grow-1 p-4 bg-light">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
