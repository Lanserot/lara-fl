@extends('resources.base.headers')
@section('title', 'Админ страница')
@section('content')
    <div class="lg-3">
        <p>
       Admin page

        </p>
    </div>
    <button class="btn btn-info" onclick="copyToClipboard()">Копировать JWT в буфер обмена</button>
    <script>
        function copyToClipboard() {
            // Создаем элемент textarea
            const textarea = document.createElement('textarea');
            textarea.value = '{{\Tymon\JWTAuth\Facades\JWTAuth::fromUser(auth()->user())}}';

            // Добавляем элемент в DOM
            document.body.appendChild(textarea);

            // Выделяем текст в textarea
            textarea.select();
            textarea.setSelectionRange(0, 99999); // Для мобильных устройств

            // Копируем текст в буфер обмена
            document.execCommand('copy');

            // Удаляем элемент из DOM
            document.body.removeChild(textarea);

            // Опционально: выводим сообщение об успешном копировании
            alert('JWT скопирован в буфер обмена!');
        }
    </script>
@endsection

