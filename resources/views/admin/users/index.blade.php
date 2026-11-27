@extends('admin.layout')

@section('title', 'Пользователи')

@section('content')
    <h1>Пользователи</h1>

    <div class="tabs">
        <a class="btn {{ $onlyDeleted ? 'btn-gray' : 'active' }}" href="{{ route('admin.users.index') }}">Активные</a>
        <a class="btn {{ $onlyDeleted ? 'active' : 'btn-gray' }}" href="{{ route('admin.users.index', ['deleted' => 1]) }}">Удалённые</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>ФИО</th><th>Email</th><th>Пол</th><th>Дата рождения</th>
                <th>{{ $onlyDeleted ? 'Удалён' : 'Регистрация' }}</th><th>Действия</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->fio }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->gender?->name ?? '—' }}</td>
                <td>{{ $user->birthday?->format('d.m.Y') ?? '—' }}</td>
                <td>{{ ($onlyDeleted ? $user->deleted_at : $user->created_at)?->format('d.m.Y H:i') }}</td>
                <td class="actions">
                    @if ($onlyDeleted)
                        <form method="POST" action="{{ route('admin.users.restore', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn">Восстановить</button>
                        </form>
                    @elseif ($user->is(auth()->user()))
                        <span class="muted">это вы</span>
                    @else
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Удалить пользователя «{{ $user->fio }}»?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-red">Удалить</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="muted">{{ $onlyDeleted ? 'Удалённых пользователей нет.' : 'Пользователей нет.' }}</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
@endsection
