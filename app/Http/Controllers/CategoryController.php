<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Carbon::setLocale('fr');
        $category = Category::latest()->paginate(8);
       
        return response()->json($category);
        //return response()->json(['categories'=>Category::with('article')->get()]);


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
            'name' => 'required|unique:categories,name',
        ]);
        Category::create([
            'name' => $request->name,
        ]);
        return response()->json(['message'=>'category ajouté']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
 
    public function show(Category $category)
    {
        Carbon::setlocale('fr');

        return response()->json([ 
            'id'=>$category->id,
            'name'=>$category->name,
            'agent_count'=>$category->article->count(),
            'agents'=>$this->agentArray($category->article),
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
                'marque'=>$article->marque->name,
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|alpha',
        ]);
       $category->update([
           'name' => $request->name,
       ]);
       return response()->json(['message'=>'Category Modifié']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message'=>'category supprimer']);
    }
}
