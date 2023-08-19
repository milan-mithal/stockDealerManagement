<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Stock;
use File;
use App\Enums\CommonStatusEnums;
use App\Enums\DeleteStatusEnums;
use Illuminate\Validation\Rules\Enum;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productList = Product::where('status', '!=', DeleteStatusEnums::Deleted)->get();
        return view('product.view',  ['allProductList' => $productList]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_category' => 'required',
            'product_code' => 'required|unique:products,product_code',
            'product_name' => 'required',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_price' => 'required|min:1|numeric',
            'product_size' => 'required',
            'status' => ['required', new Enum(CommonStatusEnums::class)]
        ], [
            'product_category.required' => 'Please choose product category.',
            'product_code.required' => 'Please enter product code.',
            'product_code.unique' => 'Please enter unique product code.',
            'product_name.required' => 'Please enter product name.',
            'product_image.required' => 'Please select an image to upload.',
            'product_image.image' => 'The uploaded file must be an image.',
            'product_image.mimes' => 'Only jpeg, png, jpg, and gif files are allowed.',
            'product_image.max' => 'The uploaded image must not exceed 2MB.',
            'product_price.required' => 'Please enter product price.',
            'product_price.min' => 'Product price cannot be less than 1.',
            'product_price.numeric' => 'Product price should be numeric.',
            'product_size.required' => 'Please enter product size.',
            'status.required' => 'Please choose product status.'
        ]);
        $imageNamePath = '';
        if ($request->hasFile('product_image')) {
            $path = '/images/product_images/';
            $imageName = time().'.'.$request->product_image->extension();
            $request->product_image->move(public_path($path), $imageName);
            $imageNamePath = $path.$imageName;
        }

        // Insert data into the database
        $insertData = new Product();
        $insertData->product_category = $request->product_category;
        $insertData->product_code = $request->product_code;
        $insertData->product_name = $request->product_name;
        $insertData->product_image = $imageNamePath;
        $insertData->product_price = $request->product_price;
        $insertData->product_size = $request->product_size;
        $insertData->status = $request->status;
        $insertData->save();
    
        return redirect()->route('product.create')->with('success', 'Product created successfully.');
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
        $productDetail = Product::findOrFail($id);
        return view('product.edit', compact('productDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_category' => 'required',
            'product_code' => 'required|unique:products,product_code,'. $id,
            'product_name' => 'required',
            'product_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_price' => 'required|min:1|numeric',
            'product_size' => 'required',
            'status' => ['required', new Enum(CommonStatusEnums::class)]
        ], [
            'product_category.required' => 'Please choose product category.',
            'product_code.required' => 'Please enter product code.',
            'product_code.unique' => 'Please enter unique product code.',
            'product_name.required' => 'Please enter product name.',
            'product_image.image' => 'The uploaded file must be an image.',
            'product_image.mimes' => 'Only jpeg, png, jpg, and gif files are allowed.',
            'product_image.max' => 'The uploaded image must not exceed 2MB.',
            'product_price.required' => 'Please enter product price.',
            'product_price.min' => 'Product price cannot be less than 1.',
            'product_price.numeric' => 'Product price should be numeric.',
            'product_size.required' => 'Please enter product size.',
            'status.required' => 'Please choose product status.'
        ]);
        $imageNamePath = $request->old_product_image; 
        if ($request->hasFile('product_image')) {
            $path = '/images/product_images/';
            $imageName = time().'.'.$request->product_image->extension();
            $request->product_image->move(public_path($path), $imageName);
            $imageNamePath = $path.$imageName;
            $file_path = public_path($request->old_product_image);
            if(File::exists($file_path)) {
                unlink($file_path);
             }
        }

        $updateData = Product::findOrFail($id);
        $updateData->product_category = $request->product_category;
        $updateData->product_code = $request->product_code;
        $updateData->product_name = $request->product_name;
        $updateData->product_image = $imageNamePath;
        $updateData->product_price = $request->product_price;
        $updateData->product_size = $request->product_size;
        $updateData->status = $request->status;
        $updateData->save();
    
        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteData = Product::findOrFail($id);
        $deleteData->status = DeleteStatusEnums::Deleted;
        $deleteData->save();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}
