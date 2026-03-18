@extends('layouts.main')
@section('title', 'Main Page')
@section('content')


    <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="caption header-text">
                        <h6>Welcome to lugx</h6>
                        <h2>BEST GAMING SITE EVER!</h2>
                        <p>LUGX Gaming is free Bootstrap 5 HTML CSS website template for your gaming websites. You can download and use this layout for commercial purposes. Please tell your friends about TemplateMo.</p>




                        <div class="search-input">
                            <form id="search" method="GET" action="{{ route('games.index') }}">
                                <input type="text" placeholder="Поиск" id='searchText' name="search" onkeypress="handle" />
                                <button role="button">Искать</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="right-image">
                        <img src="{{$mostPopularGames[0]->cover_image}}" alt="{{$mostPopularGames[0]->slug}}">
                        <span class="price">
                            @if ($mostPopularGames[0]->discount_price != null)
                                {{$mostPopularGames[0]->discount_price}}$
                            @else
                                {{$mostPopularGames[0]->price}}$
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <a href="#">
                        <div class="item">
                            <div class="image">
                                <img src="images/featured-01.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Free Storage</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="#">
                        <div class="item">
                            <div class="image">
                                <img src="images/featured-02.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>User More</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="#">
                        <div class="item">
                            <div class="image">
                                <img src="images/featured-03.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Reply Ready</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="#">
                        <div class="item">
                            <div class="image">
                                <img src="images/featured-04.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Easy Layout</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="section trending">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>Тренды</h6>
                        <h2>Игры в тренде</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="{{route('games.index')}}">Показать больше</a>
                    </div>
                </div>
                @foreach($trendingGames as $game)
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="games/{{$game->slug ?? '#'}}"><img src="{{$game->cover_image}}" alt="{{$game->slug}}"></a>
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
                            <a href="games/{{$game->slug ?? '#'}}"><i class="fa fa-shopping-bag"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section most-played">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>ТОП ИГР</h6>
                        <h2>Самые популярные</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="{{route('games.index')}}">Показать больше</a>
                    </div>
                </div>
                @foreach($mostPopularGames as $game)
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="games/{{$game->slug ?? '#'}}"><img src="{{$game->cover_image}}" alt="{{$game->slug}}" style="max-height: 200px;"></a>
                        </div>
                        <div class="down-content">
                            <span class="category">{{$game->genres[0]->name}}</span>
                            <h4>{{$game->title}}</h4>
                            <a href="games/{{$game->slug ?? '#'}}">Играть</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section categories">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Категории</h6>
                        <h2>Топ категорий</h2>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="#"><img src="images/categories-01.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>RPG</h4>
                        <div class="thumb">
                            <a href="#"><img src="images/categories-05.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Adventure</h4>
                        <div class="thumb">
                            <a href="#"><img src="images/categories-03.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>FPS</h4>
                        <div class="thumb">
                            <a href="#"><img src="images/categories-04.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Shooter</h4>
                        <div class="thumb">
                            <a href="#"><img src="images/categories-05.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section cta">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="shop">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h6>Lugx</h6>
                                    <h2>Оформите предзаказ, лучшая <em>Цена</em> сейчас!</h2>
                                </div>
                                <p>Lorem ipsum dolor consectetur adipiscing, sed do eiusmod tempor incididunt.</p>
                                <div class="main-button">
                                    <a href="{{route('games.index')}}">Оформить сейчас</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-2 align-self-end">
                    <div class="subscribe">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h6>Новость</h6>
                                    <h2>Оформите <em>Подписку</em> - получите скидку!</h2>
                                </div>
                                <div class="search-input">
                                    <form id="subscribe" action="#">
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ваш email...">
                                        <button type="submit">Подписаться сейчас</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
