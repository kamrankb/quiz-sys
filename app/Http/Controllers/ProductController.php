<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategories;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\QuickNotify;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    function __construct()
    {
        $this->productimagepath= 'img/product/';
        $this->middleware('permission:Product-Create|Product-Edit|Product-View|Product-Delete', ['only' => ['index','store']]);
        $this->middleware('permission:Product-Create', ['only' => ['form','store']]);
        $this->middleware('permission:Product-Edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Product-Delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $product = Product::all();
            return DataTables::of($product)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = '<a href="#"  class="btn btn-primary btn-view" data-bs-toggle="modal" data-bs-target=".orderdetailsModal" data-id="'.$row->id.'"><i class="far fa-eye"></i></a>&nbsp' ;
                    if (Auth::user()->can('Product-Edit')) {
                        $html .= '<a href="'.route('product.edit',$row->id).'"  class="btn btn-success btn-edit" ><i class="fas fa-edit"></i></a>&nbsp' ;
                    }
                    if (Auth::user()->can('Product-Delete')) {
                        $html .= '<button data-id="' . $row->id . '" id="sa-params" class="btn btn-xs  btn-danger btn-delete" ><i class="far fa-trash-alt"></i></button>&nbsp';
                    }
                    return $html;
                })->addColumn('created_at', function ($row) {
                    return date('d-M-Y', strtotime($row->created_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->created_at)->diffForHumans() . '</label>';
                })->addColumn('status', function ($row) {
                    $btn = '<div class="square-switch"><input type="checkbox" id="switch' . $row->id . '" class="product_status" switch="bool" data-id="' . $row->id . '" value="'.($row->active==1 ? "1" : "0").'" '.($row->active==1 ? "checked" : "").'/><label for="switch' . $row->id . '" data-on-label="Yes" data-off-label="No"></label></div>';

                    return $btn;
                })->addColumn('image', function ($row) {
                    $imageName = Str::of($row->image)->replace(' ', '%10');
                    if ($row->image) {
                        $image = '<img src=' . asset('/' . $imageName) . ' class="avatar-sm" />';
                    } else {
                        $image = '<img src=' . asset('backend/assets/img/users/no-image.jpg') . ' class="avatar-sm" />';
                    }
                    return $image;
                })->rawColumns(['action', 'status','image','created_at'])->make(true);
        }

        return view('admin.product.list');
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $product = Product::onlyTrashed();
            return DataTables::of($product)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = '<a href="#"  class="btn btn-primary btn-view" data-bs-toggle="modal" data-bs-target=".orderdetailsModal" data-id="'.$row->id.'"><i class="far fa-eye"></i></a>&nbsp' ;
                    if (Auth::user()->can('Product-Edit')) {
                        $html .= '<a href="'.route('product.restore',$row->id).'"  class="btn btn-xs btn-success btn-restore" ><i class="mdi mdi-delete-restore"></i></a>&nbsp' ;
                    }
                    if (Auth::user()->can('Product-Delete')) {
                        $html .= '<button data-id="' . $row->id . '" id="sa-params" class="btn btn-xs  btn-danger btn-delete" ><i class="far fa-trash-alt"></i></button>&nbsp';
                    }
                    return $html;
                })->addColumn('deleted_at', function ($row) {
                    return date('d-M-Y', strtotime($row->deleted_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->deleted_at)->diffForHumans() . '</label>';
                })->addColumn('status', function ($row) {
                    $btn = '<div class="square-switch"><input type="checkbox" id="switch' . $row->id . '" class="product_status" switch="bool" data-id="' . $row->id . '" value="'.($row->active==1 ? "1" : "0").'" '.($row->active==1 ? "checked" : "").'/><label for="switch' . $row->id . '" data-on-label="Yes" data-off-label="No"></label></div>';

                    return $btn;
                })->addColumn('image', function ($row) {
                    $imageName = Str::of($row->image)->replace(' ', '%10');
                    if ($row->image) {
                        $image = '<img src=' . asset('/' . $imageName) . ' class="avatar-sm" />';
                    } else {
                        $image = '<img src=' . asset('backend/assets/img/users/no-image.jpg') . ' class="avatar-sm" />';
                    }
                    return $image;
                })->rawColumns(['action', 'status','image','deleted_at'])->make(true);
        }

        return view('admin.product.trashed');
    }

    public function form($id = 0)
    {
        $categories = Categories::all();
        $subcategories = SubCategories::all();
        return view('admin.product.add', ['categories' => $categories, 'subcategories' => $subcategories]);
    }

    function status(Request $request, $id,$isType=null) {

        $partners = Product::find($id);
        $partners->active = (($request->status == "true") ? 1 : 0);

        $response = array();

        if($partners->save()) {
            $response["success"] = true;
            $response["message"] = "Product Status Updated Successfully!";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to Update Product Status!";
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $valid =  $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'sales_price' => 'required',
            'regular_price' => 'required',

        ]);
        if($valid)
        {
          $product = new Product();
          $product->categories_id = $request->categories_id;
          $product->sub_categories_id  = $request->sub_categories_id;
          $product->name = $request->name;
          $product->title = $request->title;
          $product->description = strip_tags($request->description);
          $product->price = $request->price;
          $product->categories_id = $request->categories_id;
          $product->sales_price = $request->sales_price;
          $product->regular_price = $request->regular_price;
          if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image_destinationPath = public_path($this->productimagepath);
            $image->move($image_destinationPath, $imagename);
            $imagename = $this->productimagepath . $imagename;
            $product->image = $imagename;
           }

         $product->metatitle = $request->metatitle;
         $product->desc  = $request->desc;
         $product->metakeyword = $request->metakeyword;
         $management = User::role(['Admin', 'Brand Manager'])->get();
         $management->pluck('id');
         $data = array(
            "success"=> true,
            "message" => "Product Added Successfully."
        );

        if($product->save()) {

            $notify = array(
                "performed_by" => Auth::user()->id,
                "title" => "Added New Product",
                "desc" => array(
                   "added_title" => $request->input('name'),
                   "added_description" => strip_tags($request->description),
                )
            );
            Notification::send($management, new QuickNotify($notify));
            Session::flash('success', $data["message"]);

        }else {
            $data["success"] = false;
            $data["message"] = "Product Not Added Successfully.";

            Session::flash('error', $data["message"]);
        }
        return redirect()->route('product.list')->with($data);

        } else {
            return redirect()->back();
        }
    }

    public function restore(Request $request ,$id)
    {
        $product = Product::withTrashed()->find($id);
        $response = array(
            "success" => true,
            "message" => "Product Restored Successfully!"
        );

        if(!$product->restore()) {
            $response["success"] = false;
            $response["message"] = "Failed to Restore Product!";
        }

        return redirect()->route('product.list')->with($response);
    }

    public function edit(Request $request , $id)
    {
        $categories = Categories::all();
        $subcategories = SubCategories::all();
        $where = array('id' => $id);
        $product  = Product::where($where)->first();
        return view('admin.product.edit',compact('categories','subcategories','product'));
    }

    public function view(Request $request, $isTrashed=null)
    {
        $where = array('id' => $request->id);
        if($isTrashed != null && $isTrashed == 1 ) {
            $product = Product::onlyTrashed()->where($where)->with('category','Subcategory')->first();
        } else {
            $product = Product::where($where)->with('category','Subcategory')->first();
        }
        return Response::json(["status"=>true,"product"=>$product]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'sales_price' => 'required',
            'regular_price' => 'required',
        ]);

          $product = Product::find($request->id);
          $product->categories_id = $request->categories_id;
          $product->sub_categories_id  = $request->sub_categories_id;
          $product->name = $request->name;
          $product->title = $request->title;
          $product->description = strip_tags($request->description);
          $product->price = $request->price;
          $product->categories_id = $request->categories_id;
          $product->sales_price = $request->sales_price;
          $product->regular_price = $request->regular_price;
          if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image_destinationPath = public_path($this->productimagepath);
            $image->move($image_destinationPath, $imagename);
            $imagename = $this->productimagepath . $imagename;
            $product->image = $imagename;
           }

         $product->metatitle = $request->metatitle;
         $product->desc  = $request->desc;
         $product->metakeyword = $request->metakeyword;
         $management = User::role(['Admin', 'Brand Manager'])->get();
         $management->pluck('id');
         $data = array(
            "success"=> true,
            "message" => "Product Updated Successfully"
         );

         if($product->save()) {

             $notify = array(
                "performed_by" => Auth::user()->id,
                "title" => "Updated Product",
                "desc" => array(
                    "added_title" => $request->input('name'),
                    "added_description" => strip_tags($request->description),
                    )
                );
               Notification::send($management, new QuickNotify($notify));
               Session::flash('success', $data["message"]);
         } else {
            $data["success"] = false;
            $data["message"] = "Product Not Added Successfully.";

            Session::flash('error', $data["message"]);
         }
         return redirect()->route('product.list')->with($data);


    }


    public function ProductApi($id=null, $categories_id=null)
    {
        $categories_id = Product::where('id', $id)->with('category')->first();
        if ($categories_id) {
            $products = Product::where('id', $id)->with('category','Subcategory')->get();
            return response()->json([
                "status" => true,
                "data" => $products
            ]);

        }else{

            return response()->json(array(
                "status" => false,
                "message" => 'Product Id Does Not Exit',
            ), 400);
        }

    }

    public function ProductCategoryApi($id)
    {
        $products = Product::where('categories_id', $id)->with('category')->get();
        return response()->json([
            "status" => true,
            "data" => $products
        ]);
    }
    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        $response = array(
            "success" => true,
            "message" => "Product Destroy Successfully!"
        );

        if(!$product->delete()) {
            $response["success"] = false;
            $response["message"] = "Failed to Destroy Product!";
        }

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $product = Product::onlyTrashed()->find($request->id);

        $response = array(
            "success" => true,
            "message" => "Product Destroy Successfully!"
        );

        if(!$product->forceDelete()) {
            $response["success"] = false;
            $response["message"] = "Failed to Destroy Product!";
        }

        return response()->json($response);

    }
}
