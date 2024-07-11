@php 
$user_info = $response->user_info;
$order = $response->order;
@endphp
<div class=" card-body">
    <p>
        Имя : {{$user_info->name ?? 'Пользователь ' . $response->user_id}}
        <br> Заказ : {{$order->title }}
    </p>
</div>