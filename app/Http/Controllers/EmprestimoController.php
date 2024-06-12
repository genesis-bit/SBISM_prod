<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Estudante;
use App\Models\Docente;
use App\Models\Livro;
use App\Models\User;
use App\Models\Devolucao;
use App\Models\PrateleiraLivro;
use App\Models\TipoEmprestimo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class EmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{ 
            $IdsDev = Devolucao::select('id')->get();
            $Solicitados = Emprestimo::whereNotIn('id', $IdsDev)
                ->where('tipo_emprestimo_id','=',1)->get();
            $Emprestimos = Emprestimo::whereNotIn('id', $IdsDev)
                ->where('tipo_emprestimo_id','=',2)->get();
            $Vencidos = Emprestimo::whereNotIn('id', $IdsDev)->where('data_emprestimo','<',today())->get();
           $Devolvidos = Devolucao::paginate(10);
            $Estudantes = Estudante::all();
            $Docentes = Docente::all();
            $Livros = PrateleiraLivro::join('livros', 'prateleira_livros.id', '=', 'livros.id')->select('livros.*')->get();

            $TipoE = TipoEmprestimo::all();
            return view('emprestimo', compact(['Emprestimos','Estudantes','Docentes','Livros','TipoE', 'Devolvidos','Solicitados', 'Vencidos'])); 
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

    public function solicitar(Request $request)
    {      
       
        $IdsDev = Devolucao::select('id')->get();
        if($request->IdUsuario == null)
            $IdUsuario = $request->ctrlId % 2 == 0? $request->estudante:$request->docente;
        else
            $IdUsuario = $request->IdUsuario;

        $Emprestante = User::where('id','=',$IdUsuario)->with('TipoUsuario')->get();
        $Livros = PrateleiraLivro::where('livro_id','=',$request->livro)->with(['Livro','Prateleira'])->get();
        $Data = $request -> data;
        $Tipo = $request -> tipoE;
        $LivrosOcupados = Emprestimo::whereNotIn('id', $IdsDev)
            ->where('livro_id','=',$request->livro)->get();
        return view('solicitar', compact(['Emprestante','Livros','LivrosOcupados','Data','Tipo']));         
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{    
            $IdBlibliotecario = Auth::user()->id;
          
            Emprestimo::create([
                    'livro_id' => $request['livro'],
                    'user_id' => $request['usuario'],
                    'tipo_emprestimo_id' => $request['tipoE'],
                    'bibliotecario_id' => $IdBlibliotecario,
                    'data_emprestimo' => $request['data'],                
                ]); 
             
            return redirect()->route('emprestimo.index')->with([
                'StatusPositivo' => "Pedido realizado com sucesso",
            ]);            
        }
        catch(Exception $e){
            return response()->json($e, 400);
        }  
        //
    }
    /**
     * Display the specified resource.
     */
    public function show(Emprestimo $emprestimo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Emprestimo $emprestimo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Emprestimo $emprestimo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emprestimo $emprestimo)
    {
        //
    }
    public function PDF(Request $request) {
        try{
              $Biblioteca = Emprestimo::with(['Devolucao'])
                              ->where('created_at','>=', $request->dataI)
                              ->where('data_emprestimo','<=', $request->dataF)
                              ->get();
            
             $data = [$request->dataI, $request->dataF];
             
             $pdf = PDF::loadView('relatorio.emprestimo',compact('Biblioteca','data'));
             return $pdf->setPaper('a4', 'landscape')->stream();
        }
        catch(Exception $e){
              return response()->json($e, 400);
        }    
    }
}
