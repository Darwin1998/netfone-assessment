<?php

namespace App\GraphQL\Mutations;

use App\Actions\AuthValidationAction;
use App\GraphQL\Validators\ContactFormValidator;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UpdateContact
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
    public function __invoke($rootValue, array $args): bool|int
    {
        $this->authValidationAction->checkAuthenticatedUser();

        $contact = Contact::query()->find($args['id']);

        if (!$contact) {
            throw ValidationException::withMessages([
                'contact' => 'Contact not found.',
            ]);
        }
        $validated = $this->formValidator->validateCreateContact($args);

        return $contact->update($validated);
    }
}
