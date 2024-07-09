@extends('resources.base.headers')
@section('title', 'Список заказов')
@section('content')
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    @if($orders->isEmpty())
        <h4>Упс... ничего нет...</h4>
    @else
        @foreach($orders as $order)
            @include('order.components.order_card', ['order' => $order])
        @endforeach
    @endif
</div>
@endsection
