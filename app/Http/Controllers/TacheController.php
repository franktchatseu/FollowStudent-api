<?php

namespace App\Http\Controllers;

use App\APIError;
use App\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Tache::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'poids' => 'required',
            'date_debut' => 'required',
            'date_delai' => 'required',
            'user_id' => 'required:exists:users,id',
            'projet_id' => 'required:exists:projets,id'
         ]);
            

         $tache = new Tache();
            $tache->name = $data['name'];
            $tache->description = $data['description'];
            $tache->poids = $data['poids'];
            $tache->date_debut = $data['date_debut'];
            $tache->date_delai = $data['date_delai'];
            $tache->user_id = $data['user_id'];
            $tache->projet_id = $data['projet_id'];
            $tache->save();
       
        return response()->json($tache);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function show(Tache $tache)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function edit(Tache $tache)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $tache = Tache::find($id);
        if (!$tache) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("tache_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->all();
        $req->validate([
            'name' => '',
            'description' => '',
            'poids' => '',
            'points' => '',
            'date_debut' => '',
            'date_fin' => '',
            'date_delai' => '',
            'user_id' => 'required:exists:users,id',
            'projet_id' => 'required:exists:projets,id'
         ]);
            

        if ( $data['name']) $tache->name = $data['name'];
        if ( $data['description']) $tache->description = $data['description'];
        if ( $data['poids']) $tache->poids = $data['poids'];
        if ( $data['points']) $tache->points = $data['points'];
        if ( $data['date_debut']) $tache->date_debut = $data['date_debut'];
        if ( $data['date_delai']) $tache->date_delai = $data['date_delai'];
        if ( $data['date_fin']) $tache->date_fin = $data['date_fin'];
        if ( $data['user_id']) $tache->user_id = $data['user_id'];
        if ( $data['projet_id']) $tache->projet_id = $data['projet_id'];
        
        $tache->update();

        return response()->json($tache);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tache = Tache::find($id);
        if (!$tache) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TACHE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
    
            $tache->delete();      
            return response()->json();
    }

    public function search(Request $req)
    {
        $req->validate([
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Tache::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $tache = Tache::find($id);
        if (!$tache) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TACHE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            return response()->json($tache);
        }
}
