<?php

namespace App\Helpers\Validator;

interface RuleInterface
{
    /** handles the input value by examining its validity to the rule
     *
     * @param $value
     *
     * @return bool
     */
    public function valid($value): bool;


    /** The Error Message in case of the validation error
     *
     * @return string
     */
    public function errorMessage(): string;


    /** Decides if that rule is stopping for other rules or not
     *
     * @return bool
     */
    public function isStopping(): bool ;


    /** if true, unsets the data key
     * @return bool
     */
    public function unsetDataKey(): bool;
}