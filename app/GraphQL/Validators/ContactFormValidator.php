<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\ValidationException;

class ContactFormValidator
{
    /**
     * @throws ValidationException
     */
    public function validateCreateContact(array $data): array
    {
        return validator($data, [
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
        ])->validate();
    }
}
