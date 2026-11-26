<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CountryController extends Controller
{
    /**
     * Список стран.
     */
    public function index(): View
    {
        $countries = Country::orderBy('name')->get();

        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Форма добавления страны.
     */
    public function create(): View
    {
        return view('admin.countries.form', ['country' => new Country()]);
    }

    /**
     * Сохранение новой страны.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Country::create($data);

        return redirect()->route('admin.countries.index')->with('success', 'Страна добавлена.');
    }

    /**
     * Форма изменения страны.
     */
    public function edit(Country $country): View
    {
        return view('admin.countries.form', compact('country'));
    }

    /**
     * Обновление страны.
     */
    public function update(Request $request, Country $country): RedirectResponse
    {
        $data = $this->validated($request, $country);

        $country->update($data);

        return redirect()->route('admin.countries.index')->with('success', 'Страна изменена.');
    }

    /**
     * Удаление страны.
     */
    public function destroy(Country $country): RedirectResponse
    {
        // фильмы ссылаются на страну (в том числе удалённые мягко)
        if ($country->films()->withTrashed()->exists()) {
            return redirect()->route('admin.countries.index')
                ->withErrors(['country' => 'Нельзя удалить страну: к ней привязаны фильмы.']);
        }

        $country->delete();

        return redirect()->route('admin.countries.index')->with('success', 'Страна удалена.');
    }

    private function validated(Request $request, ?Country $country = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:countries,name,' . ($country?->id ?? 'NULL')],
        ], [
            'name.required' => 'Введите название страны.',
            'name.max' => 'Название не должно быть длиннее 50 символов.',
            'name.unique' => 'Такая страна уже есть.',
        ]);
    }
}
