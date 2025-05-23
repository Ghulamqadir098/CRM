<?php
namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       Gate::authorize('read-product');
        $products=Product::all();
      return view('pages.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-product');
        return view('pages.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-product');
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'stock_quantity' => 'required|numeric',

        ],[
            'name.required' => 'This field is required',
            'image.required' => 'This field is required',
            'description.required' => 'This field is required',
            'price.required' => 'This field is required',
            'category.required' => 'This field is required',
            'stock_quantity.required' => 'This field is required',
        ]);
        $product= new Product();

        // handel image
        if( $request->hasFile('image') ){
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $product->image = '/images/'.$filename;

        } 

        $product->name=$request->name;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->category=$request->category;
        $product->stock_quantity=$request->stock_quantity;
        // $product->image=$request->image;
        $product->save();
        return redirect()->route('productweb.index')->with('success','Product created successfully');
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
    public function edit(Product $productweb)
    {
        Gate::authorize('update-product');
        return view('pages.product.edit',compact('productweb'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $productweb)
    {
        Gate::authorize('update-product');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'stock_quantity' => 'required|numeric',
        ],[
            'name.required' => 'This field is required',
            'description.required' => 'This field is required',
            'image.required' => 'This field is required',
            'price.required' => 'This field is required',
            'category.required' => 'This field is required',
            'stock_quantity.required' => 'This field is required',
        ]);
        // handel image 
        if( $request->hasFile('image') ){

        //   remove old image 
            if ($productweb->getRawOriginal('image') && $request->hasFile('image') && file_exists(public_path($productweb->getRawOriginal('image')))) {
                unlink(public_path($productweb->getRawOriginal('image')));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $productweb->image = '/images/'.$filename;
        }
        $productweb->name=$request->name;
        $productweb->description=$request->description;
        $productweb->price=$request->price;
        $productweb->category=$request->category;
        $productweb->stock_quantity=$request->stock_quantity;
        $productweb->save();
        return redirect()->route('productweb.index')->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $productweb)
    {
        Gate::authorize('delete-product');
        $productweb->delete();
        return redirect()->route('productweb.index')->with('error','Product Deleted');
    }
}
