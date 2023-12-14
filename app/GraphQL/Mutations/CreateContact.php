<?php

namespace App\GraphQL\Mutations;

use App\Actions\AuthValidationAction;
use App\GraphQL\Validators\ContactFormValidator;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CreateContact
{
    protected ContactFormValidator $formValidator;
    protected AuthValidationAction $authValidationAction;


    public function __construct(ContactFormValidator $formValidator, AuthValidationAction $authValidationAction)
    {
        $this->formValidator = $formValidator;
        $this->authValidationAction = $authValidationAction;
    }

    /**
     * @throws ValidationException
     */
    public function __invoke($rootValue, array $args): Contact
    {
       $this->authValidationAction->checkAuthenticatedUser();
       $validated = $this->formValidator->validateCreateContact($args);

        return Contact::create($validated);
    }
}
