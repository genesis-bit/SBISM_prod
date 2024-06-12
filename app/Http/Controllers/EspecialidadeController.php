<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $Especialidades = Especialidade::all();
            return view('view', compact(['Especialidades'])); 
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
                Especialidade::create([
                    'descricao' => $request['descricao']
                ]); 
                $sms = "Especialidade Adicionado com sucesso"; 
            }
            else{
                $Especialidade = Especialidade::findOrFail($request->id);
                $Especialidade->descricao = $request->descricao;
                $Especialidade->save();
                $sms = "Especialidade Editado com sucesso";
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
    public function show(Especialidade $especialidade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidade $especialidade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Especialidade $especialidade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        try{
            $Especialidade = Especialidade::findOrFail($id);
            $Especialidade->delete(); 
            return redirect()->back()->with([
                'StatusPositivo' => "Especialidade deletado com sucesso",
            ]);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 400); 
        }
    }
}
