<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class IssueTokenAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $email = $request->input('email');

        /** @var User $user */
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            throw new AuthException('invalid_grant');
        }

        $token = $user->createToken($request->userAgent());

        return response()->json([
            'access_token' => $token->plainTextToken,
            'device' => $token->accessToken->name,
            'expires_at' => $token->accessToken->expires_at->toDateTimeString(),
            'user' => $user,
        ]);
    }
}
