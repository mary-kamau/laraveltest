<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Team extends Pivot
{
    use HasFactory;

        /**
     * 
     * Table ssociated with the Model
     * 
     * @var string
     * 
    */

    protected $table =  'project_user';
}
