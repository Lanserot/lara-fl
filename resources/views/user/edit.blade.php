@include('resources.base.headers')
<?php
/** @var \Buisness\User\Entity\UserEntity $user */
?>
<div>
    <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $user->getEmail() }}">
    </div>
    <button type="submit" class="btn btn-primary sub-btn">Сохранить</button>
</div>

<script>
    $(document).ready(function () {
        $('.sub-btn').click(function () {
            $.ajax({
                url: '<?= route('user.update', $user->getId()) ?>',
                type: 'PATCH',
                data: {
                    _token: "{{ csrf_token() }}",
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

@include('resources.base.footer')
