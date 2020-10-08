<?php

namespace App\Http\Controllers;

use App\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $fournisseur = Fournisseur::latest()->paginate(10);
       return response()->json($fournisseur);
        
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
            'adresse' => 'required|min:5|max:55',
        ]);
        Fournisseur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->Email,
            'tele' => $request->tele,
            'adresse' => $request->adresse,
        ]);
        return response()->json(['message'=>'Fournisseur ajouté']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function show(Fournisseur $fournisseur)
    {
        Carbon::setlocale('fr');

        return response()->json([ 
            'id'=>$fournisseur->id,
            'nom'=>$fournisseur->nom,
            'prenom'=>$fournisseur->prenom,
            'tele'=>$fournisseur->tele,
            'Email'=>$fournisseur->Email,
            'adresse'=>$fournisseur->adresse,
            'agent_count'=>$fournisseur->article->count(),
            'agents'=>$this->agentArray($fournisseur->article),
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
                'marque'=>$article->marque->name,
                'created_at'=>$article->created_at->diffForHumans(),
            ]);
        }
        return $jsonComment;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function edit(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        $request->validate([
            'nom' => 'required|alpha',
            'prenom' => 'required|alpha',
            'Email' => 'required|email',
            'tele' => 'required|regex:/(06)[0-9]{8}/',
            'adresse' => 'required|min:5|max:55',
        ]);  
       $fournisseur->update([
           'nom' => $request->nom,
           'prenom' =>$request->prenom,
           'tele'=>$request->tele,
           'Email'=>$request->Email,
           'adresse'=>$request->adresse,
       ]);
       return response()->json(['message'=>'Fournisseur Modifié']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return response()->json(['message'=>'fournisseur supprimer']);
    }
}
