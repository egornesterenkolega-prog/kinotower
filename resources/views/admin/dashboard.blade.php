<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ-панель</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 40px; }
        button { padding: 8px 16px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Админ-панель</h1>
    <p>Вы вошли как {{ auth()->user()->email }}.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Выйти</button>
    </form>
</body>
</html>
