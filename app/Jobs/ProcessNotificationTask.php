<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessNotificationTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->sendEmailTask();
    }

    private function sendEmailTask()
    {
        $tasks = Task::whereDate('end','<=', now()->addDays(2))
                        ->whereHas('project', function($query){
                                $query->where('status',0);
                        })
                        ->get();


        foreach ($tasks as $task)
        {
            foreach ($task->users as $user)
            {
                Mail::to($user->email)->queue($task, $user);
            }
        }

    }
}
