<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class EmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user= auth('sanctum')->user();
        if($user->email_verified_at == null) {
            return response()->json([
                'success' => false,
                'message' => 'Email not verified, Please verify your email, an OTP has been sent to your email',
                'url' => "example/otp/form/frontend",
            ], 401);
            // send email
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
        }
        return $next($request);
    }
}
