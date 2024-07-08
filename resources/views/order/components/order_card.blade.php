<!-- resources/views/orders/partials/order_card.blade.php -->
<div class="card mt-3">
    <div class="card-body">
        <h5 class="card-title">{{ $order->title }}</h5>
        <p class="card-title">{{ Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i') }}</p>
        <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary">Подробнее...</a>
    </div>
</div>
