<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PostTag extends Pivot
{
    use HasFactory;

    /**
     * 
     * Table ssociated with the Model
     * 
     * @var string
     * 
    */

    protected $table =  'post_tag';

    protected static function booted(){
        parent::booted();

        static::created(
            function($item){
                dd($item);
            }
        );
    }
}
