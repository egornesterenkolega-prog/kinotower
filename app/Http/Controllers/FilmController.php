<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Film;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FilmController extends Controller
{
    /**
     * Допустимые возрастные ограничения.
     */
    private const AGES = [0, 6, 12, 16, 18];

    /**
     * Список фильмов с фильтрацией по стране и жанру и пагинацией.
     */
    public function index(Request $request): View
    {
        $countryId = $request->integer('country_id');
        $categoryId = $request->integer('category_id');

        $films = Film::with(['country', 'categories'])
            ->when($countryId, fn ($query) => $query->where('country_id', $countryId))
            ->when($categoryId, fn ($query) => $query->whereHas(
                'categories',
                fn ($q) => $q->where('categories.id', $categoryId)
            ))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.films.index', [
            'films' => $films,
            'countries' => Country::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'countryId' => $countryId,
            'categoryId' => $categoryId,
        ]);
    }

    /**
     * Форма добавления фильма.
     */
    public function create(): View
    {
        return view('admin.films.form', [
            'film' => new Film(),
            'countries' => Country::orderBy('name')->get(),
            'ages' => self::AGES,
        ]);
    }

    /**
     * Сохранение нового фильма.
     */
    public function store(Request $request): RedirectResponse
    {
        Film::create($this->validated($request));

        return redirect()->route('admin.films.index')->with('success', 'Фильм добавлен.');
    }

    /**
     * Форма изменения фильма.
     */
    public function edit(Film $film): View
    {
        return view('admin.films.form', [
            'film' => $film,
            'countries' => Country::orderBy('name')->get(),
            'ages' => self::AGES,
        ]);
    }

    /**
     * Обновление фильма.
     */
    public function update(Request $request, Film $film): RedirectResponse
    {
        $film->update($this->validated($request));

        return redirect()->route('admin.films.index')->with('success', 'Фильм изменён.');
    }

    /**
     * Удаление фильма (мягкое, softDeletes).
     */
    public function destroy(Film $film): RedirectResponse
    {
        $film->delete();

        return redirect()->route('admin.films.index')->with('success', 'Фильм удалён.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'duration' => ['required', 'integer', 'min:1', 'max:65535'],
            'year_of_issue' => ['required', 'integer', 'min:1901', 'max:' . min(date('Y') + 5, 2155)],
            'age' => ['required', 'integer', Rule::in(self::AGES)],
            'link_img' => ['nullable', 'url', 'max:255'],
            'link_kinopoisk' => ['nullable', 'url', 'max:255'],
            'link_video' => ['required', 'url', 'max:255'],
        ], [
            'name.required' => 'Введите название фильма.',
            'name.max' => 'Название не должно быть длиннее 150 символов.',
            'country_id.required' => 'Выберите страну.',
            'country_id.exists' => 'Выбрана несуществующая страна.',
            'duration.required' => 'Укажите продолжительность в минутах.',
            'duration.integer' => 'Продолжительность должна быть целым числом.',
            'duration.min' => 'Продолжительность должна быть не меньше 1 минуты.',
            'duration.max' => 'Слишком большая продолжительность.',
            'year_of_issue.required' => 'Укажите год выпуска.',
            'year_of_issue.integer' => 'Год должен быть числом.',
            'year_of_issue.min' => 'Год выпуска должен быть не раньше 1901.',
            'year_of_issue.max' => 'Год выпуска слишком большой.',
            'age.required' => 'Выберите возрастное ограничение.',
            'age.in' => 'Выберите возраст из списка.',
            'link_img.url' => 'Ссылка на постер должна быть корректным URL.',
            'link_kinopoisk.url' => 'Ссылка на Кинопоиск должна быть корректным URL.',
            'link_video.required' => 'Укажите ссылку на видео.',
            'link_video.url' => 'Ссылка на видео должна быть корректным URL.',
            '*.max' => 'Ссылка не должна быть длиннее 255 символов.',
        ]);

        // пустые необязательные ссылки сохраняем как NULL
        $data['link_img'] = $data['link_img'] ?? null;
        $data['link_kinopoisk'] = $data['link_kinopoisk'] ?? null;

        return $data;
    }
}
