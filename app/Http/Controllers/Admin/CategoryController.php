<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
       $categories = Category::latest()->paginate(10);

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
    public function edit() {

    }

    public function update() {

    }

    public function distroy() {

    }
}