<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AgentRegisterRequest;

class AuthController extends Controller
{
    public function agentForm()
    {

        return view('pages.agent.register');
    }
    public function customerForm()
    {

        return view('pages.customer.register');
    }
    public function agentRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ],[
            'image.required' => 'This field is required',
            'email.required' => 'This field is required',
            'name.required' => 'This field is required',
            'password.required' => 'This field is required',
            'password_confirmation.required' => 'This field is required',
        ]);

        //   check if email already exists
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $otp = rand(100000, 999999); // 6-digit OTP
            $email = $user->email;

            // Delete any previous OTPs
            DB::table('email_verify_tokens')->where('email', $email)->delete();
            // dd($user);
            // Insert the new OTP
            DB::table('email_verify_tokens')->insert([
                'email' => $email,
                'token' => $otp,
                'created_at' => now(),
            ]);


            // Send OTP via email
            Mail::raw("Note that this will expire in 10 minutes. OTP Your OTP to reset password is: $otp", function ($message) use ($email) {
                $message->to($email)->subject('Email Verification OTP');
            });


            return view('pages.agent.verify-email', compact('user'))->with('success', 'this email already exists, we have sent you an email for verification');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        // save image and save it in public folder

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $user->image = '/images/' . $filename;
        }

        $user->assignRole('agent');

        $user->password = bcrypt($request->password);
        $user->save();
        $otp = rand(100000, 999999); // 6-digit OTP
        $email = $user->email;

        // Delete any previous OTPs
        DB::table('email_verify_tokens')->where('email', $email)->delete();
        // dd($user);
        // Insert the new OTP
        DB::table('email_verify_tokens')->insert([
            'email' => $email,
            'token' => $otp,
            'created_at' => now(),
        ]);


        // Send OTP via email
        Mail::raw("Note that this will expire in 10 minutes. OTP Your OTP to reset password is: $otp", function ($message) use ($email) {
            $message->to($email)->subject('Email Verification OTP');
        });


        return view('pages.agent.verify-email', compact('user'));
    }
    public function customerRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'company' => 'required|string|max:255',
        ],[
            'image.required' => 'This field is required',
            'email.required' => 'This field is required',
            'name.required' => 'This field is required',
            'password.required' => 'This field is required',
            'password_confirmation.required' => 'This field is required',
            'phone.required' => 'This field is required',
            'address.required' => 'This field is required',
            'company.required' => 'This field is required',
        ]);
        //   check if email already exists
        $user = User::where('email', $request->email)->first();
        if ($user) {

            if ($user->hasRole('agent')) {
                abort(403);
            }
            $otp = rand(100000, 999999); // 6-digit OTP
            $email = $user->email;

            // Delete any previous OTPs
            DB::table('email_verify_tokens')->where('email', $email)->delete();
            // dd($user);
            // Insert the new OTP
            DB::table('email_verify_tokens')->insert([
                'email' => $email,
                'token' => $otp,
                'created_at' => now(),
            ]);


            // Send OTP via email
            Mail::raw("Note that this will expire in 10 minutes. OTP Your OTP to reset password is: $otp", function ($message) use ($email) {
                $message->to($email)->subject('Email Verification OTP');
            });


            return view('pages.agent.verify-email', compact('user'));
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        // save image and save it in public folder

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $user->image = '/images/' . $filename;
        }

        $user->assignRole('customer');

        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->company = $request->company;
        $user->save();
        $otp = rand(100000, 999999); // 6-digit OTP
        $email = $user->email;

        // Delete any previous OTPs
        DB::table('email_verify_tokens')->where('email', $email)->delete();
        // dd($user);
        // Insert the new OTP
        DB::table('email_verify_tokens')->insert([
            'email' => $email,
            'token' => $otp,
            'created_at' => now(),
        ]);
        // Send OTP via email
        Mail::raw("Note that this will expire in 10 minutes. OTP Your OTP to reset password is: $otp", function ($message) use ($email) {
            $message->to($email)->subject('Email Verification OTP');
        });
        return view('pages.agent.verify-email', compact('user'));
    }
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'OTP' => 'required|integer',
        ]);
        try {
            $record = DB::table('email_verify_tokens')
                ->where('email', $request->email)
                ->where('token', $request->OTP)
                ->where('created_at', '>=', now()->subMinutes(10)) // OTP valid for 10 min
                ->first();
            $user = User::where('email', $request->email)->first();

            if (! $record) {
                $otp = rand(100000, 999999); // 6-digit OTP
                $email = $user->email;
                // Delete any previous OTPs
                DB::table('email_verify_tokens')->where('email', $email)->delete();

                // Insert the new OTP
                DB::table('email_verify_tokens')->insert([
                    'email' => $email,
                    'token' => $otp,
                    'created_at' => now(),
                ]);
                // Send OTP via email
                Mail::raw("Note that this will expire in 10 minutes. OTP Your OTP to reset password is: $otp", function ($message) use ($email) {
                    $message->to($email)->subject('Email Verification OTP');
                });
                return view('pages.agent.verify-email', compact('user'));
            }
            $user->email_verified_at = now();
            $user->save();
            // make user session by log in
            auth()->login($user);
            DB::table('email_verify_tokens')->where('email', $user->email)->delete();
            return redirect('/');
        } catch (\Exception $e) {
            // log the error 
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Email verification Failed',
                'data' => $e->getMessage()
            ], 500);
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/');
        } else {
            return redirect()->back()->with('error', 'Invalid login details');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('dashboardweb')->with('error', 'User Deleted');
    }


    public function adminAgentForm()
    {
        return view('pages.agent.admin_create');
    }
    public function adminCustomerForm()
    {
        return view('pages.customer.admin_create');
    }
    public function adminAgentEdit(User $agent)
    {
        Gate::authorize('create-agent');
    // check if user has role agent
    if (!$agent->hasRole('agent')) {
        abort(403);
    }
        return view('pages.agent.edit_agent', compact('agent'));
    }
    public function adminAgentUpdate(Request $request, User $agent)
    {
    Gate::authorize('create-agent');
        // check if user has role agent
        if (!$agent->hasRole('agent')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ],[
            'image.required' => 'This field is required',
            'email.required' => 'This field is required',
            'name.required' => 'This field is required',
            'password.required' => 'This field is required',
            'password_confirmation.required' => 'This field is required',
        ]);

        $agent->name = $request->name;
        $agent->email = $request->email;
        if ($request->hasFile('image')) {
            // remove old image 
            if ($agent->getRawOriginal('image') && $request->hasFile('image') && file_exists(public_path($agent->getRawOriginal('image')))) {
                unlink(public_path($agent->getRawOriginal('image')));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $agent->image = '/images/' . $filename;
        }
        $agent->password = bcrypt($request->password);
        $agent->save();
        return redirect()->route('agent.index')->with('success', 'Agent updated successfully');
    }
    public function adminCustomerEdit(User $customer)
    { Gate::authorize('create-customer');
        if (!$customer->hasRole('customer')) {
            abort(403);
        }
        return view('pages.customer.edit_customer', compact('customer'));
    }
    public function adminCustomerUpdate(Request $request, User $customer)
    {

        Gate::authorize('create-customer');
        // check if user has role customer
        if (!$customer->hasRole('customer')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'company' => 'required|string|max:255',
        ],[
            'image.required' => 'This field is required',
            'email.required' => 'This field is required',
            'name.required' => 'This field is required',
            'password.required' => 'This field is required',
            'password_confirmation.required' => 'This field is required',
            'phone.required' => 'This field is required',
            'address.required' => 'This field is required',
            'company.required' => 'This field is required',
        ]);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->company = $request->company;
        if ($request->hasFile('image')) {
            // remove old image 
            if ($customer->getRawOriginal('image') && $request->hasFile('image') && file_exists(public_path($customer->getRawOriginal('image')))) {
                unlink(public_path($customer->getRawOriginal('image')));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $customer->image = '/images/' . $filename;
        }
        $customer->password = bcrypt($request->password);
        $customer->save();
        return redirect()->route('customer.index')->with('success', 'Customer updated successfully');
    }
    public function editProfile()
    {
        $user = auth()->user();
        return view('pages.user.edit', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->company = $request->company;

        // check if request contains field password and not empty 
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        // check if request contains field image and not empty 
        if ($request->hasFile('image')) {
            // remove old image 
            if ($user->getRawOriginal('image') && $request->hasFile('image') && file_exists(public_path($user->getRawOriginal('image')))) {
                unlink(public_path($user->getRawOriginal('image')));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $user->image = '/images/' . $filename;
        }
        $user->save();
        return redirect()->route('dashboardweb')->with('success', 'Profile updated successfully');
    }
    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required|string|min:8',
                'new_password' => 'required|string|min:8',
                'agent_id' => 'required|exists:users,id',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Validation failed error:( ' . $e->getMessage().')');
        }
        
     try{
        if(Gate::allows('create-agent')|| Gate::allows('create-customer')){
            $user = User::find($request->agent_id);
            // if (Hash::check($request->current_password, $user->password)) {
            //     $user->password = bcrypt($request->new_password);
            //     $user->save();
               
            //     return redirect()->back()->with('success', 'Password updated successfully');
            // } else {
            //     return redirect()->back()->with('error', 'Current password is incorrect');
            // }
            $user->password = bcrypt($request->new_password);
                $user->save();
                return redirect()->back()->with('success', 'Password updated successfully');
          }
          else{
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->new_password);
                $user->save();
                return redirect()->back()->with('success', 'Password updated successfully');
            } else {
                return redirect()->back()->with('error', 'Current password is incorrect');
            }
          }
     }
        catch(\Exception $e){
            //log the errors 
            Log::error($e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
      
    }
}
