@extends('resources.base.headers')
@section('title', 'Админ страница')
@section('content')
    <div class="row">
        <div class="col-md-4 card">
            @foreach($users as $user)
                <div class=" card-body">
                    <p>Имя : {{$user->name ?? 'Пользователь ' . $user->id}}</p>
                </div>
            @endforeach
        </div>
        <div class="col-md-8">
            0
        </div>
    </div>
@endsection

