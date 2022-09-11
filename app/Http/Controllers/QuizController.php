<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\QuizModel;
use App\Models\QuizQuestionModel;
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
                    $html = '<button href="#"  class="btn btn-primary btn-view"  data-bs-toggle="modal" data-bs-target=".orderdetailsModal" data-id="' . $row->id . '"><i class="far fa-eye"></i></button>&nbsp';
                    if (Auth::user()->can('Subscriber-Edit')) {
                        $html .= '<a href="' . route('subject.edit', $row->id) . '"  class="btn btn-success btn-edit" ><i class="fas fa-edit"></i></a>&nbsp';
                    }
                    if (Auth::user()->can('Subscriber-Delete')) {
                        $html .= '<button data-id="' . $row->id . '" id="sa-params" class="btn btn-xs  btn-danger btn-delete" ><i class="far fa-trash-alt"></i></button>&nbsp';
                    }
                    return $html;
                })->addColumn('created_at', function ($row) {
                    return date('d-M-Y', strtotime($row->created_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->created_at)->diffForHumans() . '</label>';
                })->addColumn('status', function ($row) {
                    $btn = '<div class="square-switch"><input type="checkbox" id="switch' . $row->id . '" class="banner_status" switch="bool" data-id="' . $row->id . '" value="' . ($row->active == 1 ? "1" : "0") . '" ' . ($row->active == 1 ? "checked" : "") . '/><label for="switch' . $row->id . '" data-on-label="Yes" data-off-label="No"></label></div>';

                    return $btn;
                })->addColumn('image', function ($row) {
                    $imageName = Str::of($row->image)->replace(' ', '%10');
                    if ($row->image) {
                        $image = '<img src=' . asset('/' . $imageName) . ' class="avatar-sm" />';
                    } else {
                        $image = '<img src=' . asset('backend/assets/img/users/no-image.jpg') . ' class="avatar-sm" />';
                    }
                    return $image;
                })->rawColumns(['action', 'status', 'image', 'created_at'])->make(true);
        }

        return view('admin.quizes.list');
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
                $data["message"] = "Subject Not Added Successfully.";
                Session::flash('error', $data["message"]);
            }
            return redirect()->route('subject.list')->with($data);
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
}
