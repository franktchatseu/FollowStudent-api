<?php

namespace App\Http\Controllers;

use App\APIError;
use App\Documentation;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Documentation::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
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
    public function store(Request $req)
    {
        $data = $req->all();

        $req->validate([
            'fichier' => 'required',
            'description' => 'required',
            'tache_id' => 'required:exists:taches,id'
         ]);
            
         if(isset($req->fichier)){
            $file = $req->file('fichier');
            $path = null;
            if($file != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/document";
                $destinationPath = public_path($relativeDestination);
                $safeName = "documentation".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['fichier'] = $path;

        }

         $documentation = new Documentation();
            $documentation->fichier = $data['fichier'];
            $documentation->description = $data['description'];
            $documentation->tache_id = $data['tache_id'];
            $documentation->save();
       
        return response()->json($documentation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function show(Documentation $documentation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function edit(Documentation $documentation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $documentation = Documentation::find($id);
        if (!$documentation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("documentation_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->all();

        $req->validate([
            'fichier' => '',
            'description' => '',
            'tache_id' => 'required:exists:users,id'
         ]);
         
         if(isset($req->fichier)){
            $file = $req->file('fichier');
            $path = null;

            if($file != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/document";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
                if ($documentation->fichier) {
                    $oldImagePath = public_path($documentation->fichier);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['fichier'] = $path;
        }
        if ( $data['fichier']) $documentation->fichier = $data['fichier'];
        if ( $data['description']) $documentation->description = $data['description'];
        if ( $data['tache_id']) $documentation->tache_id = $data['tache_id'];
        
        $documentation->update();

        return response()->json($documentation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $documentation = Documentation::find($id);
        if (!$documentation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DOCUMENTATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
    
            $documentation->delete();      
            return response()->json();
    }

    public function search(Request $req)
    {
        $req->validate([
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Documentation::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $documentation = Documentation::find($id);
        if (!$documentation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DOCUMENTATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            return response()->json($documentation);
        }
}
