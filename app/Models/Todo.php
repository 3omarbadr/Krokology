<?php

namespace App\Models;

use App\Enums\TodoStatus;
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
}
