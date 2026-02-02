<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Events\UserCreated;
use App\Jobs\SendLoginAlertJob;
use App\Mail\VerifyAccountMail;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('api_token')->plainTextToken;

        //Evento
        UserCreated::dispatch($user);
        //Job
        SendLoginAlertJob::dispatch($user->email);
        //Email
        Mail::to($user->email)->send(new VerifyAccountMail($user));

        return response()->json([
            'message' => 'Login exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Token eliminado']);
    }
}
