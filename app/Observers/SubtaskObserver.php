<?php

namespace App\Observers;

use App\Models\Subtask;

class SubtaskObserver
{
    /**
     * Handle the Subtask "created" event.
     */
    public function created(Subtask $subtask): void
    {
        //
    }

    /**
     * Handle the Subtask "updated" event.
     */
    public function updated(Subtask $subtask): void
    {
        if ($subtask->wasChanged('status')) {
            $task = $subtask->task;

            $completedSubtasksCount = $task->subtasks->where('status', true)->count();
            $task->status = $completedSubtasksCount == $task->subtasks->count();
            $task->save();
        }
    }

    /**
     * Handle the Subtask "deleted" event.
     */
    public function deleted(Subtask $subtask): void
    {
        //
    }

    /**
     * Handle the Subtask "restored" event.
     */
    public function restored(Subtask $subtask): void
    {
        //
    }

    /**
     * Handle the Subtask "force deleted" event.
     */
    public function forceDeleted(Subtask $subtask): void
    {
        //
    }
}
