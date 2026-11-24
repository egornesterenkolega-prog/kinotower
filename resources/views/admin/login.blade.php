<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход в админ-панель</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 32px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,.1); width: 100%; max-width: 360px; }
        h1 { margin: 0 0 20px; font-size: 22px; }
        label { display: block; margin-bottom: 4px; font-size: 14px; }
        input[type=email], input[type=password] { width: 100%; box-sizing: border-box; padding: 8px 10px; margin-bottom: 14px; border: 1px solid #ccc; border-radius: 4px; }
        .check { margin-bottom: 16px; font-size: 14px; }
        button { width: 100%; padding: 10px; background: #2563eb; color: #fff; border: 0; border-radius: 4px; cursor: pointer; font-size: 15px; }
        .error { color: #b91c1c; font-size: 13px; margin: -8px 0 12px; }
    </style>
</head>
<body>
<div class="card">
    <h1>Вход в админ-панель</h1>
    <form method="POST" action="{{ route('login.process') }}">
        @csrf
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')<div class="error">{{ $message }}</div>@enderror

        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
        @error('password')<div class="error">{{ $message }}</div>@enderror

        <div class="check">
            <label><input type="checkbox" name="remember" value="1"> Запомнить меня</label>
        </div>

        <button type="submit">Войти</button>
    </form>
</div>
</body>
</html>
