<?php

namespace App\Http\Concerns;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests as ValidatesRequestsBase;

trait ValidatesRequests
{
    use ValidatesRequestsBase {
        validate as protected validateBase;
    }

    /**
     * @var Array
     */
    protected $validatedInput;

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $this->validatedInput = $this->validateBase($request, $rules, $messages, $customAttributes);

        return $this->validatedInput;
    }

    /**
     * Get the validated input
     *
     * @return array
     */
    protected function validated(): array
    {
        abort_unless($this->validatedInput, 422);

        return $this->validatedInput;
    }

    /**
     * Get a key from the validatedInput array
     *
     * @param Mixed $key
     * @return Mixed
     */
    protected function validatedKey($key)
    {
        return $this->validated()[$key];
    }

    /**
     * Return the validatedInput except $key
     *
     * @param Mixed $key
     * @return array
     */
    protected function validatedExcept($key): array
    {
        return array_except($this->validated(), $key);
    }

    /**
     * Return only '$key' from the validatedInput
     *
     * @param Mixed $key
     * @return array
     */
    protected function validatedOnly($key): array
    {
        return array_only($this->validated(), $key);
    }

    /**
     * Return the validated input merged with the passed array
     *
     * @param array $passed
     * @return array
     */
    protected function validatedWith(array $passed): array
    {
        return array_merge($this->validated(), $passed);
    }

    /**
     * Return the validated input merged with the code string
     *
     * @param array $passed
     * @return array
     */
    protected function validatedWithCode(array $passed = []): array
    {
        return $this->validatedWith(
            array_merge($passed, [
                'code' => optional(request())->code
            ])
        );
    }
}