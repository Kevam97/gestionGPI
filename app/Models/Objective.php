<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function specificObjectives()
    {
        return $this->hasMany(SpecificObjective::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
