<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductCategory;
use File;
use App\Enums\CommonStatusEnums;
use App\Enums\DeleteStatusEnums;
use Illuminate\Validation\Rules\Enum;
use App\Helpers\CommonHelper;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checknewuser');
        $this->middleware('checkrole');
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategoryList = ProductCategory::where('status', '!=', DeleteStatusEnums::Deleted)->get();
        return view('productcategory.view',  ['allProductCategoryList' => $productCategoryList]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productcategory.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'main_category_name' => 'required',
            'category_name' => 'required',
            'status' => ['required', new Enum(CommonStatusEnums::class)]
        ], [
            'main_category_name.required' => 'Please choose main product category.',
            'category_name.required' => 'Please enter category name.',
            'status.required' => 'Please choose category status.'
        ]);

        // Insert data into the database
        $insertData = new ProductCategory();
        $insertData->main_category_name = $request->main_category_name;
        $insertData->category_name = $request->category_name;
        $insertData->status = $request->status;
        $insertData->created_by = Auth::user()->id;
        $insertData->modified_by = Auth::user()->id;
        $insertData->save();
    
        return redirect()->route('productcategory.create')->with('success', 'Product Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productCategoryDetail = ProductCategory::findOrFail($id);
        return view('productcategory.edit', compact('productCategoryDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'main_category_name' => 'required',
            'category_name' => 'required',
            'status' => ['required', new Enum(CommonStatusEnums::class)]
        ], [
            'main_category_name.required' => 'Please choose main product category.',
            'category_name.required' => 'Please enter category name.',
            'status.required' => 'Please choose category status.'
        ]);

        // Insert data into the database
        $updateData = ProductCategory::findOrFail($id);
        $updateData->main_category_name = $request->main_category_name;
        $updateData->category_name = $request->category_name;
        $updateData->status = $request->status;
        $updateData->modified_by = Auth::user()->id;
        $updateData->save();
    
        return redirect()->route('productcategory.index')->with('success', 'Product Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        $productCategory->delete();
        return redirect()->route('productcategory.index')->with('success', 'Category deleted successfully');
    }
}