@extends('admin.layout')

@section('title', 'Страны')

@section('content')
    <h1>Страны</h1>
    <a class="btn" href="{{ route('admin.countries.create') }}">Добавить страну</a>

    <table>
        <thead>
            <tr><th>ID</th><th>Название</th><th>Действия</th></tr>
        </thead>
        <tbody>
        @forelse ($countries as $country)
            <tr>
                <td>{{ $country->id }}</td>
                <td>{{ $country->name }}</td>
                <td class="actions">
                    <a class="btn btn-gray" href="{{ route('admin.countries.edit', $country) }}">Изменить</a>
                    <form method="POST" action="{{ route('admin.countries.destroy', $country) }}"
                          onsubmit="return confirm('Удалить страну «{{ $country->name }}»?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="muted">Стран пока нет.</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
