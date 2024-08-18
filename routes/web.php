<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Controllers will be imported here
use App\Http\Controllers\PhonebookController;
use App\Http\Controllers\LoginController;

//Phonebook
Route::get('/', [PhonebookController::class, 'Index']);
Route::get('/contato/obterContatos', [PhonebookController::class, 'GetContacts']);
Route::delete('/contato/deletar', [PhonebookController::class, 'DeleteContact']);

//Login
Route::get('/login', [LoginController::class, 'Index'])->name('login');
Route::post('/login/autenticar', [LoginController::class, 'Authenticate']);
Route::get('/sair', [LoginController::class, 'Logout']);