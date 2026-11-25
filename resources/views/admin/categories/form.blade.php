@extends('admin.layout')

@section('title', $category->exists ? 'Изменение жанра' : 'Добавление жанра')

@section('content')
    <h1>{{ $category->exists ? 'Изменение жанра' : 'Добавление жанра' }}</h1>

    <form method="POST"
          action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <div class="field">
            <label for="name">Название</label>
            <input type="text" id="name" name="name" maxlength="150" value="{{ old('name', $category->name) }}" required autofocus>
            @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="parent_id">Родительский жанр</label>
            <select id="parent_id" name="parent_id">
                <option value="">— нет —</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')<div class="error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn">{{ $category->exists ? 'Сохранить' : 'Добавить' }}</button>
        <a class="btn btn-gray" href="{{ route('admin.categories.index') }}">Отмена</a>
    </form>
@endsection
