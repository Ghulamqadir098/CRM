<?php
namespace App\Http\Controllers\Api\Agent;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    function index(Request $request) {

     $customers= $request->user()->customers;
   if ($customers->isEmpty()) {
       return response()->json([
           'success' => false,
           'message' => 'Customers not found',
           'data' => []
       ], 404);
   }
   return response()->json([
    'success' => true,
    'message' => 'Customers fetched successfully',
     'data' => $customers
 ]);
    }
}
