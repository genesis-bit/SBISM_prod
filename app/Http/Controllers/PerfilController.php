<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PerfilController extends Controller
{
    
    public function index( ){     
        return view('perfil');   
    }

    public function TrocarsSenha(Request $request){
        try{            
            $request->validate([
                'password' => 'required|confirmed|min:4'
            ]);
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->back()->with([
                'StatusPositivo' => "Palavra Passe alterada com sucesso",
            ]);  

        }
        catch(Exception $E){

        }
    }
}
