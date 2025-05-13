<?php
namespace App\Http\Controllers\Api\Auth;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AgentRegisterRequest;
use App\Http\Requests\CustomerRegisterRequest;
// use Illuminate\Container\Attributes\Log;

class AuthController extends Controller
{
    public function agentRegister(AgentRegisterRequest $request) {
         $user= new User();
         $user->name = $request->name;
         $user->email = $request->email;
         // save image and save it in public folder
         if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $user->image = '/images/'.$filename;
         }
        
    

         $user->password = bcrypt($request->password);
         $user->save(); 
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
         
         return response()->json([
            'success' => true,
            'message' => 'Agent registered successfully Check your email for OTP',
             'data' => $user,
             'token' => $user->createToken('auth_token')->plainTextToken,
        ], 201);
    }

    public function customerRegister(CustomerRegisterRequest $request) {
        DB::beginTransaction();
        try{
         $user= new User();
         $user->name = $request->name;
         $user->email = $request->email;
         $user->password = bcrypt($request->password);
         $user->role = 'customer';
         if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $user->image = '/images/'.$filename;
         }
         if($request->agent_id){
            $user->agent_id = $request->agent_id;
           }
         $user->phone = $request->phone;
         $user->address = $request->address;
         $user->company = $request->company;
         $user->save();
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
         DB::commit();
         return response()->json([
            'success' => true,
            'message' => 'Customer registered successfully',
             'data' => $user,
             'token' => $user->createToken('auth_token')->plainTextToken,
         ],201);
     }
     catch(\Exception $e){
        DB::rollBack();
        // log the error 
          Log::error($e->getMessage());
         return response()->json([
            'success' => false,
            'message' => 'Customer registeration Failed',
             'data' => $e->getMessage()      
        ], 500);
     }
    }
public function login(Request $request) {
$request->validate([
    'email' => 'required|email|exists:users,email',
    'password' => 'required|min:8',
]);
$user = User::where('email', $request->email)->first();
if (! $user || ! Hash::check($request->password, $user->password)) {
    return response()->json([
        'success' => false,
        'message' => 'Invalid login details',
    ], 401);
}
if($user->email_verified_at == null){
    return response()->json([
        'success' => false,
        'message' => 'Email not verified',
    ], 401);
}
return response()->json([
    'success' => true,
    'message' => 'Login successful',
    'data' => $user,
    'token' => $user->createToken('auth_token')->plainTextToken,
]);
}
public function logout(Request $request) {
    $request->user()->tokens()->delete();
    return response()->json([
        'success' => true,
        'message' => 'Logout successful',
    ]);
}
    public function verifyEmail(Request $request) {
      $request->validate([
          'token' => 'required',
      ]);
     
     try{
      $record = DB::table('email_verify_tokens')
      ->where('email', $request->user()->email)
      ->where('token', $request->token)
      ->where('created_at', '>=', now()->subMinutes(10)) // OTP valid for 10 min
      ->first();
      $user = $request->user();

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
         return response()->json(['error' => 'Invalid or expired OTP , we have resend you a new OTP'], 400);
          }
      $user->email_verified_at = now();
      $user->save();
      DB::table('email_verify_tokens')->where('email', $user->email)->delete();
      return response()->json(['message' => 'Email verified successfully'], 201);
     }
     catch(\Exception $e){
        // log the error 
          Log::error($e->getMessage());
         return response()->json([
            'success' => false,
            'message' => 'Email verification Failed',
             'data' => $e->getMessage()      
        ], 500);
     }
  }
  public function changePassword(Request $request){
     $request->validate([
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required|min:8',
        'old_password' => 'required|min:8',
     ]); 
   try{
      $user= $request->user();
      if (!Hash::check($request->old_password, $user->password)) {
         Log::info('Password does not match');
         return response()->json(['message' => 'Password does not match'], 401);
      }
      $user->password = bcrypt($request->password);
      $user->save();
      // destroy old tokens
      $user->tokens()->delete();
      return response()->json([
         'success' => true,
         'message' => 'Password changed successfully',
          'data' => $user,
          'token' => $user->createToken('auth_token')->plainTextToken,
      ],201);
    }
    catch(\Exception $e){
        // log the error 
          Log::error($e->getMessage());
         return response()->json([
            'success' => false,
            'message' => 'Password change Failed',
             'data' => $e->getMessage()      
        ], 500);
     }
  }
  public function forgotPassword(Request $request)
  {
   try{
      $request->validate([
          'email' => 'required|email|exists:users,email',
      ]);
  
      $otp = rand(100000, 999999); // 6-digit OTP
      $email = $request->email;
  
      // Delete any previous OTPs
      DB::table('password_reset_tokens')->where('email', $email)->delete();
  
      // Store OTP as token
      DB::table('password_reset_tokens')->insert([
          'email' => $email,
          'token' => $otp,
          'created_at' => Carbon::now(),
      ]);
  
      // Send OTP via email
      Mail::raw("Note that this will expire in 10 minutes. OTP Your OTP to reset password is: $otp", function ($message) use ($email) {
          $message->to($email)->subject('Password Reset OTP');
      });
  
      return response()->json(['message' => 'OTP sent to your email']);
   }
   catch(\Exception $e){
      Log::error('Password reset failed: ' . $e->getMessage());
      return response()->json(['message' => 'Password reset failed', 'error' => $e->getMessage()], 500);
   }
  }
  public function resetPassword(Request $request)
  {
     try{
      $request->validate([
          'email' => 'required|email|exists:users,email',
          'otp' => 'required|digits:6',
          'password' => 'required|confirmed|min:6',
      ]);
  
      $record = DB::table('password_reset_tokens')
          ->where('email', $request->email)
          ->where('token', $request->otp)
          ->where('created_at', '>=', now()->subMinutes(10)) // OTP valid for 10 min
          ->first();
  
      if (! $record) {
          return response()->json(['error' => 'Invalid or expired OTP'], 400);
      }
  
      // Update user password
     $user= User::where('email', $request->email)
          ->update(['password' => Hash::make($request->password)]);
  
      // Delete OTP record
      DB::table('password_reset_tokens')->where('email', $request->email)->delete();
       // destroy old tokens
       $user->tokens()->delete();
      return response()->json(['message' => 'Password has been reset successfully']);
     }
       catch(\Exception $e){
        Log::error('Password reset failed: ' . $e->getMessage());
        return response()->json(['message' => 'Password reset failed', 'error' => $e->getMessage()], 500);
       }
  }
}
