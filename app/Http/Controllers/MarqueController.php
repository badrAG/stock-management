<?php

namespace App\Http\Controllers;

use App\Marque;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $marque = Marque::latest()->paginate(14);
       
        return response()->json($marque);
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
        'name' => 'required|alpha|unique:marques,name',
    ]);
        Marque::create([
            'name' => $request->name,
        ]);
        return response()->json(['message'=>'Marque ajouté']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marque  $marque
     * @return \Illuminate\Http\Response
     */
  
    public function show(Marque $marque)
    {
        Carbon::setlocale('fr');

        return response()->json([ 
            'id'=>$marque->id,
            'name'=>$marque->name,
            'agent_count'=>$marque->article->count(),
            'agents'=>$this->agentArray($marque->article),
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
                'modele'=>$article->modele->name,
                'fournisseur'=>$article->fournisseur->nom,
                'created_at'=>$article->created_at->diffForHumans(),
            ]);
        }
        return $jsonComment;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function edit(Marque $marque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marque $marque)
    {
        
        $request->validate([
            'name' => 'required|alpha|unique:marques,name',
        ]);
        $marque->update([
            'name' => $request->name,
        ]);
        return response()->json(['message'=>'Marque Modifié']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marque $marque)
    {
        $marque->delete();
        return response()->json(['message'=>'marque supprimer']);
    }
}
