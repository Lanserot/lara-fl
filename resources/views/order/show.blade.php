@extends('resources.base.headers')
@section('title', 'Просмотр заказа')
@section('content')
<div>
    <h4>{{$order['title']}}</h4>
    <div class="card mt-3">
        <div class="card-body">
            <p>{!! $order['description'] !!}</p>
        </div>
    </div>
    <p class="mt-3">Категория :  <a href="{{route('order.category', $order['category_name'])}}">{{$order['category_name_rus']}}</a></p>
    <p class="mt-3">Дата : {{$order['created_at']}}</p>
    <p class="mt-3">Срок : {{$order['date'] ?? 'Без срока'}}</p>
    @if($order['budget'] > 0)
        <p class="mt-3">Бюджет : {{$order['budget']}}р</p>
    @endif
</div>
@endsection
