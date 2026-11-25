<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Список жанров.
     */
    public function index(): View
    {
        $categories = Category::with('parent')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Форма добавления жанра.
     */
    public function create(): View
    {
        return view('admin.categories.form', [
            'category' => new Category(),
            'parents' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Сохранение нового жанра.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Жанр добавлен.');
    }

    /**
     * Форма изменения жанра.
     */
    public function edit(Category $category): View
    {
        // сам жанр и его потомки не могут быть родителем
        $excluded = array_merge([$category->id], $category->descendantIds());

        return view('admin.categories.form', [
            'category' => $category,
            'parents' => Category::whereNotIn('id', $excluded)->orderBy('name')->get(),
        ]);
    }

    /**
     * Обновление жанра.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request, $category);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Жанр изменён.');
    }

    /**
     * Удаление жанра (мягкое, softDeletes).
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Жанр удалён.');
    }

    private function validated(Request $request, ?Category $category = null): array
    {
        $excluded = $category ? array_merge([$category->id], $category->descendantIds()) : [];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id,deleted_at,NULL',
                function ($attribute, $value, $fail) use ($excluded) {
                    if (in_array((int) $value, $excluded, true)) {
                        $fail('Нельзя выбрать сам жанр или его потомка родителем.');
                    }
                },
            ],
        ], [
            'name.required' => 'Введите название жанра.',
            'name.max' => 'Название не должно быть длиннее 150 символов.',
            'parent_id.exists' => 'Выбран несуществующий родительский жанр.',
        ]);

        $data['parent_id'] = $data['parent_id'] ?? null;

        return $data;
    }
}
