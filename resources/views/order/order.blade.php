<!-- resources/views/survey.blade.php -->
<!DOCTYPE html>
<html lang="en">
    <form action="{{ route('order-post') }}" method="POST">
        @csrf
        <div>
            <label for="title">Тема:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="description">Описание:</label>
            <input type="text" id="description" name="description" required>
        </div>
        <div>
            <label for="user_id">Пидр ИДИ:</label>
            <input type="int" id="user_id" name="user_id" required>
        </div>
            <button type="submit">Submit</button>
        </div>
    </form>
</html>