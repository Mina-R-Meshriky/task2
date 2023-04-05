<?php

namespace App\Core\Validator;


use App\Core\Exceptions\ValidationException;

class Validator
{

    private array $errors = [];
    private array $data;
    private array $rules;

    public static function make(array $data, array $rules): self
    {
        return new self($data, $rules);
    }

    /**
     * @param  array<string,mixed>  $data
     * @param  array<string,array>  $rules
     */
    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }


    /**
     * @throws ValidationException
     */
    public function validate(): array
    {
        $this->addKeysFromRuleset();

        $this->removeUnwantedKeysFromDataset();

        foreach ($this->data as $key => $value) {
            $this->validateOne($key, trim($value), $this->rules[$key]);
        }

        if (!$this->isValid()) {
            throw new ValidationException($this->errors);
        }

        return $this->data;
    }

    /** validates a rule set against a key:value in the provided data
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  array<RuleInterface>  $rules
     * @return void
     */
    private function validateOne(string $key, $value, array $rules)
    {
        foreach ($rules as $rule) {

            if ($rule->valid($value)) {
                continue;
            }

            if ($rule->unsetDataKey()) {
                $this->data[$key] = null;
            } elseif ($rule->errorMessage()) {
                $this->errors[$key][] = $rule->errorMessage();
            }

            if ($rule->isStopping()) {
                break;
            }
        }
    }


    public function isValid(): bool
    {
        return empty($this->errors);
    }


    /**
     *  if there are rules for a key that is not present in the data then
     *  put it as null to be caught in the required rule
     *
     * @return void
     */
    private function addKeysFromRuleset(): void
    {
        foreach ($this->rules as $key => $rule) {
            if (!array_key_exists($key, $this->data)) {
                $this->data[$key] = null;
            }
        }
    }

    /**
     *  don't accept any keys in the data that are not in the ruleset
     *
     * @return void
     */
    private function removeUnwantedKeysFromDataset(): void
    {
        foreach ($this->data as $key => $value) {
            if (!array_key_exists($key, $this->rules)) {
                unset($this->data[$key]);
            }
        }
    }

}