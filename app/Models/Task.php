<?php

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'priority',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'status' => TaskStatusEnum::class,
        'priority' => TaskPriorityEnum::class,
    ];

    /**
     * Scope a query to only include tasks of a given status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query)
    {
        if (!request()->has('status') || !in_array(request('status'), array_column(TaskStatusEnum::cases(), 'value'))) {
            return $query;
        }
        return $query->where('status', request('status'));
    }

    /**
     * Scope a query to only include tasks due within a given date range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDueDateRange($query)
    {
        if (request('start_date') && request('end_date')) {
            return $query->whereBetween('due_date', [request('start_date'), request('end_date')]);
        }
        return $query;
    }

    /**
     * Scope a query to filter by text search for title and description and order by relevance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTextSearch($query)
    {
        if (!request()->has('text_search') || is_null(request('text_search'))) {
            return $query;
        }
        return $query->selectRaw('*, MATCH(title, description) AGAINST (?) as relevance', [request('text_search')])
            ->whereRaw('MATCH(title, description) AGAINST (? IN NATURAL LANGUAGE MODE)', [request('text_search')])
            ->orderByDesc('relevance');
    }

    /**
     * Scope a query to order by a given column and direction.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSorting($query)
    {
        $sortable = ['created_at', 'due_date', 'priority'];
        $column = request('sort_by');

        if (!request()->has('sort_by') || !in_array($column, $sortable)) {
            return $query;
        }
        $direction = request('sort_direction', 'desc') === 'asc' ? 'asc' : 'desc';
        return $query->orderBy($column, $direction);
    }
}
