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
    </div>
    <button type="submit" class="btn btn-primary sub-btn">Войти</button>
</div>

<script>
    $(document).ready(function () {
        $('.sub-btn').click(function () {
            $.ajax({
                url: '<?= route('login') ?>',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    login: $('input[name="login"]').val(),
                    password: $('input[name="password"]').val()
                },
                success: function (response) {
                    localStorage.setItem('token', response.access_token);
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
