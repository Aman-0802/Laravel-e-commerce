<?php

namespace App\Http\Controllers\products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // ✅ ALL PRODUCTS
    public function index()
    {
        $products = Product::all();
        return view('admin.products.show', compact('products'));
    }

    // ✅ ADD PRODUCT FORM
    public function create()
    {
        $categories = DB::table('categories')->get();
        $subcategories = DB::table('subcategories')->get();

        return view('admin.products.add', compact('categories', 'subcategories'));
    }

    // ✅ STORE PRODUCT
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'mrp' => 'required',
            'buy_rate' => 'required',
            'sell_rate' => 'required',
            'batch_no' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'image' => 'required|image'
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully');
    }

    // ✅ EDIT FORM
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        $subcategories = DB::table('subcategories')->get();

        return view('admin.products.edit', compact('product','categories','subcategories'));
    }

    // ✅ UPDATE PRODUCT
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Image delete (agar hai)
    if ($product->image && file_exists(public_path('uploads/'.$product->image))) {
        unlink(public_path('uploads/'.$product->image));
    }

    $product->delete();

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Product deleted successfully');
}

}
