<?php

declare(strict_types=1);


namespace App\Services;

use Framework\Validator;
use Framework\Rules\{
    RequiredRules,
    EmailRule,
    MinRule,
    InRule,
    URLRule,
    MatchRule,
    LengthMaxRule,
    NumericRule,
    DateFormatRule,
    NoSpacesOnlyRule
};

use Framework\Rules\FileRules\{
    MaxFileSizeRule,
    FileRequiredRule,
    FileNameCheckRule,
    AllowedFileTypesRule
};

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();

        $this->validator->add('required', new RequiredRules());
        $this->validator->add('email', new EmailRule());
        $this->validator->add('min', new MinRule());
        $this->validator->add('in', new InRule());
        $this->validator->add('url', new URLRule());
        $this->validator->add('match', new MatchRule());
        $this->validator->add('maxlen', new LengthMaxRule());
        $this->validator->add('numeric', new NumericRule());
        $this->validator->add('dateformat', new DateFormatRule());
        $this->validator->add('nospaces', new NoSpacesOnlyRule());

        $this->validator->add('filemaxsize', new MaxFileSizeRule());
        $this->validator->add('filerequired', new FileRequiredRule());
        $this->validator->add('filename', new FileNameCheckRule());
        $this->validator->add('filealowedtypes', new AllowedFileTypesRule());
    }


    public function validateLogin(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    }
}
