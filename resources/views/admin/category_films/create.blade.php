@extends('admin.layout')

@section('title', 'Добавление жанра к фильму')

@section('content')
    <h1>Добавление жанра к фильму «{{ $film->name }}»</h1>

    @if ($categories->isEmpty())
        <p class="muted">Нет жанров, которые можно добавить: все жанры уже привязаны или жанров ещё нет.</p>
        <a class="btn btn-gray" href="{{ route('admin.films.categories.index', $film) }}">Назад</a>
    @else
        <form method="POST" action="{{ route('admin.films.categories.store', $film) }}">
            @csrf
            <div class="field">
                <label for="category_id">Жанр</label>
                <select id="category_id" name="category_id" required>
                    <option value="">— выберите —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn">Добавить</button>
            <a class="btn btn-gray" href="{{ route('admin.films.categories.index', $film) }}">Отмена</a>
        </form>
    @endif
@endsection
