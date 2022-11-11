<?php

namespace App\Services;

use App\Classes\Body;
use App\Classes\Response;
use App\Rules\ExistsRule;
use Rakit\Validation\RuleQuashException;
use Rakit\Validation\Validator;

class RequestValidationService
{
    private array $rules;
    private array $errors;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public static function create(array $rules): static
    {
        return new self($rules);
    }

    public function validate(): bool
    {
        $validator = new Validator();

        try {
            $validator->addValidator('exists', new ExistsRule());
        } catch (RuleQuashException) {
            // ignore
        }

        $validation = $validator->make($this->getBody(), $this->rules);
        $validation->validate();

        $this->errors = $validation->errors()->all();

        return $validation->passes();
    }

    public function getBody(): array
    {
        return Body::get();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getResponse(): Response
    {
        return Response::create([
            'errors' => $this->getErrors()
        ], 422);
    }
}