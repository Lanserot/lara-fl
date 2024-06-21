@include('resources.base.headers')
<div>
    <div>
        <label for="title">Заголовок:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Описание:</label>
        <input type="text" id="description" name="description" required>
    </div>
    <button type="submit" class="btn btn-primary sub-btn">Создать</button>
</div>
<script>
    $(document).ready(function () {

            console.log(localStorage.getItem('token'))
        $('.sub-btn').click(function () {
            $.ajax({
                url: '<?= route('order.create') ?>',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    title: $('input[name="title"]').val(),
                    description: $('input[name="description"]').val()
                },
                success: function (response) {
                    // location.reload()
                    console.log(response);

                },
                error: function (response) {
                    console.log(response.status);
                },
            });
        })
    });
</script>
@include('resources.base.footer')
