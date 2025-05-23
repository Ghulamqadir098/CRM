<?php
namespace App\Http\Controllers\User;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(){

    
    $agents = User::role('agent')->get();
    $customers= User::role('customer')->get();
   
    return view('pages.user.index',compact('agents','customers'));
    }
    public function agentIndex(){
        $agents = User::role('agent')->get();
   return view('pages.agent.index',compact('agents'));
    }
    public function customerIndex(){
        $customers= User::role('customer')->get();
   return view('pages.customer.index',compact('customers'));
    }

    public function agentView(User $agent){
        Gate::authorize('read all users');
        $leads = $agent->leads()->get();
    $roles = $agent->getRoleNames();

        $leadsCount = $leads->count();
        return view('pages.agent.view',compact('agent','leads','leadsCount','roles'));
    }
    public function customerView(User $customer){
        Gate::authorize('read all users');
        // count order items 
        $orders = $customer->orders()->withCount('orderItems')->get();

        // calculate total price of orders
        $totalPrice = $orders->sum(function ($order) {
            return $order->orderItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
        });
  

    
        $roles = $customer->getRoleNames();

        $ordersCount = $orders->count();
        return view('pages.customer.view',compact('customer','orders','ordersCount','roles','totalPrice'));
    }
   
}
