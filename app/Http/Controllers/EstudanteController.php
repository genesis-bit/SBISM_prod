<?php

namespace App\Http\Controllers;

use App\Models\Estudante;
use App\Models\Curso;
use App\Models\User;
use App\Models\Livro;
use App\Models\TipoEmprestimo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class EstudanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $Estudantes = Estudante::orderBy('nome')->paginate(10);
            $Cursos = Curso::all();
            $Livros = Livro::all();
            $Estudante = new Estudante();
            $TipoE = TipoEmprestimo::all();
            return view('estudante', compact(['Estudantes','Cursos','Estudante','Livros','TipoE'])); 
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
       
    }

    /**
     * Store a newly created resource in storage.   
     */
    public function store(Request $request)
    {
        try{
                  
            if($request->idEstudante == null){ 
                $request->validate([
                    'nome' => 'required|min:5',
                    'email' => 'required|email|unique:users,email',
                    'processo' => 'required|unique:estudantes,numero_estudante',
                    'bilhete' => 'required|min: 6 |unique:estudantes,numero_bilhete',
                    'contacto' => 'min: 9| unique:estudantes,contacto',
                ]);
    
                $usuario = new RegisterController();
                $est = $usuario::usuario(['name' => $request['nome'], 'email' => $request['email'], 'tipo_user_id' => '4', 'password' => '0123456789']);            
                
                Estudante::create([
                    'id' => $est['id'],
                    'nome' => $request['nome'],
                    'curso_id' => $request['curso'],
                    'numero_estudante' => $request['processo'],
                    'numero_bilhete' => $request['bilhete'],
                    'contacto' => $request['contacto']                  
                ]); 
                $sms = "Estudante cadastrado com sucesso";
            }
            else{               
                $request->validate([
                    'nome' => 'required|min:5',
                    'processo' => 'required',
                    'bilhete' => 'required|min: 5',
                    'contacto' => 'required| min: 9',
                ]);

                $Estudante = Estudante::findOrFail($request->idEstudante);
                if($Estudante->contacto != $request->contacto)$request->validate(['contacto' => 'unique:estudantes,contacto']);
                if($Estudante->numero_estudante != $request->processo)$request->validate(['processo' => 'unique:estudantes,numero_estudante']);
                if($Estudante->numero_bilhete != $request->bilhete)$request->validate(['bilhete' => 'unique:estudantes,numero_bilhete']);

                $Estudante->nome = $request->nome;
                $Estudante->curso_id = $request->curso;
                $Estudante->numero_estudante = $request->processo;
                $Estudante->numero_bilhete = $request->bilhete;
                $Estudante->contacto = $request->contacto;

                $Estudante->save();

                $sms = "Estudante atualizado com sucesso";
            }          
            return redirect()->back()->with([
                'StatusPositivo' => $sms,
            ]);            ;            
        }
        catch(Exception $e){
            return response()->json($e, 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($data)
    {
        try{
            
            $Estudantes = Estudante::where('nome','LIKE', '%'.$data.'%')
            ->orwhere('numero_estudante','LIKE', '%'.$data.'%')
            ->orwhere('numero_bilhete','LIKE', '%'.$data.'%')
            ->orderBy('nome')
            ->paginate(10);
            $Cursos = Curso::all();
            $Estudante = new Estudante();
            $Livros = Livro::all();
            $TipoE = TipoEmprestimo::all();
            return view('estudante', compact(['Estudantes','Cursos','Estudante','Livros','TipoE'])); 
                  
        }
        catch(Exception $e){
            return response()->json($e, 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudante $estudante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudante $estudante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudante $estudante)
    {
        //
    }
    public function PDF() {
        try{
            $Estudantes = Estudante::OrderBy('nome')->get();
              $pdf = PDF::loadView('relatorio.estudante',compact('Estudantes'));
              return $pdf->stream();
        }
        catch(Exception $e){
              return response()->json($e, 400);
        }    
    }
}
