<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        ActivityLogger::log(
            auth()->user(),
            'created',
            $project,
            'Created task: ' . $project->name
        );
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        $changes = $project->getChanges();
        $original = $project->getOriginal();

        $description = [];

        foreach ($changes as $field => $newValue) {
            if ($field === 'updated_at') continue;

            $oldValue = $original[$field] ?? null;

            $description[] = "$field changed from [$oldValue] to [$newValue]";
        }

        ActivityLogger::log(
            auth()->user(),
            'updated',
            $project,
            implode(', ', $description)
        );
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        ActivityLogger::log(
            auth()->user(),
            'deleted',
            $project,
            'Deleted task: ' . $project->name
        );
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
