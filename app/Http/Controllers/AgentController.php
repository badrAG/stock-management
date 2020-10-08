<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Demande;
use App\Article;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agent = Agent::latest()->paginate(10);
        foreach($agent as $agents){
            $agents->setAttribute('service',$agents->service);
        }
        return response()->json($agent);
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
        $request->validate([
            'nom' => 'required|alpha',
            'prenom' => 'required|alpha',
            'Email' => 'required|email',
            'tele' => 'required|regex:/(06)[0-9]{8}/',
            'service_id' => 'required|integer|exists:services,id',
        ]);
        Agent::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'Email' => $request->Email,
            'tele' => $request->tele,
            'service_id' => $request->service_id,
        ]);
        return response()->json(['message'=>'Agent ajouté']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        return response()->json([ 
            'id'=>$agent->id,
            'nom'=>$agent->nom,
            'prenom'=>$agent->prenom,
            'tele'=>$agent->tele,
            'Email'=>$agent->Email,
            'service'=>$agent->service->name,
           
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'nom' => 'required|alpha',
            'prenom' => 'required|alpha',
            'Email' => 'required|email',
            'tele' => 'required|regex:/(06)[0-9]{8}/',
            'service_id' => 'required|integer|exists:services,id',
        ]);
        $agent->update([
            'nom' => $request->nom,
            'prenom' =>$request->prenom,
            'tele'=>$request->tele,
            'Email'=>$request->Email,
            'service_id'=>$request->service_id,
        ]);
        return response()->json(['message'=>'Agent Modifié']);
    }
    public function search()
    {
        $results = Agent::orderBy('nom')
            ->when(request('q'), function($query) {
                $query->where('nom', 'like', '%'.request('q').'%')
                    ->orWhere('prenom', 'like', '%'.request('q').'%')
                    ->orWhere('tele', 'like', '%'.request('q').'%');
            })
            ->limit(6)
            ->get();

        return response()
            ->json(['results' => $results]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return response()->json(['message'=>'agent supprimer']);
    }
}
