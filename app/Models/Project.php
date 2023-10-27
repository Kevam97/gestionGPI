<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Psy\Sudo;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function specificObjectives()
    {
        return $this->hasManyThrough(SpecificObjective::class, Objective::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function boardTasks()
    {
        return $this->hasMany(Task::class)
                    ->whereHas('users', function($query){
                        $query->where('users.id', Auth::id());
                    });
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function boardSubtasks()
    {
        return $this->hasMany(Subtask::class)
                    ->whereHas('task', function ($query){
                        $query->whereHas('users', function($subQuery){
                            $subQuery->where('users.id', Auth::id());
                        });
                    });
    }



}
