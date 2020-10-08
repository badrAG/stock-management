<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $guarded =[];

    protected $fillable = [
        'nom', 'prenom', 'Email',
        'tele','service_id'
    ];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['nom']. ' - '.$this->attributes['prenom'];
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function demande(){
        return $this->hasMany(Demande::class)->orderBy('created_at','DESC');
    }
    public function reteurn(){
        return $this->hasMany(Reteurn::class);
    }

}
