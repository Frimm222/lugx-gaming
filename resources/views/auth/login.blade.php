@extends('layouts.main')

@section('content')
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Авторизация</h3>
                    <span class="breadcrumb"><a href="{{route('home')}}">Home</a> >  Авторизация</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 mt-5">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">Вход в аккаунт</h3>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">Пароль</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Запомнить меня</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Войти</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p>Нет аккаунта? <a href="{{ route('register') }}" class="text-primary fw-bold">Зарегистрироваться</a></p>
                            <!-- <p><a href="#" class="text-muted">Забыли пароль?</a></p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
