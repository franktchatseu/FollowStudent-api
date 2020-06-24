<?php

namespace App\Http\Controllers;

use App\BlogCategorie;
use Illuminate\Http\Request;
use App\APIError;

class BlogCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogCat =  BlogCategorie::simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($blogCat);
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
            'name' => 'required|unique:blog_categories'
        ]);

        $data = $request->only([
            'name',
            'description'
        ]);

        $blogcat = BlogCategorie::create($data);
        return response()->json($blogcat);
    }


   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogCategorie  $blogCategorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $blogcat = BlogCategorie::find($id);
        if ($blogcat == null) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("BLOGCATEGORY_ID_NOT_EXISTING");
            $apiError->setErrors(['id' => 'blog category id not existing']);

            return response()->json($apiError, 404);
        }
        //mise a jour des informaiotn
        $blogcat->name = $request->name;
        $blogcat->description = $request->description;
        $blogcat->update();
        return response()->json($blogcat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogCategorie  $blogCategorie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $blogCategory = BlogCategorie::find($id);
        if(!$blogCategory){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("BLOG_CATEGORY_NOT_FOUND");
            $notFound->setMessage("blog Category id not found in database.");

            return response()->json($notFound, 404);
        }

        $blogCategory->delete();

        return response()->json(null);
    }
}
