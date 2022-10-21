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

       Route::get('/quizes', [FrontendController::class, 'quizes'])->name('quizes')->middleware('studentQuizAuthentication');
       Route::get('/results', [FrontendController::class, 'results'])->name('quizes.results')->middleware('studentQuizAuthentication');
       Route::post('/quiz/submit/{quiz_assign_id}', [QuizController::class, 'quiz_submit'])->name('quiz.quiz_submit')->middleware('studentQuizAuthentication');
       Route::get('/quiz/{id}', [FrontendController::class, 'attempt_quiz'])->name('quiz.attempt')->middleware('studentQuizAuthentication');
       Route::get('/quiz/questions/{id}', [QuizController::class, 'questions_quiz'])->name('quiz.questions')->middleware('studentQuizAuthentication');
       
});

Auth::routes();