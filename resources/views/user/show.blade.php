@include('resources.base.headers')
<?php
/** @var \Buisness\User\Entity\UserEntity $user */
?>
<div>
    <p>Ваш логин : {{$user->getLogin()}}</p>
    <p>Ваш email : {{$user->getEmail()}}</p>
    <a href="{{route('user.edit', $user->getId())}}"><button class="btn btn-info"> Изменить </button></a>
</div>
@include('resources.base.footer')
