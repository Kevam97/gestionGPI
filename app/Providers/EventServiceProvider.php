<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Project;
use App\Models\SpecificObjective;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;
use App\Observers\SpecificObjectiveObserver;
use App\Observers\SubtaskObserver;
use App\Observers\TaskObserver;
use App\Observers\UserObserver;
use App\Policies\CompanyPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        User::class => [UserObserver::class],
        Subtask::class =>[SubtaskObserver::class],
        Task::class => [TaskObserver::class],
        SpecificObjective::class => [SpecificObjectiveObserver::class]
    ];

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Project::class => ProjectPolicy::class,
        Company::class => CompanyPolicy::class,

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
