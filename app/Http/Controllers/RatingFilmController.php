<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RatingFilmController extends Controller
{
    /**
     * Список всех оценок или оценок выбранного фильма (?film_id=).
     */
    public function index(Request $request): View
    {
        $filmId = $request->integer('film_id');

        $query = Rating::query()->when($filmId, fn ($q) => $q->where('film_id', $filmId));

        $average = (clone $query)->avg('ball');
        $count = (clone $query)->count();

        $ratings = $query->with(['film', 'user'])
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.ratings.index', [
            'ratings' => $ratings,
            'films' => Film::orderBy('name')->get(),
            'filmId' => $filmId,
            'average' => $average,
            'count' => $count,
        ]);
    }

    /**
     * Удаление оценки.
     */
    public function destroy(Rating $rating): RedirectResponse
    {
        $rating->delete();

        return back()->with('success', 'Оценка удалена.');
    }
}
