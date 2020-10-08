<?php

namespace App;
use App\Helper\HasManyRelation;


use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasManyRelation;

    protected $guarded =[];
    protected $fillable = [
        'agent_id'
    ];

    public function articles(){
        return $this->hasMany(ArticleDemande::class);
    }
    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
