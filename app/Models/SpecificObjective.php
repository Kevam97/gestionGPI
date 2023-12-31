<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificObjective extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


}
