<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="/icons/favicon-32.ico">

    <title>@yield('title')</title>
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/tinymce.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <style>
    </style>
</head>
<body class="antialiased">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/"><?= env('APP_NAME') ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if (Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Профиль
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                        <li><a class="dropdown-item" href="{{route('user.show', Auth::user()->id)}}">Профиль</a></li>
                        <li><a class="dropdown-item" href="{{route('user.my_list')}}">Мои заказы</a></li>
                        <li><a class="dropdown-item" href="{{route('user.chat')}}">Мои сообщения</a></li>
                        {{--                        <li><hr class="dropdown-divider"></li>--}}
                        {{--                        <li><a class="dropdown-item" href="#">Something else here</a></li>--}}
                    </ul>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('order') }}">Создать</a>
                </li>
            @endif
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('order.list') }}">Заказы</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">

            @if (Auth::check())
                @if (Auth::user()->hasRole(\Infrastructure\Enums\RolesEnum::ADMIN->value))
                    <li class="nav-item active">
                        <a class="nav-link" href="/user/admin">Админ</a>
                    </li>
                @endif
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
<link href="/css/bootstrap.min.css" rel="stylesheet">

</body>
</html>
