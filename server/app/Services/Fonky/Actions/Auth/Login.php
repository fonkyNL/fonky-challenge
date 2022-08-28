<?php

namespace App\Services\Fonky\Actions\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Fonky\Models\User;

class Login extends Controller 
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.'
            ]);
        }

        $token = $user->createToken($request->header('user-agent'));

        $data = [
            'access_token' => $token->accessToken,
            'token_type' => 'bearer',
            'expires_in' => $token->token->expires_at->diffInSeconds(Carbon::now())
        ];

        return response()
            ->json($data)
            ->setStatusCode(Response::HTTP_OK);
    }   
}