<?php

namespace App\Http\Controllers;

use App\Models\TipoEmprestimo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TipoEmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $TipoEmprestimos = TipoEmprestimo::all();
            return view('view', compact(['TipoEmprestimos'])); 
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
                TipoEmprestimo::create([
                    'descricao' => $request['descricao']
                ]); 
                $sms = "Tipo Emprestimo Adicionado com sucesso";  
            }
            else{
                $TipoEmprestimo = TipoEmprestimo::findOrFail($request->id);
                $TipoEmprestimo->descricao = $request->descricao;
                $TipoEmprestimo->save(); 
                $sms = "Tipo de Emprestimo Editado com sucesso";
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
    public function show(TipoEmprestimo $tipoEmprestimo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoEmprestimo $tipoEmprestimo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoEmprestimo $tipoEmprestimo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        try{
            $TipoEmprestimo = TipoEmprestimo::findOrFail($id);
            $TipoEmprestimo->delete(); 
            return redirect()->back()->with([
                'StatusPositivo' => "Tipo de emprestimo deletado com sucesso",
            ]);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 400); 
        }
    }
}
