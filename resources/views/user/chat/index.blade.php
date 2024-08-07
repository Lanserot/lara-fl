@extends('resources.base.headers')
@section('title', 'Сообщения')
@section('content')
    <div class="row">
        <div class="col-md-4 card">
            @foreach($responses as $response)
                @include('user.chat.components.chat_user_card', ['response' => $response])
            @endforeach
        </div>
        <div class="col-md-8 card">
            Тут будут отображатся диалоги
        </div>
    </div>
@endsection

