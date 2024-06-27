@include('resources.base.headers')

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    @if(empty($orders))
        <h4>Упс... ничего нет...</h4>
    @else
        @foreach($orders as $order)
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">{{$order['title']}}</h5>
                    <p class="card-title">{{Carbon\Carbon::parse($order['created_at'])->format('Y-m-d H:i')}}</p>
                    <a href="/order/{{$order['id']}}" class="btn btn-primary">Подробнее...</a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@include('resources.base.footer')
