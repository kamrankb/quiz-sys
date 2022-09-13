<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\QuizController;

//FRONTEND
Route::name('front.')->group(function() {
       Route::get('/', function() {
              return redirect()->route('login');
       })->name('home');

       Route::get('/quizes', [FrontendController::class, 'quizes'])->name('quizes');
       Route::get('/quiz/{id}', [FrontendController::class, 'attempt_quiz'])->name('quiz.attempt')->middleware('studentQuizAuthentication');
       Route::get('/quiz/questions/{id}', [QuizController::class, 'questions_quiz'])->name('quiz.questions')->middleware('studentQuizAuthentication');
       
});

Auth::routes();