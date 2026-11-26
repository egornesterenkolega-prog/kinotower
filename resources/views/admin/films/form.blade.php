@extends('admin.layout')

@section('title', $film->exists ? 'Изменение фильма' : 'Добавление фильма')

@section('content')
    <h1>{{ $film->exists ? 'Изменение фильма' : 'Добавление фильма' }}</h1>

    <form method="POST" action="{{ $film->exists ? route('admin.films.update', $film) : route('admin.films.store') }}">
        @csrf
        @if ($film->exists)
            @method('PUT')
        @endif

        <div class="field">
            <label for="name">Название</label>
            <input type="text" id="name" name="name" maxlength="150" value="{{ old('name', $film->name) }}" required autofocus>
            @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="country_id">Страна</label>
            <select id="country_id" name="country_id" required>
                <option value="">— выберите —</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @selected(old('country_id', $film->country_id) == $country->id)>{{ $country->name }}</option>
                @endforeach
            </select>
            @error('country_id')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="duration">Продолжительность (мин.)</label>
            <input type="number" id="duration" name="duration" min="1" max="65535" value="{{ old('duration', $film->duration) }}" required>
            @error('duration')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="year_of_issue">Год выпуска</label>
            <input type="number" id="year_of_issue" name="year_of_issue" min="1901" max="2155" value="{{ old('year_of_issue', $film->year_of_issue) }}" required>
            @error('year_of_issue')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="age">Возрастное ограничение</label>
            <select id="age" name="age" required>
                <option value="">— выберите —</option>
                @foreach ($ages as $age)
                    <option value="{{ $age }}" @selected((string) old('age', $film->age) === (string) $age)>{{ $age }}+</option>
                @endforeach
            </select>
            @error('age')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="link_img">Ссылка на постер (необязательно)</label>
            <input type="url" id="link_img" name="link_img" maxlength="255" value="{{ old('link_img', $film->link_img) }}">
            @error('link_img')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="link_kinopoisk">Ссылка на Кинопоиск (необязательно)</label>
            <input type="url" id="link_kinopoisk" name="link_kinopoisk" maxlength="255" value="{{ old('link_kinopoisk', $film->link_kinopoisk) }}">
            @error('link_kinopoisk')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="link_video">Ссылка на видео</label>
            <input type="url" id="link_video" name="link_video" maxlength="255" value="{{ old('link_video', $film->link_video) }}" required>
            @error('link_video')<div class="error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn">{{ $film->exists ? 'Сохранить' : 'Добавить' }}</button>
        <a class="btn btn-gray" href="{{ route('admin.films.index') }}">Отмена</a>
    </form>
@endsection
