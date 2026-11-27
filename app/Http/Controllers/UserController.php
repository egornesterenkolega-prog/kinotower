<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Список пользователей: активные или (при ?deleted=1) удалённые.
     */
    public function index(Request $request): View
    {
        $onlyDeleted = $request->boolean('deleted');

        $users = User::with('gender')
            ->when($onlyDeleted, fn ($query) => $query->onlyTrashed())
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'onlyDeleted'));
    }

    /**
     * Удаление пользователя (мягкое, softDeletes).
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return back()->withErrors(['alert' => 'Нельзя удалить самого себя.']);
        }

        $user->delete();

        return back()->with('success', 'Пользователь удалён.');
    }

    /**
     * Восстановление удалённого пользователя.
     */
    public function restore(User $user): RedirectResponse
    {
        $user->restore();

        return back()->with('success', 'Пользователь восстановлен.');
    }
}
