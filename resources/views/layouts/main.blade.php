<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <title>@yield('title', 'Магазин игр')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/templatemo-lugx-gaming.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/owl.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/animate.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--

    TemplateMo 589 lugx gaming

    https://templatemo.com/tm-589-lugx-gaming

    -->
</head>

<body>

<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- ***** Preloader End ***** -->

@include ('components.header')

@yield('content')

@include('components.footer')

<!-- Scripts -->
<!-- Bootstrap core JavaScript -->
<script src="{{ asset('/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('/js/isotope.min.js')}}"></script>
<script src="{{ asset('/js/owl-carousel.js')}}"></script>
<script src="{{ asset('/js/counter.js')}}"></script>
<script src="{{ asset('/js/custom.js')}}"></script>

</body>
</html>
