<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded =[];

    public function agent(){
        return $this->hasMany(Agent::class);
    }
}
