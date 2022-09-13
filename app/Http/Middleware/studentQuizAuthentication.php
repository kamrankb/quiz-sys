<?php

namespace App\Http\Middleware;

use App\Models\QuizStudentModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class studentQuizAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $quizes = QuizStudentModel::where('student_id', Auth::id())->count();
        
        if($quizes>0) {
            return $next($request);
        } else {
            abort(404);
        }
    }
}
