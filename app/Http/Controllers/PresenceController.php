<?php

namespace App\Http\Controllers;

use App\APIError;
use App\Presence;
use App\Projet;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Presence::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'heure_arrivee' => 'required',
            'date_presence' => 'required',
            'user_id' => 'required:exists:users,id'
         ]);
         
       
            $presence = new Presence();
            $presence->heure_arrivee = $data['heure_arrivee'];
            $presence->date_presence = $data['date_presence'];
            $presence->user_id = $data['user_id'];
            $presence->save();
       
        return response()->json($presence);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function show(Presence $presence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function edit(Presence $presence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $presence = Presence::find($id);
        if (!$presence) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("presence_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->all();

        $req->validate([
            'heure_arrivee' => '',
            'date_presence' => '',
            'heure_depart' => '',
            'points' => '',
            'user_id' => 'required:exists:users,id'
         ]);
         

        if ( $data['heure_arrivee']) $presence->heure_arrivee = $data['heure_arrivee'];
        if ( $data['date_presence']) $presence->date_presence = $data['date_presence'];
        if ( $data['heure_depart']) $presence->heure_depart = $data['heure_depart'];
        if ( $data['points']) $presence->points = $data['points'];
        if ( $data['user_id']) $presence->user_id = $data['user_id'];
        
        $presence->update();

        return response()->json($presence);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $presence = Presence::find($id);
        if (!$presence) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PRESENCE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
    
            $presence->delete();      
            return response()->json();
    }

    public function search(Request $req)
    {
        $req->validate([
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Presence::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $presence = Presence::find($id);
        if (!$presence) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PRESENCE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            return response()->json($presence);
        }
    
}
