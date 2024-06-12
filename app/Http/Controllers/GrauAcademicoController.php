<?php

namespace App\Http\Controllers;

use App\Models\GrauAcademico;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GrauAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $Grau = GrauAcademico::all();
            return view('ferramentas', compact(['Grau'])); 
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
                'descricao' => 'required|min:4',
            ]);
           
            if($request->id == null){
                GrauAcademico::create([
                    'descricao' => $request['descricao']
                ]);  
                $sms = "Grau Academico Adicionado com sucesso";  
            }
            else{
                $GrauAcademico = GrauAcademico::findOrFail($request->id);
                $GrauAcademico->descricao = $request->descricao;
                $GrauAcademico->save();
                $sms = "Grau Academico Editado com sucesso";
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
    public function show(GrauAcademico $grauAcademico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GrauAcademico $grauAcademico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GrauAcademico $grauAcademico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        try{
            $GrauAcademico = GrauAcademico::findOrFail($id);
            $GrauAcademico->delete(); 
            return redirect()->back()->with([
                'StatusPositivo' => "Grau Academico deletado com sucesso",
            ]);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 400); 
        }
    }
}
