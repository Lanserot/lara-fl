@include('resources.base.headers')
{{--@dd(\Tymon\JWTAuth\Facades\JWTAuth::fromUser(auth()->user()))--}}
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<h3>Категории</h3>
<div class="row">
    @foreach($categories as $category)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{$category->name_rus}}</h5>
                    <a href="{{route('order.category', $category->name)}}" class="btn btn-primary">Подробнее...</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<h3>Лучшие</h3>
<div class="row">
    @foreach($users as $user)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    @if($user->path)
                        <img src="/public/{{$user->path}}/{{$user->file_name}}" alt="" style="max-height: 200px;">
                    @endif
                    <h5 class="card-title">{{$user->name ?? 'Пользователь ' . $user->id}}</h5>
                </div>
            </div>
        </div>
    @endforeach
</div>
@include('resources.base.footer')
