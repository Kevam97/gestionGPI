<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id'];

    use HasFactory;

    public function  specificObjective()
    {
        return $this->belongsTo(SpecificObjective::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
}
