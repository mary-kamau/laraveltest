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
        return $this->hasMany(User::class);
    }

    public function tasks(){
        //Returns collection of tasks
        return $this->hasManyThrough(Taks::class, User::class, 'project_id', 'user_id', 'id');
    }

    public function task(){
        //Returns task model
        return $this->hasOneThrough(Taks::class, User::class);
    }
}
