<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create($request->validate([
            'first_name' => 'required|string',
            'last_name' => 'string',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]));

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'boolean',
        ]);

        $credentials = [
            'email' => $fields['email'],
            'password' => $fields['password'],
        ];

        if (!Auth::attempt($credentials, $fields['remember'])) {
            throw ValidationException::withMessages([
                'email' => ['The provided cretials are incorrect'],
            ]);

            session()->regenerate();


            return response()->json([
                'message' => 'Succe3ssfully Logned in',
                'user' => Auth::user(),
            ]);
        }
    }

 public function logout(){
                Auth::guard('web')->logout();
                return response()->json([
                    'message' => 'User logged out successfully',
                ]);
            }


    // public function emailVerify($user_id,Request $request)
    // {
    //     if(!$request->hasValidSignature()){
    //         return response()->json([
    //             'message' => 'Invalid/Expired url provided',
    //         ], 400);
    //     }

    //     $user = User::findOrFail($user_id);

    //     if (!$user) {
    //         return response()->json([
    //             'message' => 'User not found.',
    //         ], 400);
    //     }

    //     if ($user->hasVerifiedEmail()) {
    //         $user->markEmailAsVerified();
    //         return response()->json([
    //             'message' => 'Email already verified.',
    //             'user' => $user,
    //         ]);
    //     }

    //     return response()->json([
    //         'message' => 'Email addres already verified.',
    //     ], 400);
    // }

    // public function resendEmailVerification(Request $request)
    // {
    //     $user_id = $request->input('user_id');

    //     $user = User::findOrFail($user_id);

    //     if (!$user) {
    //         return response()->json([
    //             'message' => 'User not found.',
    //         ], 400);
    //     }


    //     if ($user->hasVerifiedEmail()) {
    //         return response()->json([
    //             'message' => 'Email already verified.',
    //         ], 400);
    //     }

    //     $user->sendEmailVerificationNotification();

    //     return response()->json([
    //         'message' => 'Email verification link sent on your email id.',
    //     ]);
    // }

    // public function forgotPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     return $status === Password::RESET_LINK_SENT
    //                 ? response()->json([
    //                     'message' => trans($status)
    //                     ])
    //                 : response()->json([
    //                     'message' => trans($status)
    //                 ], 400);
    // }

    // public function resetPassword(Request $request)
    // {
    //     $request->validate([
    //         'token' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     $status = Password::reset(
    //         $request->only('email', 'password', 'password_confirmation', 'token'),
    //         function (User $user, string $password) {
    //             $user->forceFill([
    //                 'password' => Hash::make($password)
    //             ])->setRememberToken(Str::random(60));

    //             $user->save();

    //             event(new PasswordReset($user));
    //         }
    //     );


    //     return $status === Password::PASSWORD_RESET
    //                 ? response()->json([
    //                 'message' => trans($status),
    //                 ])
    //                 : response()->json([
    //                     'message' =>trans($status),
    //                 ], 400);

    // }

}
