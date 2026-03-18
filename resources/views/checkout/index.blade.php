@extends('layouts.main')

@section('content')
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Оформление заказа</h3>
                    <span class="breadcrumb"><a href="{{route('home')}}">Home</a>  >  Оформление заказа</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <h1 class="mb-4">Оформление заказа</h1>

        <div class="row">
            <div class="col-lg-8">
                <!-- Обзор корзины -->
                <div class="card mb-4">
                    <div class="card-header">Ваши товары</div>
                    <div class="card-body">
                        @foreach($items as $item)
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <strong>{{ $item->game->title }}</strong> × {{ $item->quantity }}
                                </div>
                                <div>{{ number_format($item->subtotal, 0, ',', ' ') }} ₽</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Форма оплаты -->
                <form method="POST" action="{{ route('checkout.process') }}">
                    @csrf

                    <div class="card mb-4">
                        <div class="card-header">Способ оплаты</div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="card" value="card" checked>
                                <label class="form-check-label" for="card">Банковская карта</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="balance" value="balance">
                                <label class="form-check-label" for="balance">С баланса ({{ Auth::user()->balance }} ₽)</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="agree_terms" id="agree_terms" required>
                        <label class="form-check-label" for="agree_terms">
                            Я согласен с <a href="#">условиями покупки</a>
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            Оплатить {{ number_format($total, 0, ',', ' ') }} ₽
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5>Итого к оплате</h5>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-4">
                            <span>Сумма:</span>
                            <span>{{ number_format($total, 0, ',', ' ') }} ₽</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
