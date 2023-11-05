<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Image;

class CategoryController extends Controller
{
    public function index(Request $request) {

       $categories = Category::latest();
       if(!empty($request->get('keyword'))){
        $categories = $categories->where("name","like",'%'.$request->get('keyword').'%');
       }
       $categories = $categories->paginate(10);
       return view("admin.category.list", compact("categories"));
    }

    public function create() {
      return view('admin.category.create');
    }

    public function store(Request $request) {
        
       $validator = Validator::make($request->all(), [
           'name' => 'required',
           'slug' => 'required|unique:categories',
       ]);
       if ($validator->passes()){
           
            $category = new Category(); 
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->staus;
            $category->save();
            
            if(!empty($request->image_id)){
              $tempImage = TempImage::find($request->image_id);
              $extArry = explode('.',$tempImage->name );
              $ext = last($extArry);

              $newName = $category->id. '.' .$ext;

              $srctp = public_path(). '/temp/'. $tempImage->name;
              $dstpath = public_path(). '/uploads/categories/'. $newName;

              File::copy($srctp,$dstpath );
             
              $dstpath =  public_path(). '/uploads/categories/thumb/'. $newName;
              File::copy($srctp,$dstpath );
              // $img = Image::make($srctp);
              // $img->fit(450, 600, function ($constraint) {
              //     $constraint->upsize();
              //   });
              // $img->save($dstpath);
             
              $category->image = $newName;
              $category->save();
            }

            $request->session()->flash('success', 'Category add sucessfully');
            return response()->json([
                'status' => true,
                'message' => 'Category add sucessfully'
            ]);

       }else{
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
       }
    }
    public function edit(Request $request, $categoryID) {
      if($categoryID){
        $category = Category::find($categoryID);
        dd( $category );
      }
    }

    public function update() {

    }

    public function distroy() {

    }
}
