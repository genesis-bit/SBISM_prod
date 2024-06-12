<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\GrauAcademico;
use App\Models\Especialidade;
use App\Models\Livro;
use App\Models\TipoEmprestimo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;





class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $Grau = GrauAcademico::all();
            $Especialidades = Especialidade::all();
            $Docentes = Docente::orderBy('nome')->paginate(10);
            $DocenteVazio = new Docente();
            $Livros = Livro::all();
            $TipoE = TipoEmprestimo::all();
            return view('docente', compact(['Docentes','Grau','Especialidades','DocenteVazio','Livros','TipoE'])); 
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

            if($request->idDocente == null){ 
            $request->validate([
                    'nome' => 'required|min:5',
                    'email' => 'required|email|unique:users,email',
                    'processo' => 'required|unique:docentes,numero_professor',
                    'bilhete' => 'required|unique:docentes,numero_bilhete|min: 5',
                    'contacto' => 'required| min: 9| unique:docentes,contacto',
            ]);
            $usuario = new RegisterController();
            $doc = $usuario::usuario(['name' => $request['nome'], 'email' => $request['email'], 'tipo_user_id' => '3', 'password' => '0123456789']);  
                Docente::create([
                    'id' => $doc['id'],
                    'nome' => $request['nome'],
                    'grau_academico_id' => $request['grau'],
                    'numero_professor' => $request['processo'],
                    'especialidade_id' => $request['especialidade'],
                    'numero_bilhete' => $request['bilhete'],
                    'contacto' => $request['contacto']                  
                ]); 
                $sms = "Docente cadastrado com sucesso";
            }
            else{
                $request->validate([
                    'nome' => 'required|min:5',
                    'processo' => 'required',
                    'bilhete' => 'required|min: 5',
                    'contacto' => 'required| min: 9',
            ]);
                $Docente = Docente::findOrFail($request->idDocente);
                if($Docente->contacto != $request->contacto)$request->validate(['contacto' => 'unique:docentes,contacto']);
                if($Docente->numero_professor != $request->processo)$request->validate(['processo' => 'unique:docentes,numero_professor']);
                if($Docente->numero_bilhete != $request->bilhete)$request->validate(['bilhete' => 'unique:docentes,numero_bilhete']);

                $Docente->nome = $request->nome;
                $Docente->grau_academico_id = $request->grau;
                $Docente->numero_professor = $request->processo;
                $Docente->especialidade_id = $request->especialidade;
                $Docente->numero_bilhete = $request->bilhete;
                $Docente->contacto = $request->contacto;

                $Docente->save();
                
                $sms = "Docente atualizado com sucesso";
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
    public function show($data)
    {
        try{
            $Docentes = Docente::where('nome','LIKE', '%'.$data.'%')
            ->orwhere('numero_professor','LIKE', '%'.$data.'%')
            ->orwhere('numero_bilhete','LIKE', '%'.$data.'%')
            ->orderBy('nome')
            ->paginate(10);

            $Grau = GrauAcademico::all();
            $Especialidades = Especialidade::all();
            $DocenteVazio = new Docente();
            $Livros = Livro::all();
            $TipoE = TipoEmprestimo::all();
            return view('docente', compact(['Docentes','Grau','Especialidades','DocenteVazio','Livros','TipoE'])); 
        }
        catch(Exception $e){
            return response()->json($e, 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Docente $docente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        //
    }
    public function PDF() {
        try{
              $Docentes = Docente::OrderBy('nome')->get();
              $pdf = PDF::loadView('relatorio.docente',compact('Docentes'));
              return $pdf->stream();
        }
        catch(Exception $e){
              return response()->json($e, 400);
        }    
    }
}
