@extends('resources.base.headers')
@section('title', 'Показ пользователя')
@section('content')
<?php
/** @var \Infrastructure\Interfaces\User\IUserEntity $user */
/** @var \Infrastructure\Interfaces\User\IUserInfoEntity $user_info */
?>
<div>
    @if($file_path)
        <img src="/public/{{$file_path->path}}/{{$file_path->name}}" alt="" style="max-height: 200px;">
    @endif
    <p>Ваш логин : {{$user->getLogin()}}</p>
    <p>Ваш email : {{$user->getEmail()}}</p>
    <a href="{{route('user.edit', $user->getId())}}">
        <button class="btn btn-info"> Изменить</button>
    </a>
</div>
<div>
    <p>Ваше имя : @if($user_info->getName()) {{$user_info->getName()}} @else Фрилансер @endif</p>
    <p>Ваша фамилия : {{$user_info->getSecondName()}}</p>
    <p>Ваше описание : {{$user_info->getDescription()}}</p>
    <a href="{{route('user.edit', $user_info->getId())}}">
        <button class="btn btn-info"> Изменить</button>
    </a>
</div>
@endsection
