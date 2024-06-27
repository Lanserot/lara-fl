@include('resources.base.headers')

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    @foreach($categories as $category)
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">{{$category['name_rus']}}</h5>
                <a href="{{route('order.category', $category['name'])}}" class="btn btn-primary">Подробнее...</a>
            </div>
        </div>
    @endforeach
</div>

@include('resources.base.footer')
