<?php
namespace App\Http\Controllers\Api\Customer;

use App\Models\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function fetchCart(Request $request){
      $request->validate([
        'user_id' => 'required|integer|exists:users,id',
      ]);
    try{
        $carts=Cart::where('user_id','=',$request->user_id)->with('cartItems.itemable')->get();
        return response()->json([
          'success' => true,
          'message' => 'Cart fetched successfully',
          'data' => $carts,
        ], 200);
    }
    catch(\Exception $e){
        return response()->json([
          'success' => false,
          'message' => "there was an error while fetching cart for this user",
          'data' => $e->getMessage(),
        ], 500);
    }
}
}
