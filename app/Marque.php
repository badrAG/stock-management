<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    protected $guarded =[];

    public function article(){
        return $this->hasMany(Article::class);
    }
}
