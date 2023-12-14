<?php

namespace App\GraphQL\Mutations;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    /**
     * @throws ValidationException
     */
    public function __invoke($rootValue, array $args): array
    {
        // Validate input data
        $validatedData = Validator::make($args, [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        // Attempt to authenticate the user
        if (!Auth::attempt($validatedData)) {
            throw ValidationException::withMessages([
                'authentication' => 'Invalid credentials.',
            ]);
        }

        // Generate and return a token along with the authenticated user
        $token = auth()->user()->createToken('auth-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => auth()->user(),
        ];
    }
}
