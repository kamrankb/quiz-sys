<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Subjects;
use Illuminate\Support\Facades\Notification;
use App\Notifications\QuickNotify;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Claims\Subject;

class SubjectsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Subject-Create|Subject-Edit|Subject-View|Subject-Delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:Subject-Create', ['only' => ['form', 'store']]);
        $this->middleware('permission:Subject-Edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Subject-Delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subjects = Subjects::all();
            return DataTables::of($subjects)
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

        return view('admin.subjects.list');
    }

    public function form($id = 0)
    {
        return view('admin.subjects.form');
    }

    public function status(Request $request, $id)
    {
        $subject = Subjects::find($id);
        $subject->active = (($request->status == "true") ? 1 : 0);

        $response = array();

        if ($subject->save()) {
            $response["success"] = true;
            $response["message"] = "Subject Status Updated Successfully!";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to Update Subject Status!";
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $valid =  $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'nullable',

        ]);

        if ($valid) {
            $subject = new Subjects();
            $subject->name = $request->input('name');
            $subject->title = $request->input('title');
            $subject->description = strip_tags($request->description);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $image_destinationPath = public_path($this->subjectimagepath);
                $image->move($image_destinationPath, $imagename);
                $imagename = $this->subjectimagepath . $imagename;
                $subject->image = $imagename;
            }

            $management = User::role(['Admin', 'Teacher'])->get();
            $management->pluck('id');
            $data = array(
                "success" => true,
                "message" => "Subject Added Successfully"
            );

            if ($subject->save()) {
                $notify = array(
                    "performed_by" => Auth::user()->id,
                    "title" => "Added New Subject",
                    "desc" => array(
                        "added_title" => $request->input('name'),
                        "added_description" => $request->message,
                    )
                );
                Notification::send($management, new QuickNotify($notify));
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
    public function edit(Request $request, $id)
    {
        $where = array('id' => $request->id);
        $subject  = Subjects::where($where)->first();

        return view('admin.subject.edit', compact('subject'));
    }

    public function view(Request $request, $isTrashed = null)
    {
        $where = array('id' => $request->id);

        if ($isTrashed != null) {
            $contactqueries = Subjects::onlyTrashed()->where($where)->first();
        } else {
            $contactqueries = Subjects::where($where)->first();
        }

        return Response::json($contactqueries);
    }

    public function update(Request $request)
    {

        $valid =  $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'nullable',
        ]);

        if ($valid) {
            $subject = Subjects::find($request->id);
            $subject->name = $request->input('name');
            $subject->title = $request->input('title');
            $subject->description = strip_tags($request->description);

            $management = User::role(['Admin'])->get();
            $management->pluck('id');
            $data = array(
                "success" => true,
                "message" => "Subject Updated Successfully"
            );

            if ($subject->save()) {
                $notify = array(
                    "performed_by" => Auth::user()->id,
                    "title" => "Subject Updated Successfully",
                    "desc" => array(
                        "added_title" => $request->input('name'),
                        "added_description" => $request->email,
                    )
                );
                Notification::send($management, new QuickNotify($notify));
                Session::flash('success', $data["message"]);
            } else {
                $data["success"] = false;
                $data["message"] = "Subject Not Updated Successfully.";

                Session::flash('error', $data["message"]);
            }

            return redirect()->route('subject.list')->with($data);
        } else {
            return redirect()->back();
        }
    }

    public function restore(Request $request, $id)
    {
        $Contactqueries = Subjects::withTrashed()->find($id);
        $response = array(
            "success" => true,
            "message" => "Subject Restored Successfully!"
        );

        if (!$Contactqueries->restore()) {
            $response["success"] = false;
            $response["message"] = "Failed to Restore Subject!";
        }

        return redirect()->route('subject.list')->with($response);
    }

    public function destroy(Request $request)
    {
        $subscriber = Subjects::onlyTrashed()->find($request->id);

        $response = array(
            "success" => true,
            "message" => "Subject Destroy Successfully!"
        );

        if (!$subscriber->forceDelete()) {
            $response["success"] = false;
            $response["message"] = "Failed to Destroy Subject!";
        }

        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $subject = Subjects::find($request->id);
        $response = array(
            "success" => true,
            "message" => "Subject deleted Successfully!"
        );

        if (!$subject->delete()) {
            $response["success"] = false;
            $response["message"] = "Failed to deleted Subject!";
        }

        return response()->json($response);
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $subscriber = Subjects::onlyTrashed();
            return DataTables::of($subscriber)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = '<button href="#"  class="btn btn-primary btn-view"  data-bs-toggle="modal" data-bs-target=".orderdetailsModal" data-id="' . $row->id . '"><i class="far fa-eye"></i></button>&nbsp';
                    if (Auth::user()->can('Subscriber-Edit')) {
                        $html .= '<a href="' . route('subjects.restore', $row->id) . '"  class="btn btn-success btn-restore" ><i class="mdi mdi-delete-restore"></i></a>&nbsp';
                    }
                    if (Auth::user()->can('Subscriber-Delete')) {
                        $html .= '<button data-id="' . $row->id . '" id="sa-params" class="btn btn-xs  btn-danger btn-delete" ><i class="far fa-trash-alt"></i></button>&nbsp';
                    }
                    return $html;
                })->addColumn('deleted_at', function ($row) {
                    return date('d-M-Y', strtotime($row->deleted_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->deleted_at)->diffForHumans() . '</label>';
                })->addColumn('status', function ($row) {
                    $btn = '<div class="square-switch"><input type="checkbox" id="switch' . $row->id . '" class="subscriber_status" switch="bool" data-id="' . $row->id . '" value="' . ($row->active == 1 ? "1" : "0") . '" ' . ($row->active == 1 ? "checked" : "") . '/><label for="switch' . $row->id . '" data-on-label="Yes" data-off-label="No"></label></div>';

                    return $btn;
                })->addColumn('image', function ($row) {
                    $imageName = Str::of($row->image)->replace(' ', '%10');
                    if ($row->image) {
                        $image = '<img src=' . asset('/' . $imageName) . ' class="avatar-sm" />';
                    } else {
                        $image = '<img src=' . asset('backend/assets/img/users/no-image.jpg') . ' class="avatar-sm" />';
                    }
                    return $image;
                })->rawColumns(['action', 'status', 'deleted_at', 'image'])->make(true);
        }

        return view('admin.subjects.trashed');
    }

    public function subjectApi()
    {
        $subjects = Subjects::all();
        return response()->json($subjects);
    }
}
