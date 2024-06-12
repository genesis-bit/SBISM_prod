<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneroLivro;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    //
    public function home(){
        try{
           
             $Livro = Livro::count();
               if(Auth::user()->tipo_user_id == 1 || Auth::user()->tipo_user_id == 2){
                 $Users = User::select(DB::raw('tipo_user_id as TipoUser, count(*) as Qtand'))
                     ->where('tipo_user_id', '<>', 1)
                    ->groupBy('tipo_user_id')
                    ->get();
                    $qtdUsuarios = [0,0,0];
                    foreach($Users as $U){
                        if($U->TipoUser == 2) $qtdUsuarios[0] = $U->Qtand;
                        if($U->TipoUser == 3) $qtdUsuarios[1] = $U->Qtand;
                        if($U->TipoUser == 4) $qtdUsuarios[2] = $U->Qtand;
                    }
                    
                    return view('homeAdmin', compact(['qtdUsuarios','Livro'])); 
               } 
               else{
                return view('homeOther', compact(['Livro'])); 
               }
            
        }
        catch(Exception $e){
            return response()->json($e, 400);
        }
    }
  
}
