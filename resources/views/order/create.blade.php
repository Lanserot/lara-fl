@extends('resources.base.headers')
@section('title', 'Создание заказа')
@section('content')
    <div>
        <select class="custom-select mb-3" aria-label="Default select example" name="category">
            <option value="0">Категория</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name_rus}}</option>
            @endforeach
        </select>
        <div class="form-group mb-3">
            <input type="text" class="form-control" name="title" placeholder="Заголовок">
        </div>
        <div class="mb-3">
            <textarea name="description" placeholder="Описание"></textarea>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="budget" placeholder="Бюджет">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="date" placeholder="Срок">
        </div>
        <button type="submit" class="btn btn-primary sub-btn">Создать</button>
    </div>
    <script>
        tinymce.init({
            selector: 'textarea',  // Указывает, на каких textarea будет работать TinyMCE
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            menu: {
                file: {title: 'File', items: ''},
                edit: {title: 'Edit', items: ''},
                view: {title: 'View', items: ''},
                format: {title: 'Format', items: 'bold italic underline'},
                table: {title: 'Table', items: 'inserttable tableprops deletetable row column cell'},
                tools: {title: 'Tools', items: 'spellchecker'}
            },
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.sub-btn').click(function () {
                tinymce.triggerSave(); // Обновляем значение textarea
                $.ajax({
                    url: '<?= route('order.create') ?>',
                    type: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    data: {
                        _token: "{{ csrf_token() }}",
                        title: $('input[name="title"]').val(),
                        description: $('textarea[name="description"]').val(),
                        category: $('select[name="category"]').val(),
                        budget: $('input[name="budget"]').val(),
                        date: $('input[name="date"]').val(),
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
