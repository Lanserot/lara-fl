@extends('resources.base.headers')
@section('title', 'Просмотр заказа')
@section('content')
<?php
$page = \App\Http\Controllers\Order\OrderController::class //show
/** @var bool $can_response может ли откликнутся*/
?>
<div>
    <h4>{{$order->order->title}}</h4>
    <div class="card mt-3">
        <div class="card-body">
            <p>{!! $order->order->description !!}</p>
        </div>
    </div>
    <p class="mt-3">Категория :  <a href="{{route('order.category', $order->category->name)}}">{{$order->category->name_rus}}</a></p>
    <p class="mt-3">Дата : {{$order->order->created_at}}</p>
    @if($order->order->date && $order->order->date != '')
    <p class="mt-3">Срок : {{$order->order->date}}</p>
    @endif
    @if($order->order->budget > 0)
        <p class="mt-3">Бюджет : {{$order->order->budget}}р</p>
    @endif
    @if($can_response)
        <button type="submit" class="btn btn-primary sub-btn">
            откликнутся
        </button>
    @endif
</div>
@endsection
