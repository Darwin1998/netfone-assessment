<?php

namespace App\GraphQL\Queries;

use App\Actions\AuthValidationAction;
use App\GraphQL\Validators\ContactFormValidator;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ViewContact
{
    protected AuthValidationAction $authValidationAction;


    public function __construct(AuthValidationAction $authValidationAction)
    {
        $this->authValidationAction = $authValidationAction;
    }
    /**
     * @throws ValidationException
     */
    public function __invoke($rootValue, array $args): Builder|array|Collection|Model
    {
        $this->authValidationAction->checkAuthenticatedUser();

        $contact = Contact::query()->find($args['id']);

        if (!$contact) {
            throw ValidationException::withMessages([
                'contact' => 'Contact not found.',
            ]);
        }


        return $contact;
    }
}
