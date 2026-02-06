<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\Controller;
use App\Jobs\AuditLogJob;
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

        AuditLogJob::dispatch("SEGURIDAD: Login exitoso vía API del usuario '{$user->email}'");


        return response()->json([
            'message' => 'Login exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $email = $request->user()->email;
        $request->user()->currentAccessToken()->delete();

        AuditLogJob::dispatch("SEGURIDAD: Logout API del usuario '$email'");
        return response()->json(['message' => 'Token eliminado']);
    }
}
