<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use App\Agent;
use App\Demande;
use Dompdf\Dompdf;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller
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
    return response()
        ->json([
            'results' => $results,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = [
            'agent_id' => null,
            'agent' => null,
            'articles' => [
                [
                    'article_id' => null,
                    'article' => null,
                    'qnt' => 1
                ]
            ]
        ];

        return response()
            ->json(['form' => $form]);
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
            'agent_id' => 'required|integer|exists:agents,id',
            'articles' => 'required|array|min:1',
            'articles.*.article_id' => 'required|integer|exists:articles,id',
            'articles.*.qnt' => 'required|integer|min:1'
        ]);
        $stock = new Article;
        $invoice = new Demande;
        $invoice->fill($request->except('articles'));

       // $invoice->sub_total = collect($request->items)->sum(function($item) {
        //     return $item['qty'] * $item['unit_price'];
      //   });
     
         $invoice = DB::transaction(function() use ($invoice, $request) {
        //     $counter = Counter::where('key', 'invoice')->first();
        //     $invoice->number = $counter->prefix . $counter->value;

            // custom method from app/Helper/HasManyRelation
            $invoice->storeHasMany([
                 'articles' => $request->articles
            ]);

          //   $counter->increment('value');

            return $invoice;
        });
     
        return response()
            ->json(['saved' => true, 'id' => $invoice->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $model = Demande::with(['agent','agent.service', 'articles.article' ,'articles.article.category',
        'articles.article.marque','articles.article.modele'])
            ->findOrFail($id);

        return response()
            ->json(['model' => $model]);
    }



    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $form = Demande::with(['agent', 'articles.article'])
            ->findOrFail($id);

        return response()
            ->json(['form' => $form]);
    }

    public function update($id, Request $request)
    {
        $invoice = Demande::findOrFail($id);

        $request->validate([
            'agent_id' => 'required|integer|exists:agents,id',
            'articles' => 'required|array|min:1',
            'articles.*.id' => 'sometimes|required|integer|exists:article_demandes,id,demande_id,'.$invoice->id,
            'articles.*.article_id' => 'required|integer|exists:articles,id',
            'articles.*.qnt' => 'required|integer|min:1'
        ]);

        $invoice->fill($request->except('articles'));

        

        $invoice = DB::transaction(function() use ($invoice, $request) {
            // custom method from app/Helper/HasManyRelation
            $invoice->updateHasMany([
                'articles' => $request->articles
            ]);

            return $invoice;
        });

        return response()
            ->json(['saved' => true, 'id' => $invoice->id]);
    }

    public function destroy($id)
    {
        $invoice = Demande::findOrFail($id);

        $invoice->articles()->delete();

        $invoice->delete();

        return response()
            ->json(['deleted' => true]);
    }
}
