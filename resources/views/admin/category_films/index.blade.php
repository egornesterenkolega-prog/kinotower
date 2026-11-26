@extends('admin.layout')

@section('title', 'Жанры фильма')

@section('content')
    <h1>Жанры фильма «{{ $film->name }}»</h1>
    <a class="btn" href="{{ route('admin.films.categories.create', $film) }}">Добавить жанр</a>
    <a class="btn btn-gray" href="{{ route('admin.films.index') }}">К списку фильмов</a>

    <table>
        <thead>
            <tr><th>ID</th><th>Жанр</th><th>Действия</th></tr>
        </thead>
        <tbody>
        @forelse ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td class="actions">
                    <form method="POST" action="{{ route('admin.films.categories.destroy', [$film, $category]) }}"
                          onsubmit="return confirm('Убрать жанр «{{ $category->name }}» у фильма?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="muted">У фильма пока нет жанров.</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
