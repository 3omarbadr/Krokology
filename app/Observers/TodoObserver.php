<?php

namespace App\Observers;

use App\Jobs\NotifyAssignedUserJob;
use App\Models\Todo;
use App\Notifications\TodoNotification;
use Illuminate\Queue\SerializesModels;

class TodoObserver
{
    use SerializesModels;
    public function created(Todo $todo): void
    {
        notifyassigneduserjob::dispatch($todo, 'created');
//        defer(fn() => $todo->assignedTo->notify(new TodoNotification($todo, 'created')));
    }

    public function updated(Todo $todo): void
    {
        notifyassigneduserjob::dispatch($todo, 'updated');
//        defer(fn() => $todo->assignedTo->notify(new TodoNotification($todo, 'updated')));
    }
}
