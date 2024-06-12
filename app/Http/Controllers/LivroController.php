<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\GeneroLivro;
use App\Models\PrateleiraLivro;
use App\Models\Devolucao;
use App\Models\Emprestimo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LivroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $Livros = Livro::paginate(10);
            $Generos = GeneroLivro::all();
            return view('livro', compact(['Livros','Generos'])); 
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

            $request->validate([
                'titulo' => 'required|min:3',
                'autor' => 'required|string|min:4',
                'editora' => 'required|min:4',
                'anoedicao' => 'required|integer|min:4',
                'observacao' => 'required|min:4',
            ]);
          $sms = "";
           if($request->id == null){ 
                Livro::create([
                    'titulo' => $request['titulo'],
                    'autor' => $request['autor'],
                    'editora' => $request['editora'],
                    'ano_edicao' => $request['anoedicao'],
                    'genero_livro_id' => $request['genero'],
                    'observacao' => $request['observacao']                    
                ]); 
                $sms = "Livro Adicionado com sucesso";
            }
            else{
                $Livro = Livro::findOrFail($request->id);
                $Livro->titulo = $request->titulo;
                $Livro->autor = $request->autor;
                $Livro->editora = $request->editora;
                $Livro->ano_edicao = $request->anoedicao;
                $Livro->genero_livro_id = $request->genero;
                $Livro->observacao = $request->observacao;
                $Livro->save();
                $sms = "Livro Atualizado com sucesso";
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
    public function show($livro)
    {
        try{
            $Livros = Livro::where('titulo','LIKE', '%'.$livro.'%')
            ->orwhere('autor','LIKE', '%'.$livro.'%')
            ->orwhere('ano_edicao','LIKE', '%'.$livro.'%')
            ->orderBy('titulo')
            ->paginate(10);
            $Generos = GeneroLivro::all();
            return view('livro', compact(['Livros','Generos'])); 
        }
        catch(Exception $e){
            return response()->json($e, 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livro $livro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livro $livro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {       
        try{
            $PrateleiraLivros = PrateleiraLivro::where('livro_id',$id)->first();           
            if($PrateleiraLivros==null){
                $Livro = Livro::findOrFail($id);
                $Livro->delete(); 
                return redirect()->back()->with([
                    'StatusPositivo' => "Livro deletado com sucesso",
                ]);
            }            
            else{
                return redirect()->back()->with([
                    'StatusInfo' => "Impossivel apagar, Livro encontra-se na Prateleira"
                ]);
             }
          
        }catch(Exception $e){
            return response()->json($e->getMessage(), 400); 
        }
    }
    public function historico($id){
        try{
           $PrateleiraLivros = PrateleiraLivro::where('livro_id',$id)->with('Livro','Prateleira')->first();           
           if($PrateleiraLivros==null){
            return redirect()->back()->with([
                'StatusInfo' => "Por favor adiciona o livro na Prateleira"
            ]);
           }            
            else{
                $IdsDev = Devolucao::select('id')->get();
                $Solicitacao = Emprestimo::whereNotIn('id', $IdsDev)->where('livro_id', $id)->get();
                
                return view('livros.historico', compact(['PrateleiraLivros', 'Solicitacao'])); 
            }
            
                  
        }catch(Exception $e){
            return response()->json($e->getMessage(), 400); 
        }
    }
    public function PDF() {
        try{
              $Livros = Livro::OrderBy('titulo')->get();
              $pdf = PDF::loadView('relatorio.livro',compact('Livros'));
              return $pdf->stream();
        }
        catch(Exception $e){
              return response()->json($e, 400);
        }    
    }
}
