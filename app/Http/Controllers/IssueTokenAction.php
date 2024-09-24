<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Requests\IssueTokenRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Group;

#[Group('Auth', 'Autenticação')]
class IssueTokenAction extends Controller
{
    /**
     * Handle the incoming auth request.
     *
     * @unauthenticated
     */
    public function __invoke(IssueTokenRequest $request): JsonResponse
    {
        $email = $request->input('email');

        /** @var User $user */
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            throw new AuthException;
        }

        $token = $user->createToken($request->userAgent());

        return response()->json([
            'access_token' => $token->plainTextToken,
            'device' => $token->accessToken->name,
            'expires_at' => $token->accessToken->expires_at->toDateTimeString(),
            'user' => new UserResource($user),
        ]);
    }
}
