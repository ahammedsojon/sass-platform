<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        ActivityLogger::log(
            auth()->user(),
            'created',
            $task,
            'Created task: ' . $task->title
        );
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $changes = $task->getChanges();
        $original = $task->getOriginal();

        $description = [];

        foreach ($changes as $field => $newValue) {
            if ($field === 'updated_at') continue;

            $oldValue = $original[$field] ?? null;

            $description[] = "$field changed from [$oldValue] to [$newValue]";
        }

        ActivityLogger::log(
            auth()->user(),
            'updated',
            $task,
            implode(', ', $description)
        );
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        ActivityLogger::log(
            auth()->user(),
            'deleted',
            $task,
            'Deleted task: ' . $task->title
        );
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
