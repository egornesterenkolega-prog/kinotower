@extends('admin.layout')

@section('title', 'Оценки')

@section('content')
    <h1>Оценки</h1>

    <form method="GET" action="{{ route('admin.ratings.index') }}" class="filters">
        <div class="field">
            <label for="film_id">Фильм</label>
            <select id="film_id" name="film_id">
                <option value="">Все фильмы</option>
                @foreach ($films as $film)
                    <option value="{{ $film->id }}" @selected($filmId == $film->id)>{{ $film->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn">Показать</button>
        <a class="btn btn-gray" href="{{ route('admin.ratings.index') }}">Сбросить</a>
    </form>

    <p class="muted">
        Оценок: {{ $count }}@if ($count) · средняя: {{ number_format($average, 2, ',', '') }}@endif
    </p>

    <table>
        <thead>
            <tr><th>ID</th><th>Фильм</th><th>Пользователь</th><th>Оценка</th><th>Дата</th><th>Действия</th></tr>
        </thead>
        <tbody>
        @forelse ($ratings as $rating)
            <tr>
                <td>{{ $rating->id }}</td>
                <td>{{ $rating->film?->name }}</td>
                <td>{{ $rating->user?->fio }}</td>
                <td>{{ $rating->ball }}</td>
                <td>{{ $rating->created_at?->format('d.m.Y H:i') }}</td>
                <td class="actions">
                    <form method="POST" action="{{ route('admin.ratings.destroy', $rating) }}"
                          onsubmit="return confirm('Удалить оценку?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted">Оценок нет.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $ratings->links() }}
@endsection
