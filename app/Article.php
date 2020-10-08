<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded =[];

   protected $fillable = [

    'libelle','qnt','slug','prix','photo','category_id','marque_id','modele_id','fournisseur_id'

   ];
   protected $appends = ['text'];

   public function getTextAttribute()
   {
       return $this->attributes['id'].' - '.$this->attributes['libelle'];
   }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class);
    }
    public function modele(){
        return $this->belongsTo(Modele::class);
    }
    public function marque(){
        return $this->belongsTo(Marque::class);
    }
 
    public function demmande(){
        return $this->belongsToMany(Demande::class, 'article_demande');
    }
    public function reteurn(){
        return $this->belongsToMany(Reteurn::class,'article_reteurn');
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function scopeLatest($query){
        return $query->orderBy('created_at','DESC');
    }
}
