<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\QuizModel;
use App\Models\QuizQuestionModel;
use App\Models\QuizResultModel;
use App\Models\QuizStudentModel;
use App\Models\Subjects;
use App\Models\User;
use App\Notifications\QuickNotify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Quiz-Create|Quiz-Edit|Quiz-View|Quiz-Delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:Quiz-Create', ['only' => ['form', 'store']]);
        $this->middleware('permission:Quiz-Edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Quiz-Delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->hasRole('Teacher')) {
                $quizes = QuizModel::where('created_by', Auth::user()->id)->with('subject:id,name');
            } else {
                $quizes = QuizModel::with('subject');
            }
            return DataTables::of($quizes)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = '<button href="#"  class="btn btn-primary btn-view"  data-bs-toggle="modal" data-bs-target=".orderdetailsModal" data-id="' . $row->id . '"><i class="far fa-eye"></i></button>&nbsp; <a href="'.route('quiz.assign.form', $row->id).'" class="btn btn-primary btn-view"><i class="bx bx-user"></i></a>&nbsp; <a data-id="'.$row->id.'" class="btn btn-danger btn-view remove"><i class="bx bx-trash"></i></a>';
                   
                    return $html;
                })->addColumn('created_at', function ($row) {
                    return date('d-M-Y', strtotime($row->created_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->created_at)->diffForHumans() . '</label>';
                })->addColumn('status', function ($row) {
                    $btn = '<div class="square-switch"><input type="checkbox" id="switch' . $row->id . '" class="banner_status" switch="bool" data-id="' . $row->id . '" value="' . ($row->active == 1 ? "1" : "0") . '" ' . ($row->active == 1 ? "checked" : "") . '/><label for="switch' . $row->id . '" data-on-label="Yes" data-off-label="No"></label></div>';

                    return $btn;
                })->rawColumns(['action', 'status', 'created_at'])->make(true);
        }

        return view('admin.quizes.list');
    }

    public function assign_form(Request $request, $quiz_id="")
    {
        $students = User::role('Student')->select('id', 'first_name', 'last_name')->get();
        $quizes = QuizModel::select('id', 'name')->get();
        return view('admin.quizes.assignStudent', compact('students', 'quizes', 'quiz_id'));
    }
    
    public function assigned(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->hasRole('Teacher')) {
                $assigned_quizes = QuizStudentModel::where('created_by', Auth::user()->id)->with('quiz:id,name', 'student:id,first_name,last_name,email', 'result');
            } else {
                $assigned_quizes = QuizStudentModel::with('quiz:id,name', 'student:id,first_name,last_name,email', 'result');
            }
            return DataTables::of($assigned_quizes)
                ->addIndexColumn()
                ->addColumn('student', function ($row) {
                    return $row->student->first_name." ".$row->student->last_name;
                })->addColumn('quiz', function ($row) {
                    return $row->quiz->name;
                })->addColumn('quiz', function ($row) {
                    return $row->quiz->name;
                })->addColumn('result', function ($row) {
                    if($row->result?->correct_answers) {
                        return $row->result->correct_answers." / ".$row->result->total_questions;
                    }
                    return "";
                })->addColumn('created_at', function ($row) {
                    return date('d-M-Y', strtotime($row->created_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->created_at)->diffForHumans() . '</label>';
                })->addColumn('status', function ($row) {
                    if($row->result?->correct_answers) {
                        return "Attempted";
                    }
                    return "Not Attempted Yet.";
                })->rawColumns(['status', 'created_at'])->make(true);
        }

        return view('admin.quizes.assignList');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subjects::select('id', 'name')->get();
        return view('admin.quizes.form', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid =  $request->validate([
            'subject' => 'required',
            'name' => 'required',
            'question_number' => 'required',
            'time_limit' => 'required',
            'difficulty' => 'required',
            'questions.*.question' => 'required',
            'questions.*.answer1' => 'required',
            'questions.*.answer2' => 'required',
            'questions.*.answer3' => 'required',
            'questions.*.answer4' => 'required',
            'questions*.correct_answer' => 'required',
        ]);

        if ($valid) {
            $quiz = new QuizModel();
            $quiz->subject_id = $request->input('subject');
            $quiz->name = $request->input('name');
            $quiz->questions = $request->input('question_number');
            $quiz->difficulty = $request->input('difficulty');
            $quiz->time = $request->input('time_limit');
            $quiz->created_by = Auth::user()->id;

            $management = User::role(['Admin', 'Teacher'])->get();
            $management->pluck('id');
            $data = array(
                "success" => true,
                "message" => "Quiz Added Successfully"
            );

            if ($quiz->save()) {
                $questions = $request->input('questions');
                
                foreach($questions as $qQuestion) {
                    $quiz_question = new QuizQuestionModel();
                    $quiz_question->quiz_id = $quiz->id;
                    $quiz_question->question = $qQuestion["question"];
                    $quiz_question->option1 = $qQuestion["answer1"];
                    $quiz_question->option2 = $qQuestion["answer2"];
                    $quiz_question->option3 = $qQuestion["answer3"];
                    $quiz_question->option4 = $qQuestion["answer4"];
                    $quiz_question->anwer = $qQuestion["correct_answer"];
                    $quiz_question->created_by = Auth::user()->id;

                    $quiz_question->save();
                }

                $notify = array(
                    "performed_by" => Auth::user()->id,
                    "title" => "Added New Subject",
                    "desc" => array(
                        "added_title" => $request->input('name'),
                        "added_description" => $request->message,
                    )
                );
                //Notification::send($management, new QuickNotify($notify));
                Session::flash('success', $data["message"]);
            } else {
                $data["success"] = false;
                $data["message"] = "Quiz Not Added Successfully.";
                Session::flash('error', $data["message"]);
            }
            return redirect()->route('quiz.list')->with($data);
        } else {
            $data["success"] = false;
            $data["message"] = "Validation failed.";
            Session::flash('error', $data["message"]);
            return redirect()->back()->with($data);
        }
    }

    public function assign_store(Request $request) {
        $valid =  $request->validate([
            'quiz' => 'required',
            'student' => 'required',
        ]);

        if ($valid) {
            $quiz = new QuizStudentModel();
            $quiz->quiz_id = $request->input('quiz');
            $quiz->student_id = $request->input('student');
            $quiz->created_by = Auth::user()->id;

            $management = User::role(['Admin', 'Teacher'])->get();
            $management->pluck('id');
            $data = array(
                "success" => true,
                "message" => "Quiz Assigned Successfully"
            );

            if ($quiz->save()) {
                $notify = array(
                    "performed_by" => Auth::user()->id,
                    "title" => "Added New Subject",
                    "desc" => array(
                        "added_title" => $request->input('name'),
                        "added_description" => $request->message,
                    )
                );
                //Notification::send($management, new QuickNotify($notify));
                Session::flash('success', $data["message"]);
            } else {
                $data["success"] = false;
                $data["message"] = "Quiz Not Assigned Successfully.";
                Session::flash('error', $data["message"]);
            }
            return redirect()->route('quiz.assign.list')->with($data);
        } else {
            $data["success"] = false;
            $data["message"] = "Validation failed.";
            Session::flash('error', $data["message"]);
            return redirect()->back()->with($data);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuizModel  $quizModel
     * @return \Illuminate\Http\Response
     */
    public function show(QuizModel $quizModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuizModel  $quizModel
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizModel $quizModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuizModel  $quizModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizModel $quizModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuizModel  $quizModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizModel $quizModel)
    {
        //
    }

    public function view(Request $request) {
        $quizData = QuizModel::select('id','subject_id','name','questions','time','difficulty')
                    ->where('id',$request->id)
                    ->where('status', 1)
                    ->with('subject')->first();

        return response()->json(["status" => true, "data" => $quizData]);
    }

    public function questions_quiz($quiz) {
        $quiz_data = QuizStudentModel::where('id', $quiz)->with('quiz.subject:id,name','quiz.qQuestions:id,quiz_id,question,option1,option2,option3,option4,anwer')->first();
        
        return response()->json(["status"=> true, "data"=> $quiz_data]);
    }

    public function quiz_submit(Request $request, $quiz_assign_id) {
        //$quizUpdate = QuizModel::where('id', $quiz_assign_id)->update(['status' => 2]);
        try {
            $quizUpdate = QuizStudentModel::where('id', $quiz_assign_id)->update(['status' => 2]);
        
            $result = new QuizResultModel();
            $result->quiz_assign_id = $quiz_assign_id;
            $result->quiz_id = $request->quiz_id;
            $result->student_id = Auth::user()->id;
            $result->correct_answers = $request->correct_answers;
            $result->total_questions = $request->total_questions;
            $result->marks = $request->marks;
            $result->data = $request->data;
            $result->created_by = Auth::user()->id;
            $result->status = 1;
    
            if($result->save()) {
                return response()->json(["status"=> true, "message"=> "Saved successfully."]);
            } else {
                return response()->json(["status" => false, "message" => "Not saved successfully."]);
            }
        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json(["status" => false, "message" => $e->getMessage()]);
        }
    }

    public function removeQuiz(Request $request)
    {
        $quiz = QuizModel::where('id', $request->id)->delete();

        if ($quiz) {
            $notification['type'] = "success";
            $notification['message'] = "Quiz Moved to Trash Successfully!.";
            $notification['icon'] = 'mdi-check-all';

            echo json_encode($notification);
        } else {
            $notification['type'] = "danger";
            $notification['message'] = "Failed to Remove Quiz, please try again.";
            $notification['icon'] = 'mdi-block-helper';

            echo json_encode($notification);
        }
    }
}
