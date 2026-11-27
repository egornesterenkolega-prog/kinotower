<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = ['film_id', 'user_id', 'message', 'is_approved'];

    protected function casts(): array
    {
        return ['is_approved' => 'boolean'];
    }

    // фильм или автор могли быть удалены мягко — отзыв всё равно показываем
    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class)->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
