<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{ mix('resources/icons/favicon-32.ico') }}">

    <title>@yield('title')</title>
    <script src="{{  mix('resources/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{  mix('resources/js/tinymce.min.js') }}"></script>
    <style>
    </style>
</head>
<body class="antialiased">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/"><?= env('APP_NAME') ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if (Auth::check())
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('user.show', Auth::user()->id)}}">{{ Auth::user()->login }}</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('order') }}">Создать</a>
                </li>
                @if (Auth::user()->hasRole(\App\Enums\RolesEnum::ADMIN->value))
                    <li class="nav-item active">
                        <a class="nav-link" href="/user/admin">Админ</a>
                    </li>
                @endif
            @endif
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('order.list') }}">Заказы</a>
            </li>

                @if (Auth::check())
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('logout') }}">Выход</a>
                    </li>
                @else
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('login') }}">Логин</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('registration') }}">Регистрация</a>
                    </li>
                @endif
        </ul>
    </div>
</nav>
<div class="container mt-5">
    @yield('content')
</div>
<link href="{{ mix('resources/css/bootstrap.min.css') }}" rel="stylesheet">

</body>
</html>
