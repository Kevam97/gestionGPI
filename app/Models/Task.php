<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id'];

    use HasFactory;

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];

    public function  specificObjective()
    {
        return $this->belongsTo(SpecificObjective::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
}
