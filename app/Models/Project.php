<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Taks;

class Project extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function tasks(){
        //Returns collection of tasks
        return $this->hasManyThrough(
            Taks::class, 
            Team::class, 
            'project_id', //Foreignkey users table
            'user_id', //Foreign key tasks table
            'id', //local jey in projects table
            'user_id' ///user id in pivot table
        );
    }

    public function task(){
        //Returns task model
        return $this->hasOneThrough(Taks::class, User::class);
    }
}
