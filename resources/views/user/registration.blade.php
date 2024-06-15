@include('resources.base.headers')
<div>
    <div class="form-group">
        <input type="text" class="form-control" name="login" placeholder="Login">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Пароль">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password-repeat" placeholder="Пароль">
    </div>
    <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email">
    </div>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
    </div>
    <button type="submit" class="btn btn-primary sub-btn">Войти</button>
</div>

<script>
    $(document).ready(function () {
        $('.sub-btn').click(function () {
            $.ajax({
                url: '<?= route('user.create') ?>',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    login: $('input[name="login"]').val(),
                    password: $('input[name="password"]').val(),
                    password_repeat: $('input[name="password-repeat"]').val(),
                    email: $('input[name="email"]').val(),
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
