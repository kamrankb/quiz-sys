<?php

namespace App\Http\Controllers;

use App\Models\Contactinfo;
use App\Models\Contactqueries;
use App\Models\Pages;
use App\Models\QuizResultModel;
use App\Models\QuizStudentModel;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.pages.home');
    }

    public function quizes(Request $request) {
        // $quizes = QuizStudentModel::where('student_id', Auth::id())
        //             ->where('status', 1)
        //             ->with(['student:id,first_name,last_name','quiz' => function($query) {
        //                 $query->with('subject:id,name');
        //                 $query->where('status',1);
        //                 return $query;
        //                 //.subject:id,name
        //             }, 'result:marks'])->get();
        $quizes = QuizStudentModel::where('student_id', Auth::id())
                    ->where('status', 1)
                    ->with(['student:id,first_name,last_name','quiz.subject:id,name', 'result:marks'])->get();
                    
        return view('frontend.pages.student_quiz', compact('quizes'));
    }

    public function results(Request $request) {
        $quizes = QuizResultModel::where('student_id', Auth::id())->with('student:id,first_name,last_name','quiz.subject:id,name')->get();
        
        return view('frontend.pages.quiz_results', compact('quizes'));
    }

    public function attempt_quiz(Request $request) {
        return view('frontend.pages.quiz_attempt');
    }
}
