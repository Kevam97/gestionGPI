<?php

namespace App\Observers;

use App\Models\SpecificObjective;

class SpecificObjectiveObserver
{
    /**
     * Handle the SpecificObjective "created" event.
     */
    public function created(SpecificObjective $specificObjective): void
    {
        //
    }

    /**
     * Handle the SpecificObjective "updated" event.
     */
    public function updated(SpecificObjective $specificObjective): void
    {
        if ($specificObjective->wasChanged('status')) {
            $objective = $specificObjective->objective;

            $completedSpecificObjectiveCount = $objective->specificObjectives->where('status', true)->count();
            $objective->status = $completedSpecificObjectiveCount == $objective->specificObjectives->count();
            $objective->save();
        }
    }

    /**
     * Handle the SpecificObjective "deleted" event.
     */
    public function deleted(SpecificObjective $specificObjective): void
    {
        //
    }

    /**
     * Handle the SpecificObjective "restored" event.
     */
    public function restored(SpecificObjective $specificObjective): void
    {
        //
    }

    /**
     * Handle the SpecificObjective "force deleted" event.
     */
    public function forceDeleted(SpecificObjective $specificObjective): void
    {
        //
    }
}
