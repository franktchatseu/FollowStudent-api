<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentResponse extends Model
{
   //
   protected $fillable = [
    'contenu','image','comment_id','user_response_id'
];

}
