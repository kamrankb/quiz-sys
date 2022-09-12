<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FrontendController;

//FRONTEND
Route::name('front.')->group(function() {
       Route::get('/', function() {
              return redirect()->route('login');
       })->name('home');

       Route::get('/quizes', [FrontendController::class, 'quizes'])->name('quizes');
       Route::get('/quiz/{id}', [FrontendController::class, 'attempt_quiz'])->name('quiz.attempt');
       
});

Auth::routes();