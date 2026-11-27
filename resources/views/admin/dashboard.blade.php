@extends('admin.layout')

@section('title', 'Админ-панель')

@section('content')
    <h1>Админ-панель</h1>
    <p>Вы вошли как {{ auth()->user()->email }}.</p>
    <p>
        <a class="btn" href="{{ route('admin.films.index') }}">Фильмы</a>
        <a class="btn" href="{{ route('admin.countries.index') }}">Страны</a>
        <a class="btn" href="{{ route('admin.categories.index') }}">Жанры</a>
        <a class="btn" href="{{ route('admin.users.index') }}">Пользователи</a>
        <a class="btn" href="{{ route('admin.reviews.index') }}">Отзывы</a>
        <a class="btn" href="{{ route('admin.ratings.index') }}">Оценки</a>
    </p>
@endsection
