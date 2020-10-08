<?php
namespace App\Http\Controllers;

use App\Article;
use App\Command;
use App\Category;
use App\Modele;
use App\Agent;

use App\Marque;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       Carbon::setLocale('fr');
       $articles = Article::latest()->paginate(8);
       foreach($articles as $article){
        $article->setAttribute('marque',$article->marque);
        $article->setAttribute('modele',$article->modele);
        $article->setAttribute('category',$article->category);
        $article->setAttribute('fournisseur',$article->fournisseur);
        $article->setAttribute('path','/article/'.$article->slug);
    }
       return response()->json($articles);
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

    public function search()
    {
        $results = Article::orderBy('id')
            ->when(request('q'), function($query) {
                $query->where('id', 'like', '%'.request('q').'%')
                ->orWhere('libelle', 'like', '%'.request('q').'%');
            })
            ->limit(6)
            ->get();

        return response()
            ->json(['results' => $results]);
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
            'libelle' => 'required|alpha',
            'qnt' => 'required|integer|min:0',
            'prix' => 'required|integer|min:1',
            'category_id' => 'required',
            'modele_id' => 'required',
            'marque_id' => 'required',
            'fournisseur_id' => 'required',
        ]);
        $name = 'nullprd.jpg';
        if($request->hasFile('image')){
            $name = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('image'),$name);
        } 
        $url = explode('/',url()->current());
        Article::create([
            'libelle' => $request->libelle,
            'qnt' =>$request->qnt,
            'prix'=>$request->prix,
            'slug'=>Str::slug($request->libelle),
            'category_id'=>$request->category_id,
            'marque_id'=>$request->marque_id,
            'modele_id'=>$request->modele_id,
            'fournisseur_id'=>$request->fournisseur_id,
            'photo'=>'/image/'.$name,
        ]);
        return response()->json(['message'=>'Article ajouté']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
        Carbon::setlocale('fr');
      
        return response()->json([ 
            'id'=>$article->id,
            'photo'=>$article->photo,
            'libelle'=>$article->libelle,
            'prix'=>$article->prix,
            'qnt'=>$article->qnt,
            'category'=>$article->category->name,
            'marque'=>$article->marque->name,
            'modele'=>$article->modele->name,
            'fournisseur'=>$article->fournisseur->nom,
            'created_at'=>$article->created_at->diffForHumans(),

            ]);
    }
    public function demandeArray($command){
        $jsonCommand =[];
        foreach($command as $commande){
            array_push($jsonComment,[
                'created_at'=>$commande->created_at->diffForHumans(),
               'fournisseur_prenom'=>$commande->qnt,
            ]);
        }
        return $jsonCommand;
    }
    public function demmandArray($demmand){
        $jsonDemmand =[];
        foreach($demmand as $demmande){
            array_push($jsonComment,[
                'created_at'=>$demmande->created_at->diffForHumans(),
               'agent_prenom'=>$demmande->agent->prenom,
               'agent_nom'=>$demmande->agent->nom,
               'service_name'=>$demmande->agent->service->name
            ]);
        }
        return $jsonDemmand;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'libelle' => 'required|alpha',
            'qnt' => 'required|integer|min:0',
            'prix' => 'required|integer|min:1',
            'category_id' => 'required',
            'marque_id' => 'required',
            'modele_id' => 'required',
            'fournisseur_id' => 'required',
        ]);
         $name = null;
         $photo = $article->photo;
        if($request->hasFile('image')){
            $name = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('image'),$name);
            $photo = '/image/'.$name;
        } 
        $url = explode('/',url()->current());
        $article->update([
            'libelle' => $request->libelle,
            'qnt' =>$request->qnt,
            'prix'=>$request->prix,
            'slug'=>Str::slug($request->libelle),
            'category_id'=>$request->category_id,
            'modele_id'=>$request->modele_id,
            'marque_id'=>$request->marque_id,
            'fournisseur_id'=>$request->fournisseur_id,
            'photo'=>$photo,
        ]);
        return response()->json(['message'=>'Article Modifié']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['message'=>'article supprimer']);
    }
}
