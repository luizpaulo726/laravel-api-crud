<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/auth/login', function () {
    return response()->json([
        'message' => 'Usuário não autenticado. Use o endpoint /api/auth/login para fazer login e obter um token de acesso.',
    ], 401);
})->name('login');
