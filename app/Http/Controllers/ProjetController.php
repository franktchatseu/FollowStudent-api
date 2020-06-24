<?php

namespace App\Http\Controllers;

use App\APIError;
use App\Projet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Projet::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'name' => 'required',
            'description' => 'required',
            'date_fin' => 'required',
         ]);
         
         $projet = new Projet();
            $projet->name = $data['name'];
            $projet->description = $data['description'];
            $projet->date_fin = $data['date_fin'];
            $projet->save();
       
        return response()->json($projet);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function show(Projet $projet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function edit(Projet $projet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PROJET_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->all();

        $req->validate([
            'name' => '',
            'description' => '',
            'date_fin' => '',
         ]);
         
        if ( $data['name']) $projet->name = $data['name'];
        if ( $data['description']) $projet->description = $data['description'];
        if ( $data['date_fin']) $projet->date_fin = $data['date_fin'];
        
        $projet->update();

        return response()->json($projet);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PROJET_NOT_FOUND");
            return response()->json($apiError, 404);
        }
    
            $projet->delete();      
            return response()->json();
    }

    public function search(Request $req)
    {
        $req->validate([
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Projet::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PROJET_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            return response()->json($projet);
        }
    
    
}
