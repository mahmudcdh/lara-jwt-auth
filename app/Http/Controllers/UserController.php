<?php

namespace App\Http\Controllers;

use App\Helper\JWToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Mockery\Generator\StringManipulation\Pass\Pass;

class UserController extends Controller
{

    // API Requests
    public function userRegistration(Request $request) {

        try{
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successful..!'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                    'status' => 'error',
                    'message' => 'User Registration failed with error: ' . $e
                ]);
        }
    }

    public function userLogin(Request $request) {
        try{
            // $password = Hash::check($request->input('password'));

            $user = User::where('email', $request->input('email'))
                    // ->where('password', '=', Hash::check($request->input('password')))
                    ->where('status', 'active')->first();

            if($user && Hash::check($request->input('password'), $user->password)) {
                // if($user !== null) {

                $token = JWToken::createToken($user->email, $user->id);

                // Set the token as a cookie in the response
                // $cookie = Cookie::make('token', $token, 60 * 24 * 30);

                return response()->json([
                    'status' => 'success',
                    'message' => 'User Login Successful..!',
                    'token' => $token
                ], 200)->cookie('token', $token, 60*24*30); //->withCookie($cookie);
            }
            else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User Login failed..!'
                ]);
            }
        }
        catch(Exception $e){
            return response()->json([
                    'status' => 'error',
                    'message' => 'User Login failed with error: ' . $e
                ]);
        }

    }

    public function userLogout() {
        return redirect('/login')->cookie('token', '', -1);
    }

    public function sendOTP(Request $request) {
        $email = $request->input('email');
        $otp = rand(100000, 999999);

        $user = User::where('email', $email)->first();

        if($user) {
            if($user->status == 'active'){
                //Send OTP to Email Address
                Mail::to($email)->send(new OTPMail($otp));

                //Update OTP to Table file to respective user
                $user->update(['otp' => $otp]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP Sent Successfully..!'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'User Not Active..!'
                ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'User Not Exist..!'
            ]);
        }
    }

    public function verifyOTP(Request $request) {
        $email = $request->input('email');
        $otp = $request->input('otp');

        $user = User::where('email', $email)->where('otp', $otp)->where('status', 'active')->first();

        if($user){

            $expireOTP = $user->updated_at->addMinutes(5);

            if($expireOTP > now()){
                //Reset OTP in Database as 0
                $user->update(['otp' => '0']);

                //Issue Token for User Reset Password
                $token = JWToken::createTokenForResetPassword($email);
                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP Verified Successfully..!',
                    // 'token' => $token
                ], 200)->cookie('token', $token, 60*24*30);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'OTP Expired..!'
                ], 500);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP..!'
            ], 500);
        }
    }

    public function resetPassword(Request $request) {
        try{
            $email = $request->header('email');
            // $email = $request->cookie('email');
            $password = Hash::make($request->input('password')); // $request->input('password');

            User::where('email', $email)->update(['password' => $password]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password Reset Successfully..!'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                    'status' => 'error',
                    'message' => 'Reset Password failed with error: ' . $e
                ], 500);
        }

    }

    public function userProfile(Request $request) {

        $user = User::where('id', $request->header('id'))->first();

        return response()->json([
            'status' => 'success',
            'message' => 'User Profile Retrieved Successfully..!',
            'data' => $user
        ], 200);

    }

    public function userProfileUpdate(Request $request) {

        $request->validate([
            'firstName' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'mobile' => ['required', 'string', 'max:12'],
        ]);

        try{
            $user = User::where('id', $request->header('id'))->first();

            $user->update([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'mobile' => $request->input('mobile'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Profile Updated Successfully..!'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                    'status' => 'error',
                    'message' => 'User Profile Update failed..!'
                ], 500);
        }


    }

    public function updateUserPassword(Request $request) {

        try{

            $user = User::where('id', $request->header('id'))->first();

            $user->update([
                'password' => Hash::make($request->input('password'))
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password Updated Successfully..!'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                    'status' => 'error',
                    'message' => 'Password Update failed..!'
                ], 500);
        }
    }

    // Pages Function
    public function loginPage(){
        return view('pages.auth.login-page');
    }

    public function registerPage(){
        return view('pages.auth.registration-page');
    }

    public function resetPasswordPage(){
        return view('pages.auth.reset-pass-page');
    }

    public function sendOtpPage(){
        return view('pages.auth.send-otp-page');
    }

    public function verifyOtpPage(){
        return view('pages.auth.verify-otp-page');
    }

    public function profilePage(){
        return view('pages.dashboard.profile-page');
    }

}
