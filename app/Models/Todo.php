<?php

namespace App\Models;

use App\Enums\TodoStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => TodoStatus::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($todo) {
            if (!in_array($todo->status->value ?? $todo->status, TodoStatus::values())) {
                throw new \InvalidArgumentException(
                    "Invalid status '{$todo->status}'. Allowed statuses are: " . TodoStatus::implode()
                );
            }
        });

        static::updating(function ($todo) {
            if (!in_array($todo->status->value ?? $todo->status, TodoStatus::values())) {
                throw new \InvalidArgumentException(
                    "Invalid status '{$todo->status}'. Allowed statuses are: " . TodoStatus::implode()
                );
            }
        });
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopeSearch(Builder $query, array $filters): Builder
    {
        return $query->when(data_get($filters, 'q'), fn($query, $search) =>
        $query->where('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
        );
    }

    public function scopeStatus(Builder $query, array $filters): Builder
    {
        return $query->when(data_get($filters, 'status'), fn ($query, $status) =>
            $query->where('status', $status)
        );
    }

    public function scopeAssignedTo(Builder $query, array $filters): Builder
    {
        return $query->when(data_get($filters, 'assigned_to'), fn ($query, $userId) =>
            $query->where('assigned_to', $userId)
        );
    }

    public function scopeDueDate(Builder $query, array $filters): Builder
    {
        return $query->when(data_get($filters, 'due_date'), function ($query, $dueDate) {
            if ($dueDate === 'overdue') {
                $query->where('due_date', '<', now())->where('status', '!=', TodoStatus::COMPLETED);
            } elseif ($dueDate === 'today') {
                $query->whereDate('due_date', now());
            } elseif ($dueDate === 'this_week') {
                $query->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()]);
            }
        });
    }
}
