@extends('layouts.main')

@section('title', 'Корзина')

@section('content')
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Корзина</h3>
                    <span class="breadcrumb"><a href="{{route('home')}}">Home</a>  >  Корзина</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <h1 class="mb-4 fw-bold">Корзина</h1>

        @if($items->isEmpty())
            <!-- Пустая корзина -->
            <div class="text-center py-5 my-5">
                <div class="display-1 text-muted mb-4">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h3 class="mb-3">Ваша корзина пуста</h3>
                <p class="text-muted mb-4">Пока в корзине нет товаров</p>
                <a href="{{ route('games.index') }}" class="btn btn-primary btn-lg px-5">
                    Перейти в магазин
                </a>
            </div>
        @else
            <!-- Есть товары -->
            <div class="row">
                <!-- Список товаров -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Игра</th>
                                        <th class="text-center">Цена</th>
                                        <th class="text-center">Количество</th>
                                        <th class="text-end pe-4">Сумма</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item->game->cover_image ?? asset('images/game-placeholder.jpg') }}"
                                                         alt="{{ $item->game->title }}"
                                                         class="me-3 rounded"
                                                         style="width: 80px; height: 45px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-0">
                                                            <a href="{{ route('games.show', $item->game) }}" class="text-dark text-decoration-none">
                                                                {{ $item->game->title }}
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">
                                                            {{ $item->game->platforms->pluck('name')->join(', ') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                @if($item->game->discount_price)
                                                    <del class="text-muted small">{{ number_format($item->price, 0, ',', ' ') }} $</del><br>
                                                    <strong class="text-danger">{{ number_format($item->game->current_price, 0, ',', ' ') }} $</strong>
                                                @else
                                                    <strong>{{ number_format($item->price, 0, ',', ' ') }} $</strong>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <form action="{{ route('cart.update', $item->game->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="input-group input-group-sm" style="width: 120px;">
                                                            <button type="button" class="btn btn-outline-secondary decrease-qty">-</button>
                                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control text-center qty-input">
                                                            <button type="button" class="btn btn-outline-secondary increase-qty">+</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>

                                            <td class="text-end pe-4">
                                                <strong>{{ number_format($item->subtotal, 0, ',', ' ') }} $</strong>
                                            </td>

                                            <td>
                                                <form action="{{ route('cart.remove', $item->game->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Удалить">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <a href="{{ route('games.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Продолжить покупки
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash me-2"></i>Очистить корзину
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Итоговая сумма и оформление -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Итого</h5>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Товары ({{ $items->sum('quantity') }}):</span>
                                <span>{{ number_format($total, 0, ',', ' ') }} $</span>
                            </div>

                            @if($total > 0)
                                <div class="d-flex justify-content-between mb-3 fw-bold fs-5 border-top pt-3">
                                    <span>К оплате:</span>
                                    <span class="text-primary">{{ number_format($total, 0, ',', ' ') }} $</span>
                                </div>
                                <a href="{{route('checkout.index')}}" class="btn btn-success btn-lg w-100 mt-3">
                                    Оформить заказ <i class="bi bi-arrow-right ms-2"></i>
                                </a>

                                <small class="d-block text-center text-muted mt-3">
                                    Нажимая «Оформить заказ», вы соглашаетесь с условиями
                                </small>
                            @else
                                <p class="text-center text-muted my-4">
                                    Добавьте товары в корзину, чтобы оформить заказ
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Увеличение/уменьшение количества
            document.querySelectorAll('.input-group').forEach(group => {
                const input = group.querySelector('.qty-input');
                const decrease = group.querySelector('.decrease-qty');
                const increase = group.querySelector('.increase-qty');

                if (!input || !decrease || !increase) return;

                decrease.addEventListener('click', () => {
                    let val = parseInt(input.value);
                    if (val > 1) {
                        input.value = val - 1;
                        input.closest('form').submit();
                    }
                });

                increase.addEventListener('click', () => {
                    let val = parseInt(input.value);
                    input.value = val + 1;
                    input.closest('form').submit();
                });

                input.addEventListener('change', () => {
                    if (input.value < 1) input.value = 1;
                    input.closest('form').submit();
                });
            });
        });
    </script>
@endsection
