@extends('layouts.main')

@section('content')
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Регистрация</h3>
                    <span class="breadcrumb"><a href="{{route('home')}}">Home</a> >  Регистрация</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-lg border-0 mt-5">
                    <div class="card-header bg-success text-white text-center py-4">
                        <h3 class="mb-0">Регистрация</h3>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label fw-bold">Имя / Ник в игре</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="nickname" class="form-label fw-bold">Никнейм (опционально)</label>
                                    <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror"
                                           name="nickname" value="{{ old('nickname') }}">
                                    @error('nickname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="password" class="form-label fw-bold">Пароль</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password" required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="password_confirmation" class="form-label fw-bold">Повторите пароль</label>
                                    <input id="password_confirmation" type="password" class="form-control"
                                           name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="mb-4 form-check">
                                <input class="form-check-input" type="checkbox" name="agree_terms" id="agree_terms" required>
                                <label class="form-check-label" for="agree_terms">
                                    Я согласен с <a href="#" class="text-primary">правилами и политикой конфиденциальности</a>
                                </label>
                                @error('agree_terms')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">Создать аккаунт</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p>Уже есть аккаунт? <a href="{{ route('login') }}" class="text-primary fw-bold">Войти</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
