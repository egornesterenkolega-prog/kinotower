@extends('admin.layout')

@section('title', 'Жанры')

@section('content')
    <h1>Жанры</h1>
    <a class="btn" href="{{ route('admin.categories.create') }}">Добавить жанр</a>

    <table>
        <thead>
            <tr><th>ID</th><th>Название</th><th>Родительский жанр</th><th>Действия</th></tr>
        </thead>
        <tbody>
        @forelse ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->parent?->name ?? '—' }}</td>
                <td class="actions">
                    <a class="btn btn-gray" href="{{ route('admin.categories.edit', $category) }}">Изменить</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                          onsubmit="return confirm('Удалить жанр «{{ $category->name }}»?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="muted">Жанров пока нет.</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
