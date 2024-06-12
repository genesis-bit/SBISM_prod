<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneroLivroController;
use App\Http\Controllers\PrateleiraController;
use App\Http\Controllers\EstudanteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\PrateleiraLivroController;
use App\Http\Controllers\DevolucaoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\BibliotecarioController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\homeController;
/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!


Route::get('/', function () {
    return Route::redirect('/home');
    return view('login');
});*/
//Route::get('/home', [GeneroLivroController::class,'index']);
Route::redirect('/','/home');
Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home',[homeController::class,'home']);
    Route::resources([
        'categoriaLivro' => GeneroLivroController::class, 
        'curso' => CursoController::class, 
        'emprestimo' => EmprestimoController::class,
        'estudante' => EstudanteController::class, 
        'devolucao' => DevolucaoController::class,
        'docente' => DocenteController::class, 
        'livro' => LivroController::class, 
        'prateleira' => PrateleiraController::class,
        'especialidade' => EspecialidadeController::class,
        'prateleiraLivro' => PrateleiraLivroController::class,
        'biblioteca' => BibliotecarioController::class
    ]);

    Route::post('/solicitarEmprestimo', [EmprestimoController::class, 'solicitar'])->name('solicitarEmprestimo');
    Route::get('/relatorio/estudante', [EstudanteController::class,'PDF']);
    Route::get('/relatorio/docente', [DocenteController::class,'PDF']);
    Route::get('/relatorio/bibliotecario', [BibliotecarioController::class,'PDF']);
    Route::get('/relatorio/livro', [LivroController::class,'PDF']);
    Route::get('/livros/prateleira/{id}', [PrateleiraLivroController::class,'LivrosPrateleira']);
    Route::get('/livros/historico/{id}', [LivroController::class,'historico']);
    Route::post('/relatorio/emprestimo', [EmprestimoController::class,'PDF']);
    Route::get('/perfil', [PerfilController::class,'index']);
    Route::post('/perfil/trocarSenha', [PerfilController::class,'TrocarsSenha'])->name('TrocarSenha');
  });
  