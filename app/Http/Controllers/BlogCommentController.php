<?php

namespace App\Http\Controllers;

use App\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request,$blog_id)
    {
        //
        $request->validate([
            'contenu' => 'string|required',
            'user_comment_id' => 'integer|required|exists:App\User,id'
        ]);
        $data = $request->all();
        $blogComment = new BlogComment();
        
        //uploading image
        if ($file = $request->file('image')) {
            $request->validate(['image'=>'image|mimes:jpeg,png,jpg,gif,svg']);
            $extension = $file->getClientOriginalExtension();
            $relativeDestination ='uploads/blogs';
            $destinationPath = public_path($relativeDestination);
            $safeName = str_replace(' ','_',$request->titre).time().'.'.$extension;
            $file->move($destinationPath,$safeName);
            $data['image'] = url("$relativeDestination/$safeName");
          }
          
          //creation du blog
          $blogComment = BlogComment::create([
              'user_comment_id' => $data['user_comment_id'],
              'blog_id' => $blog_id,
              'contenu' => $data['contenu'],
              'image' => $data['image']
          ]);
        return response()->json($blogComment, 200);
    }

    
     
    public function update(Request $request, $id)
    {
       //
       $request->validate([
        'contenu' => 'string|required',
        'blog_id' => 'integer|required|exists:App\Blog,id',
        'user_comment_id' => 'integer|required|exists:App\User,id'
    ]);

        $blogComment = BlogComment::find($id);
        if ($blogComment == null) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("BLOG_COMMENT_EXISTING");
            $apiError->setErrors(['id' => 'blog comment id not existing']);
        }
        //uploading image
        if ($file = $request->file('image')) {
            $request->validate(['image'=>'image|mimes:jpeg,png,jpg,gif,svg']);
            $extension = $file->getClientOriginalExtension();
            $relativeDestination ='uploads/blogsComment';
            $destinationPath = public_path($relativeDestination);
            $safeName = str_replace(' ','_',$id).time().'.'.$extension;
            $file->move($destinationPath,$safeName);
            $data['image'] = url("$relativeDestination/$safeName");
          }

          //update
          $blogComment->contenu = $request->contenu;
          $blogComment->update();
        return response()->json($blogComment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogComment  $blogComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogComment $blogComment)
    {
        //
        //
        $blogComment = BlogComment::find($id);
        if(!$blogComment){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("BLOG_COMMENT_NOT_FOUND");
            $notFound->setMessage("blog colmment id not found in database.");

            return response()->json($notFound, 404);
        }

        $blogComment->delete();

        return response()->json(null);
    }
}
