<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthValidationAction
{
    /**
     * Check if the user is authenticated.
     *
     * @return Authenticatable
     * @throws ValidationException
     */
    public function checkAuthenticatedUser(): Authenticatable
    {
        $user = Auth::user();

        if (!$user) {
            throw ValidationException::withMessages([
                'authentication' => 'Unauthenticated. You must be logged in to perform this action.',
            ]);
        }

        return $user;
    }
}
