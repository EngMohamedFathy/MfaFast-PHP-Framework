<?php

namespace MfaFast\Validation;

use MfaFast\Validation\Rules\MaxRule;
use MfaFast\Validation\Rules\EmailRule;
use MfaFast\Validation\Rules\UniqueRule;
use MfaFast\Validation\Rules\BetweenRule;
use MfaFast\Validation\Rules\AlphaNumRule;
use MfaFast\Validation\Rules\RequiredRule;
use MfaFast\Validation\Rules\ConfirmedRule;

trait RulesMapper
{
    protected static array $map = [
        'required' => RequiredRule::class,
        'alnum' => AlphaNumRule::class,
        'max' => MaxRule::class,
        'between' => BetweenRule::class,
        'email' => EmailRule::class,
        'confirmed' => ConfirmedRule::class,
        'unique' => UniqueRule::class,
    ];

    public static function resolve(string $rule, $options)
    {
        return new static::$map[$rule](...$options);
    }
}
