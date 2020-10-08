<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleDemande extends Model
{
    protected $fillable = [
        'article_id', 'qnt'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
