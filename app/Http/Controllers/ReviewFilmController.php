<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewFilmController extends Controller
{
    /**
     * Список всех отзывов или отзывов выбранного фильма (?film_id=).
     */
    public function index(Request $request): View
    {
        $filmId = $request->integer('film_id');

        $reviews = Review::with(['film', 'user'])
            ->when($filmId, fn ($query) => $query->where('film_id', $filmId))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'films' => Film::orderBy('name')->get(),
            'filmId' => $filmId,
        ]);
    }

    /**
     * Одобрение отзыва.
     */
    public function approved(Review $review): RedirectResponse
    {
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Отзыв одобрен.');
    }

    /**
     * Удаление отзыва (мягкое, softDeletes).
     */
    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Отзыв удалён.');
    }
}
