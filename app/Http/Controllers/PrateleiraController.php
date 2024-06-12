<?php

namespace App\Http\Controllers;

use App\Models\Prateleira;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrateleiraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $Prateleiras = Prateleira::all();
            return view('view', compact(['Prateleiras'])); 
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
                Prateleira::create([
                    'descricao' => $request['descricao']
                ]);  
                $sms = "Prateleira Adicionado com sucesso"; 
            }
            else{
                $Prateleira = Prateleira::findOrFail($request->id);
                $Prateleira->descricao = $request->descricao;
                $Prateleira->save();
                $sms = "Prateleira Editada com sucesso";
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
    public function show(Prateleira $prateleira)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prateleira $prateleira)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prateleira $prateleira)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        try{
            $Prateleira = Prateleira::findOrFail($id);
            $Prateleira->delete(); 
            return redirect()->back()->with([
                'StatusPositivo' => "Prateleira deletado com sucesso",
            ]);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 400); 
        }
    }
}
