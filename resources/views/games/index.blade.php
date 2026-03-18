@extends('layouts.main')

@section('title', 'Игры')

@section('content')

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Lugx</h3>
                <span class="breadcrumb"><a href="{{route('home')}}">Home</a> > Наш магазин</span>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <form method="GET" action="{{ route('games.index') }}" class="input-group input-group-lg">
                <input
                    type="text"
                    name="search"
                    class="form-control border-end-0 rounded-start-pill shadow-sm"
                    placeholder="Поиск игры..."
                    value="{{ request('search') }}"
                    aria-label="Поиск игры"
                >
                <button class="btn btn-primary rounded-end-pill px-4 shadow-sm" type="submit">
                    <i class="bi bi-search me-2"></i> Найти
                </button>
            </form>
        </div>
    </div>
</div>
<div class="section trending">
    <div class="container">
        <ul class="trending-filter">
            <li>
                <a class="is_active" href="#!" data-filter="*">Все</a>
            </li>
            <li>
                <a href="#!" data-filter=".adv">Action</a>
            </li>
            <li>
                <a href="#!" data-filter=".str">Strategy</a>
            </li>
            <li>
                <a href="#!" data-filter=".rac">RPG</a>
            </li>
        </ul>
        <div class="row trending-box">
            @foreach($games as $game)
                <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items col-md-6
                @switch($game->genres[0]->name)
                @case('Action')
                adv
                @break
                @case('Strategy')
                str
                @break
                @case('RPG')
                rac
                @break
                @endswitch">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{'games/' . $game->slug}}"><img src="{{$game->cover_image}}" alt=""></a>
                            <span class="price">
                                @if ($game->discount_price != null)
                                <em>{{$game->price}}$</em>{{$game->discount_price}}$
                                @else
                                {{$game->price}}$
                                @endif
                            </span>
                        </div>
                        <div class="down-content">
                            <span class="category">{{$game->genres[0]->name}}</span>
                            <h4>{{$game->title}}</h4>
                            <a href="{{'games/' . $game->slug}}"><i class="fa fa-shopping-bag"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
                @if($games->isEmpty())
                    <div class="alert alert-info text-center py-3 my-3">
                        <i class="bi bi-search fs-1 d-block mb-3 text-muted"></i>
                        <h5>По запросу «{{ request('search') }}» ничего не найдено</h5>
                        <p class="text-muted">Попробуйте изменить запрос или посмотреть другие игры</p>
                        <a href="{{ route('games.index') }}" class="btn btn-primary mt-3">Сбросить поиск</a>
                    </div>
                @endif
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                {{ $games->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection
