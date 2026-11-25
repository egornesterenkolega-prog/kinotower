@extends('admin.layout')

@section('title', $country->exists ? 'Изменение страны' : 'Добавление страны')

@section('content')
    <h1>{{ $country->exists ? 'Изменение страны' : 'Добавление страны' }}</h1>

    <form method="POST"
          action="{{ $country->exists ? route('admin.countries.update', $country) : route('admin.countries.store') }}">
        @csrf
        @if ($country->exists)
            @method('PUT')
        @endif

        <div class="field">
            <label for="name">Название</label>
            <input type="text" id="name" name="name" maxlength="50" value="{{ old('name', $country->name) }}" required autofocus>
            @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn">{{ $country->exists ? 'Сохранить' : 'Добавить' }}</button>
        <a class="btn btn-gray" href="{{ route('admin.countries.index') }}">Отмена</a>
    </form>
@endsection
