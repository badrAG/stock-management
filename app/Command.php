<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    public function article(){
        return $this->hasMany(Article::class);
    }
    public function fournisseur(){
        return $this->hasMany(Fournisseur::class);
    }
}
