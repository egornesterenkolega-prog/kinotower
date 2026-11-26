<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Film;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryFilmController extends Controller
{
    /**
     * Список жанров выбранного фильма.
     */
    public function index(Film $film): View
    {
        $categories = $film->categories()->orderBy('name')->get();

        return view('admin.category_films.index', compact('film', 'categories'));
    }

    /**
     * Форма добавления жанра к фильму (только ещё не привязанные жанры).
     */
    public function create(Film $film): View
    {
        $categories = Category::whereNotIn('id', $film->categories()->pluck('categories.id'))
            ->orderBy('name')
            ->get();

        return view('admin.category_films.create', compact('film', 'categories'));
    }

    /**
     * Добавление жанра к фильму.
     */
    public function store(Request $request, Film $film): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id,deleted_at,NULL',
                Rule::unique('category_films', 'category_id')->where('film_id', $film->id),
            ],
        ], [
            'category_id.required' => 'Выберите жанр.',
            'category_id.exists' => 'Выбран несуществующий жанр.',
            'category_id.unique' => 'Этот жанр уже добавлен к фильму.',
        ]);

        $film->categories()->attach($data['category_id']);

        return redirect()->route('admin.films.categories.index', $film)
            ->with('success', 'Жанр добавлен к фильму.');
    }

    /**
     * Удаление жанра у фильма.
     */
    public function destroy(Film $film, Category $category): RedirectResponse
    {
        $film->categories()->detach($category->id);

        return redirect()->route('admin.films.categories.index', $film)
            ->with('success', 'Жанр удалён у фильма.');
    }
}
