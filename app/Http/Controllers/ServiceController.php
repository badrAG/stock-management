<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Service::latest()->paginate(8);
       
        return response()->json($service);
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
            'name' => 'required|alpha|unique:modeles,name',
        ]);
        Service::create([
           'name' => $request->name
        ]);
        return response()->json(['message'=>'Service ajouté']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        Carbon::setlocale('fr');

        return response()->json([ 
            'id'=>$service->id,
            'name'=>$service->name,
            'agent_count'=>$service->agent->count(),
            'agents'=>$this->agentArray($service->agent),
            ]);
    }
    public function agentArray($comments){
        $jsonComment =[];
        foreach($comments as $comment){
            array_push($jsonComment,[
                'id'=>$comment->id,
                'nom'=>$comment->nom,
                'prenom'=>$comment->prenom,
                'Email'=>$comment->Email,
                'tele'=>$comment->tele,
                'created_at'=>$comment->created_at->diffForHumans(),
            ]);
        }
        return $jsonComment;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    { $request->validate([
        'name' => 'required|alpha|unique:modeles,name',
    ]);
        $service->update([
            'name' => $request->name,
        ]);
        return response()->json(['message'=>'Service Modifié']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['message'=>'service supprimer']);
    }
}
