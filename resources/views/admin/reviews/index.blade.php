@extends('admin.layout')

@section('title', 'Отзывы')

@section('content')
    <h1>Отзывы</h1>

    <form method="GET" action="{{ route('admin.reviews.index') }}" class="filters">
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
        <a class="btn btn-gray" href="{{ route('admin.reviews.index') }}">Сбросить</a>
    </form>

    <table>
        <thead>
            <tr><th>ID</th><th>Фильм</th><th>Автор</th><th>Отзыв</th><th>Дата</th><th>Статус</th><th>Действия</th></tr>
        </thead>
        <tbody>
        @forelse ($reviews as $review)
            <tr>
                <td>{{ $review->id }}</td>
                <td>{{ $review->film?->name }}</td>
                <td>{{ $review->user?->fio }}</td>
                <td class="msg">{{ $review->message }}</td>
                <td>{{ $review->created_at?->format('d.m.Y H:i') }}</td>
                <td>
                    @if ($review->is_approved)
                        <span class="badge-ok">Одобрен</span>
                    @else
                        <span class="badge-wait">Ожидает</span>
                    @endif
                </td>
                <td class="actions">
                    @unless ($review->is_approved)
                        <form method="POST" action="{{ route('admin.reviews.approved', $review) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn">Одобрить</button>
                        </form>
                    @endunless
                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                          onsubmit="return confirm('Удалить отзыв?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="muted">Отзывов нет.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $reviews->links() }}
@endsection
