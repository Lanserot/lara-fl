@php use Buisness\User\Entity\UserEntity; @endphp
@extends('resources.base.headers')
@section('title', 'Изменение пользователя')
@section('content')
<?php
/** @var UserEntity $user */
?>
<div>
    <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $user->getEmail() }}">
    </div>
    <button type="submit" class="btn btn-primary sub-btn">Сохранить</button>
</div>

<form id="uploadForm" class="mt-3">
    <input type="file"  class="form-control" id="fileInput" name="file">
    <button type="submit" class="btn btn-primary sub-btn">Сохранить</button>
</form>

<script>

    $(document).ready(function () {
        var token = '{{csrf_token()}}';

        document.getElementById('uploadForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Предотвращаем стандартное поведение формы

            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];

            if (file) {
                const formData = new FormData();
                formData.append('file', file);

                fetch('{{route('file.upload')}}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            } else {
                alert('Please select a file first.');
            }
        });
        $('.sub-btn').click(function () {
            $.ajax({
                url: '<?= route('user.update', $user->getId()) ?>',
                type: 'PATCH',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                data: {
                    _token: token,
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
@endsection
