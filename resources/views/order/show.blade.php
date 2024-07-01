@include('resources.base.headers')
<div>
    <h4>{{$order['title']}}</h4>
    <div class="card mt-3">
        <div class="card-body">
            <p>{!! $order['description'] !!}</p>
        </div>
    </div>
    <p class="mt-3">Категория :  <a href="{{route('order.category', $order['category_name'])}}">{{$order['category_name_rus']}}</a></p>
    <p class="mt-3">Дата : {{$order['created_at']}}</p>
</div>

@include('resources.base.footer')
