<?php
namespace App\Http\Controllers\Api\Order;


use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function index(){
      Gate::authorize('view-all-orders');
        Order::all();
        return response()->json([
          'success' => true,
          'message' => "Orders fetched successfully",
          'data' => Order::all(),
        ], 200);
    }
    public function checkout(Request $request,Cart $cart){
       // check cart authorization for authenticated user
       if($cart->user_id !== $request->user()->id){
        return response()->json([
          'success' => false,
          'message' => "unauthorized",
          'data' => null,
        ], 401);
       }
  
       DB::beginTransaction();
    try{
         // check if the is active or not
        if($cart->status !== 'active'){
            return response()->json([
              'success' => false,
              'message' => "cart is either empty or inactive",
              'data' => null,
            ], 401);
        }
         
        $order = Order::create([
        'user_id' => $cart->user_id,
        'cart_id' => $cart->id, // track original cart
        ]);
        foreach ($cart->cartItems as $item) {
        $order->orderItems()->create([
        'itemable_id' => $item->itemable_id,
        'itemable_type' => $item->itemable_type,
        'quantity' => $item->quantity,
        'price' => $item->price,
        ]);
        }
    
        // Instead of deleting:
        $cart->update(['status' => 'inactive']);
       
        Gate::authorize('place-order',$order); //placed befor Commmit just in case if the order gets created for unauthorized user the order gets rolled back
        DB::commit();

        return redirect()->route('stripe.post',$order->id);

    }
    catch(\Exception $e){
        DB::rollBack();
        return response()->json([
          'success' => false,
          'message' => "there was an error while creating order",
          'data' => $e->getMessage(),
        ], 500);
    }
}
}