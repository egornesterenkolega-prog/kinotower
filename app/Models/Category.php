<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = ['name', 'parent_id'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * ID всех потомков жанра (нужно, чтобы нельзя было сделать цикл в иерархии).
     */
    public function descendantIds(): array
    {
        $ids = [];
        $queue = [$this->id];

        while ($queue) {
            $children = static::whereIn('parent_id', $queue)->pluck('id')->all();
            $children = array_diff($children, $ids);
            $ids = array_merge($ids, $children);
            $queue = $children;
        }

        return $ids;
    }
}
