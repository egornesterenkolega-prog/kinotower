<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Админ-панель')</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; background: #f3f4f6; color: #111; }
        nav { background: #1f2937; padding: 12px 24px; display: flex; gap: 20px; align-items: center; }
        nav a { color: #e5e7eb; text-decoration: none; }
        nav a:hover { color: #fff; }
        nav form { margin-left: auto; }
        nav button { background: none; border: 1px solid #6b7280; color: #e5e7eb; padding: 4px 12px; border-radius: 4px; cursor: pointer; }
        main { max-width: 1000px; margin: 24px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 1px 6px rgba(0,0,0,.08); }
        h1 { margin-top: 0; font-size: 22px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #e5e7eb; }
        .btn { display: inline-block; padding: 6px 12px; border-radius: 4px; border: 0; background: #2563eb; color: #fff; text-decoration: none; cursor: pointer; font-size: 14px; }
        .btn-gray { background: #6b7280; }
        .btn-red { background: #dc2626; }
        .actions { display: flex; gap: 6px; }
        .actions form { margin: 0; }
        .alert { padding: 10px 14px; border-radius: 4px; background: #dcfce7; color: #166534; margin-bottom: 16px; }
        .error { color: #b91c1c; font-size: 13px; margin-top: 4px; }
        label { display: block; margin-bottom: 4px; font-size: 14px; }
        input[type=text], select { width: 100%; box-sizing: border-box; padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; }
        .field { margin-bottom: 16px; }
        .muted { color: #6b7280; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .filters { display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; margin: 16px 0; }
        .filters .field { margin: 0; min-width: 180px; }
        .tag { display: inline-block; background: #e5e7eb; border-radius: 10px; padding: 1px 8px; font-size: 12px; margin: 1px 2px 1px 0; }
        .pagination { display: flex; gap: 4px; margin-top: 16px; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 5px 10px; border: 1px solid #d1d5db; border-radius: 4px; text-decoration: none; color: #111; font-size: 14px; }
        .pagination .current { background: #2563eb; border-color: #2563eb; color: #fff; }
        .pagination .disabled { color: #9ca3af; }
        input[type=url], input[type=number] { width: 100%; box-sizing: border-box; padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; }
    </style>
</head>
<body>
<nav>
    <a href="{{ route('admin.dashboard') }}">Главная</a>
    <a href="{{ route('admin.films.index') }}">Фильмы</a>
    <a href="{{ route('admin.countries.index') }}">Страны</a>
    <a href="{{ route('admin.categories.index') }}">Жанры</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Выйти ({{ auth()->user()->email }})</button>
    </form>
</nav>
<main>
    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if ($errors->has('country'))
        <div class="alert alert-error">{{ $errors->first('country') }}</div>
    @endif
    @yield('content')
</main>
</body>
</html>
