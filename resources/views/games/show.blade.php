@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.main')

@section('title', 'Игра')

@section('content')

    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{$game->title}}</h3>
                    <span class="breadcrumb"><a href="{{route('home')}}">Home</a>  >  <a
                            href="{{route('games.index')}}">Игры</a>  >  {{$game->title}}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="single-product section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-image">
                        <img src="{{asset("$game->cover_image")}}" alt="{{$game->game_id_code}}">
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <h4>{{$game->title}}</h4>
                    <span class="price">
                    @if ($game->discount_price != null)
                            <em>{{$game->price}}$</em>{{$game->discount_price}}$
                        @else
                            {{$game->price}}$
                        @endif
                </span>
                    <p>{{$game->short_description}}</p>
                    <a href="{{route('games.addToCart', $game)}}"
                       style="display: inline-block; background-color: #ee626b; text-transform: uppercase; color: #fff; font-size: 14px; font-weight: 600; height: 50px; line-height: 50px; padding: 0px 30px; border-radius: 25px; transition: all .3s;">
                        В КОРЗИНУ</a>
                    <ul>
                        <li><span>Game ID:</span> {{$game->game_id_code}}</li>
                        <li><span>Genre:</span>
                            @foreach($game->genres as $genre)
                                <a href="#">{{$genre->name}} |</a>
                            @endforeach
                        </li>
                        <li><span>Tags:</span>
                            @foreach($game->tags as $tag)
                                <a href="#">{{$tag->name}} |</a>
                            @endforeach
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="sep"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="more-info">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-content">
                        <div class="row">
                            <div class="nav-wrapper ">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                                data-bs-target="#description" type="button" role="tab"
                                                aria-controls="description" aria-selected="true">Описание
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                                                data-bs-target="#reviews" type="button" role="tab"
                                                aria-controls="reviews" aria-selected="false">Отзывы
                                            ({{ $game->review_count }})
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel"
                                     aria-labelledby="description-tab">
                                    <p>{{$game->description}}</p>
                                    <br>
                                    <p>{{$game->description}}</p>
                                </div>
                                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                    <div class="reviews-section mt-5">

                                        <!-- Общий рейтинг -->
                                        <div class="card mb-4 border-0 shadow-sm bg-light">
                                            <div class="card-body text-center">
                                                <div class="display-4 fw-bold text-warning">
                                                    {{ number_format($game->average_rating, 1) }}
                                                </div>
                                                <div class="fs-5 text-muted mb-2">из 5 ★</div>
                                                <div class="text-secondary">
                                                    на
                                                    основе {{ $game->review_count }} {{ Str::plural('отзыва', $game->review_count) }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Форма для написания/редактирования отзыва -->
                                        @auth
                                            @if($game->userHasPurchasedGame(Auth::user()))
                                                @php
                                                    $existingReview = $game->reviewBy(Auth::user());
                                                @endphp

                                                <div class="card mb-5 border-0 shadow-sm">
                                                    <div class="card-header bg-light">
                                                        <h5 class="mb-0">
                                                            {{ $existingReview ? 'Редактировать ваш отзыв' : 'Оставить отзыв' }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <form method="POST" action="{{ $existingReview
                            ? route('reviews.update', [$game, $existingReview])
                            : route('reviews.store', $game) }}">
                                                            @csrf
                                                            @if($existingReview)
                                                                @method('PATCH')
                                                            @endif

                                                            <div class="mb-4">
                                                                <label class="form-label fw-bold">Оценка</label>

                                                                <div class="rating-stars d-flex gap-1" style="font-size: 2rem;">
                                                                    @for($i = 5; $i >= 1; $i--)  {{-- обратный порядок для удобства --}}
                                                                    <input
                                                                        type="radio"
                                                                        name="rating"
                                                                        value="{{ $i }}"
                                                                        id="star{{ $i }}"
                                                                        class="d-none"
                                                                        {{ old('rating', $existingReview?->rating ?? '') == $i ? 'checked' : '' }}
                                                                        required
                                                                    >
                                                                    <label
                                                                        for="star{{ $i }}"
                                                                        class="cursor-pointer text-warning transition-all"
                                                                        style="transition: all 0.2s;"
                                                                        onmouseover="this.style.transform='scale(1.2)'"
                                                                        onmouseout="this.style.transform='scale(1)'"
                                                                    >
                                                                        <i class="bi bi-star-fill"></i>
                                                                    </label>
                                                                    @endfor
                                                                </div>

                                                                @error('rating')
                                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="mb-4">
                                                                <label for="title" class="form-label fw-bold">Заголовок
                                                                    (необязательно)</label>
                                                                <input type="text" name="title" id="title"
                                                                       class="form-control"
                                                                       value="{{ old('title', $existingReview?->title ?? '') }}">
                                                            </div>

                                                            <div class="mb-4">
                                                                <label for="comment" class="form-label fw-bold">Ваш
                                                                    отзыв</label>
                                                                <textarea name="comment" id="comment" rows="5"
                                                                          class="form-control @error('comment') is-invalid @enderror">{{ old('comment', $existingReview?->comment ?? '') }}</textarea>
                                                                @error('comment')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="d-flex gap-3">
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ $existingReview ? 'Сохранить изменения' : 'Отправить отзыв' }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                        @if($existingReview)
                                                            <form action="{{ route('reviews.destroy', [$game, $existingReview]) }}"
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="btn btn-outline-danger"
                                                                        onclick="return confirm('Удалить отзыв?')">
                                                                    Удалить отзыв
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info text-center">
                                                    Чтобы оставить отзыв, вам нужно приобрести игру.
                                                </div>
                                            @endif
                                        @endauth

                                        <!-- Список отзывов -->
                                        @forelse($game->reviews->where('is_published', true) as $review)
                                            <div class="card review-card mb-3 border-0 shadow-sm hover-shadow">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-start gap-3">
                                                        <!-- Аватарка пользователя -->
                                                        <div class="flex-shrink-0">
                                                            @if($review->user?->profile_photo_url)
                                                                <img src="{{ $review->user->profile_photo_url }}"
                                                                     class="rounded-circle"
                                                                     width="48" height="48"
                                                                     alt="{{ $review->user->name }}">
                                                            @else
                                                                <div
                                                                    class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                                    style="width:48px; height:48px; font-size:1.1rem;">
                                                                    {{ Str::upper(Str::substr($review->user?->name ?? 'А', 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Основной контент отзыва -->
                                                        <div class="flex-grow-1">
                                                            <div
                                                                class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                                                                <div>
                                                                    <strong class="d-block">
                                                                        {{ $review->user?->name ?? 'Анонимный игрок' }}
                                                                        @if($review->is_verified)
                                                                            <i class="bi bi-check-circle-fill text-success ms-1"
                                                                               title="Проверенный покупатель"></i>
                                                                        @endif
                                                                    </strong>
                                                                    <small class="text-muted">
                                                                        {{ $review->created_at->diffForHumans() }}
                                                                    </small>
                                                                </div>

                                                                <div class="stars text-warning fs-5">
                                                                    {!! str_repeat('<i class="bi bi-star-fill"></i>', $review->rating) !!}
                                                                    {!! str_repeat('<i class="bi bi-star"></i>', 5 - $review->rating) !!}
                                                                </div>
                                                            </div>

                                                            @if($review->title)
                                                                <h5 class="card-title mb-2">{{ $review->title }}</h5>
                                                            @endif

                                                            <p class="card-text mb-0">
                                                                {{ $review->comment }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info text-center py-4">
                                                Пока никто не оставил отзыв об этой игре.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section categories related-games">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>Action</h6>
                        <h2>Related Games</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="shop.html">View All</a>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="product-details.html"><img src="../images/categories-01.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="product-details.html"><img src="../images/categories-05.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="product-details.html"><img src="../images/categories-03.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="product-details.html"><img src="../images/categories-04.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="product-details.html"><img src="../images/categories-05.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .rating-stars label:hover ~ label i,
        .rating-stars input:checked ~ label i {
            color: #ffc107 !important;  /* жёлтый при наведении и выборе */
        }
        .rating-stars label i {
            color: #e0e0e0;  /* серый по умолчанию */
        }
        .rating-stars input:checked + label i {
            color: #ffc107;
        }
    </style>
@endsection
