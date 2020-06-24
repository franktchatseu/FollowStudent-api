<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        //
        $blog =  Blog::simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($blog);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'titre' => 'required|string',
            'contenu' => 'string|required',
            'blog_categorie_id' => 'integer|required|exists:App\BlogCategorie,id',
            'user_publish_id' => 'integer|required|exists:App\User,id'
        ]);
        $data = $request->all();
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
          $blogPost = Blog::create($data);
        return response()->json($blogPost, 200);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        //
        $request->validate([
            'titre' => 'required|string',
            'contenu' => 'string|required',
            'blog_categorie_id' => 'integer|required|exists:App\BlogCategorie,id',
            'user_publish_id' => 'integer|required|exists:App\User,id'
        ]);

        $blog = Blog::find($id);
        if ($blog == null) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("BLOG_NOT_EXISTING");
            $apiError->setErrors(['id' => 'blog id not existing']);
        }
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

          //update
          $blog->titre = $request->titre;
          $blog->contenu = $request->contenu;
          $blog->blog_categorie_id = $request->blog_categorie_id;
          $blog->update();
        return response()->json($blog, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id){

        //
        $blog = Blog::find($id);
        if(!$blog){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("BLOG_NOT_FOUND");
            $notFound->setMessage("blog  id not found in database.");
            return response()->json($notFound, 404);
        }

        $blog->delete();

        return response()->json(null);
    }
}
