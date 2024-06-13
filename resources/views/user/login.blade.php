@include('resources.base.headers')
<div>
    <div class="form-group">
        <input type="text" class="form-control" name="login" placeholder="Email">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Пароль">
    </div>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        {{--        <label class="form-check-label" for="exampleCheck1">Запомнить</label>--}}
    </div>
    <button type="submit" class="btn btn-primary sub-btn">Войти</button>
</div>

<script>
    $(document).ready(function () {
        $('.sub-btn').click(function () {
            $.ajax({
                url: '<?= route('login-get') ?>',
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}",
                    login: $('input[name="login"]').val(),
                    password: $('input[name="password"]').val()
                },
                success: function (response) {
                    location.reload()
                },
                error: function (response) {
                    console.log(response.status);
                },
            });
        })
    });
</script>
@include('resources.base.footer')
