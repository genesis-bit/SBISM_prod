<?php

namespace App\Http\Controllers;

use App\Models\PrateleiraLivro;
use App\Models\Prateleira;
use App\Models\Livro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrateleiraLivroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        try{
            $IdsLivrosPrat = PrateleiraLivro::select('livro_id')->get(); //Devolve os livros na prateleira
          //  $Livros = PrateleiraLivro::join('livros', 'prateleira_livros.id', '<>', 'livros.id')->select('livros.*')->get();//Não estão na prateleira
            $Livros = Livro::whereNotIn('id',$IdsLivrosPrat)->get();
            $Prateleiras = Prateleira::with('Livros')->get();
            $PrateleiraLivros = PrateleiraLivro::with('Livro','Prateleira')->get();
            //return response()->json($Prateleiras);
            return view('PrateleiraLivro', compact(['PrateleiraLivros','Livros','Prateleiras'])); 
        }
        catch(Exception $e){
            return response()->json($e, 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
   
    /**
     * Store a newly created resource in storage.     
     */
    public function store(Request $request)
    {
        try{
          
            if($request->id == null){ 
                PrateleiraLivro::create([
                    'livro_id' => $request['livro'],
                    'prateleira_id' => $request['prateleira'],
                    'posicao' => $request['posicao'],
                    'quantidade_livro' => $request['quantidade'],            
                ]); 
                $sms = "Livro adicionado na Prateleira";
            }
            else{
                $Livro = PrateleiraLivro::findOrFail($request->id);
               
            }          
            return redirect()->back()->with([
                'StatusPositivo' => $sms,
            ]);            
        }
        catch(Exception $e){
            return response()->json($e, 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PrateleiraLivro $prateleiraLivro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrateleiraLivro $prateleiraLivro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrateleiraLivro $prateleiraLivro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrateleiraLivro $prateleiraLivro)
    {
        //
    }
    public function LivrosPrateleira($id){
        try{
           $IdsLivrosPrat = PrateleiraLivro::select('livro_id')->get(); 
           $Livros = Livro::whereNotIn('id',$IdsLivrosPrat)->get();
           $PrateleiraLivros = PrateleiraLivro::where('prateleira_id',$id)->with('Livro','Prateleira')->get();

            return view('prateleiraLivro.livrosPrateleira',compact(['PrateleiraLivros','Livros'])); 
        }
        catch(Exception $e){
            return response()->json($e, 400);
        }
    }
}
