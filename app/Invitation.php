<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $guarded = [];

    public function fullName(){
        return ucwords($this->first_name.' '.$this->last_name);
    }
}
