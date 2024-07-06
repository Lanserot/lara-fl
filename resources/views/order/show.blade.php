@extends('resources.base.headers')
@section('title', 'Просмотр заказа')
@section('content')
<div>
    <h4>{{$order->order->title}}</h4>
    <div class="card mt-3">
        <div class="card-body">
            <p>{!! $order->order->description !!}</p>
        </div>
    </div>
    <p class="mt-3">Категория :  <a href="{{route('order.category', $order->category->name)}}">{{$order->category->name_rus}}</a></p>
    <p class="mt-3">Дата : {{$order->order->created_at}}</p>
    <p class="mt-3">Срок : {{$order->order->date ?? 'Без срока'}}</p>
    @if($order->order->budget > 0)
        <p class="mt-3">Бюджет : {{$order->order->budget}}р</p>
    @endif
</div>
@endsection
