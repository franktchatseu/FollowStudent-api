<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //
    protected $fillable = [
        'titre', 'contenu','image','blog_categorie_id','user_publish_id'
    ];
}

