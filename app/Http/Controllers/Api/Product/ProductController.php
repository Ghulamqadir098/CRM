<?php
namespace App\Http\Controllers\Api\Product;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::all();
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Products not found',
                'data' => []
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Products fetched successfully',
            'data' => $products
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $product= new Product();
        $product->name=$request->name;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->category=$request->category;
        $product->stock_quantity=$request->stock_quantity;
        // handle image 
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $product->image = '/images/'.$filename;
        }
        $product->save();
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'message' => 'Product fetched successfully',
            'data' => $product
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->name=$request->name;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->category=$request->category;
        $product->stock_quantity=$request->stock_quantity;
        //delete old image
        if ($product->getRawOriginal('image') && $request->hasFile('image') && file_exists(public_path($product->getRawOriginal('image')))) {
           
            unlink(public_path($product->getRawOriginal('image')));
        }
        // handle image 
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $product->image = '/images/'.$filename;
        }
        $product->save();
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // delete old image
        if ($product->getRawOriginal('image') && file_exists(public_path($product->getRawOriginal('image')))) {
            unlink(public_path($product->getRawOriginal('image')));
        }
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ],200);
    }
}
