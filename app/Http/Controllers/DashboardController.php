<?php

namespace App\Http\Controllers;
use App\Article;
use App\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Demande::with(['agent','agent.service'])
        ->orderBy('created_at', 'desc')
        ->paginate(8);
        $count_article = DB::table('articles')->get()->count();
        $count_demmande = DB::table('demandes')->get()->count();
        $count_return = DB::table('reteurns')->get()->count();
        $count_agent = DB::table('agents')->get()->count();
        $articles = Article::latest()->paginate(5);
        foreach($articles as $article){
         $article->setAttribute('marque',$article->marque);
         $article->setAttribute('modele',$article->modele);
         $article->setAttribute('category',$article->category);
         $article->setAttribute('fournisseur',$article->fournisseur);
         $article->setAttribute('path','/article/'.$article->slug);
     }
      
        return response()->json([
            'results'=>$results,
            'count_article'=>$count_article,
            'count_demmande'=>$count_demmande,
            'count_agent'=>$count_agent,
            'count_return'=>$count_return,
            'last_article'=>$articles,
         ]);
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
        //
    }

   
    
}
