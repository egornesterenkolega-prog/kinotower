@extends('admin.layout')

@section('title', 'Фильмы')

@section('content')
    <h1>Фильмы</h1>
    <a class="btn" href="{{ route('admin.films.create') }}">Добавить фильм</a>

    <form method="GET" action="{{ route('admin.films.index') }}" class="filters">
        <div class="field">
            <label for="country_id">Страна</label>
            <select id="country_id" name="country_id">
                <option value="">Все страны</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @selected($countryId == $country->id)>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="category_id">Жанр</label>
            <select id="category_id" name="category_id">
                <option value="">Все жанры</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($categoryId == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn">Применить</button>
        <a class="btn btn-gray" href="{{ route('admin.films.index') }}">Сбросить</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>Название</th><th>Страна</th><th>Год</th><th>Мин.</th><th>Возраст</th><th>Жанры</th><th>Действия</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($films as $film)
            <tr>
                <td>{{ $film->id }}</td>
                <td>{{ $film->name }}</td>
                <td>{{ $film->country->name }}</td>
                <td>{{ $film->year_of_issue }}</td>
                <td>{{ $film->duration }}</td>
                <td>{{ $film->age }}+</td>
                <td>
                    @forelse ($film->categories as $category)
                        <span class="tag">{{ $category->name }}</span>
                    @empty
                        <span class="muted">—</span>
                    @endforelse
                </td>
                <td class="actions" style="flex-wrap: wrap">
                    <a class="btn btn-gray" href="{{ route('admin.films.edit', $film) }}">Изменить</a>
                    <a class="btn btn-gray" href="{{ route('admin.films.categories.index', $film) }}">Жанры</a>
                    <a class="btn btn-gray" href="{{ route('admin.reviews.index', ['film_id' => $film->id]) }}">Отзывы</a>
                    <a class="btn btn-gray" href="{{ route('admin.ratings.index', ['film_id' => $film->id]) }}">Оценки</a>
                    <form method="POST" action="{{ route('admin.films.destroy', $film) }}"
                          onsubmit="return confirm('Удалить фильм «{{ $film->name }}»?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="muted">Фильмов не найдено.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $films->links() }}
@endsection
