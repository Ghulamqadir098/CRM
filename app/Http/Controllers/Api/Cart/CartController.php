<?php
namespace App\Http\Controllers\Api\Cart;

use App\Models\Cart;


use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
// use Illuminate\Container\Attributes\DB;

class CartController extends Controller
{
   
    public function addToCart(Request $request)
    {
        $request->validate([
            'itemable_id' => 'required|integer',
            'itemable_type' => 'required|string|in:product,service',
            'quantity' => 'required|integer|min:1',
        ]);
    DB::beginTransaction();
       try{
        $user = $request->user();
    
        // Get or create active cart
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'active'], // Search conditions
            ['user_id' => $user->id, 'status' => 'active']  // values to create if not found
        );
    
        // Determine full class name for polymorphic relation
        $type = match ($request->itemable_type) {
            'product' => \App\Models\Product::class,
            'service' => \App\Models\Service::class,
        };
        $total_price=$type::find($request->itemable_id)->price*$request->quantity;
    
        // Optional: check if item already exists in cart and update quantity
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('itemable_id', $request->itemable_id)
            ->where('itemable_type', $type)
            ->first();
    
        if ($existingItem) {
            // check if Stock quantity exist in databse than add quantity
            if ($type::find($request->itemable_id)->stock_quantity > $request->quantity) {
               
                $type::where('id', $request->itemable_id)->decrement('stock_quantity', $request->quantity);
            }
            elseif($type::find($request->itemable_id)->stock_quantity){
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Item not available in stock.',
                ], 400);
            }
            $existingItem->quantity += $request->quantity;                
            $existingItem->price += $total_price;
            $existingItem->save();
            // decrease the quantity from the product or service
        } else {
            $cart->cartItems()->create([
                'itemable_id' => $request->itemable_id,
                'itemable_type' => $type,
                'quantity' => $request->quantity,
                'price' => $total_price
            ]);
            if ($type::find($request->itemable_id)->stock_quantity > $request->quantity) {
            $type::where('id', $request->itemable_id)->decrement('stock_quantity', $request->quantity);    
            }
            elseif($type::find($request->itemable_id)->stock_quantity){
                dd('hello');
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Item not available in stock.',
                ], 400);
            }
        }
     DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully.',
            'cart_id' => $cart->id,
        ], 201);
       }
       catch(\Exception $e){
        DB::rollBack();
        // log the error
        Log::error('Error adding item to cart: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to add item to cart.',
            'error' => $e->getMessage(),
        ], 500);
       }
    }
    
    
}
