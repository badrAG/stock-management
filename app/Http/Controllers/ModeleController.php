<?php

namespace App\Http\Controllers;

use App\Modele;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ModeleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $modele = Modele::latest()->paginate(14);
       
        return response()->json($modele);
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
            'name' => 'required|unique:modeles,name',
        ]);
        Modele::create([
            'name' => $request->name,
        ]);
        return response()->json(['message'=>'Modele ajouté']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modele  $modele
     * @return \Illuminate\Http\Response
     */
    public function show(Modele $modele)
    {
        Carbon::setlocale('fr');

        return response()->json([ 
            'id'=>$modele->id,
            'name'=>$modele->name,
            'agent_count'=>$modele->article->count(),
            'agents'=>$this->agentArray($modele->article),
            ]);
    }
    public function agentArray($comments){

        $jsonComment =[];
        foreach($comments as $article){
            array_push($jsonComment,[
                'id'=>$article->id,
                'photo'=>$article->photo,
                'libelle'=>$article->libelle,
                'prix'=>$article->prix,
                'qnt'=>$article->qnt,
                'category'=>$article->category->name,
                'marque'=>$article->marque->name,
                'fournisseur'=>$article->fournisseur->nom,
                'created_at'=>$article->created_at->diffForHumans(),
            ]);
        }
        return $jsonComment;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modele  $modele
     * @return \Illuminate\Http\Response
     */
    public function edit(Modele $modele)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modele  $modele
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modele $modele)
    {
        $request->validate([
            'name' => 'required|unique:modeles,name',
        ]);
        $modele->update([
            'name' => $request->name,
        ]);
        return response()->json(['message'=>'Modele Modifié']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modele  $modele
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modele $modele)
    {
        $modele->delete();
        return response()->json(['message'=>'modele supprimer']);
    }
}
