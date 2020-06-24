<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    //
      //
      protected $fillable = [
         'contenu','image','user_comment_id','blog_id'
    ];

}
