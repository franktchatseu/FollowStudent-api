<?php

namespace App\Http\Controllers;

use App\CommentResponse;
use Illuminate\Http\Request;

class CommentResponseController extends Controller
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
    public function store(Request $request, $comment_id)
    {
        //
        //
        $request->validate([
            'contenu' => 'string|required',
            'user_response_id' => 'integer|required|exists:App\User,id',
        ]);
        $data = $request->all();
        //uploading image
        if ($file = $request->file('image')) {
            $request->validate(['image'=>'image|mimes:jpeg,png,jpg,gif,svg']);
            $extension = $file->getClientOriginalExtension();
            $relativeDestination ='uploads/Reponse';
            $destinationPath = public_path($relativeDestination);
            $safeName = str_replace(' ','_',$comment_id).time().'.'.$extension;
            $file->move($destinationPath,$safeName);
            $data['image'] = url("$relativeDestination/$safeName");
          }

          //creation du blog
          $reponseComment = CommentResponse::create([
            'user_response_id' => $data['user_response_id'],
            'comment_id' => $comment_id,
            'contenu' => $data['contenu'],
            'image' => $data['image']
        ]);
        return response()->json($reponseComment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CommentResponse  $commentResponse
     * @return \Illuminate\Http\Response
     */
    public function show(CommentResponse $commentResponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommentResponse  $commentResponse
     * @return \Illuminate\Http\Response
     */
    public function edit(CommentResponse $commentResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommentResponse  $commentResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       //
       $request->validate([
        'contenu' => 'string|required',
        'user_response_id' => 'integer|required|exists:App\User,id',
        'comment_id' => 'integer|required|exists:App\BlogComment,id'
    ]);

        $commentReponse = CommentResponse::find($id);
        if ($commentReponse == null) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("COMMENT_RESPONSE_EXISTING");
            $apiError->setErrors(['id' => 'comment response id not existing']);
        }
        //uploading image
        if ($file = $request->file('image')) {
            $request->validate(['image'=>'image|mimes:jpeg,png,jpg,gif,svg']);
            $extension = $file->getClientOriginalExtension();
            $relativeDestination ='uploads/blogsReponse';
            $destinationPath = public_path($relativeDestination);
            $safeName = str_replace(' ','_',$id).time().'.'.$extension;
            $file->move($destinationPath,$safeName);
            $data['image'] = url("$relativeDestination/$safeName");
          }

          //update
          $commentReponse->contenu = $request->contenu;
          $commentReponse->update();
        return response()->json($commentReponse, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommentResponse  $commentResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy($îd)
    {
        //
        //
        //
        $reponseComment = CommentReponse::find($id);
        if(!$reponseComment){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("REPONSE_COMMENT_NOT_FOUND");
            $notFound->setMessage("reponse comment id not found in database.");

            return response()->json($notFound, 404);
        }

        $reponseComment->delete();

        return response()->json(null);
    }
    
}
