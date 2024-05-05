<?php

declare(strict_types=1);


namespace App\Services;

use Framework\Validator;
use Framework\Rules\{
    RequiredRules,
    EmailRule,
    MinRule,
    MaxRule,
    InRule,
    URLRule,
    MatchRule,
    LengthMaxRule,
    LengthMinRule,
    NumericRule,
    DateFormatRule,
    NoSpacesOnlyRule,
    NoSpacesAtAll,
    NamesRule
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
        $this->validator->add('max', new MaxRule());
        $this->validator->add('in', new InRule());
        $this->validator->add('url', new URLRule());
        $this->validator->add('match', new MatchRule());
        $this->validator->add('maxlen', new LengthMaxRule());
        $this->validator->add('minlen', new LengthMinRule());
        $this->validator->add('numeric', new NumericRule());
        $this->validator->add('dateformat', new DateFormatRule());
        $this->validator->add('nospaces', new NoSpacesOnlyRule());
        $this->validator->add('nospaceatall', new NoSpacesAtAll());
        $this->validator->add('names', new NamesRule());

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
        ], false);
    }

    public function validateSignup(array $formData)
    {
        $this->validator->validate($formData, [
            'fname' => ['required', 'nospaceatall', 'names'],
            'lname' => ['required', 'nospaceatall', 'names'],
            'email' => ['required', 'email'],
            'password' => ['required', 'minlen:8', 'nospaceatall'],
            'confirmPassword' => ['required', 'match:password'],
            'gender' => ['required', 'in:male,female'],
            'dateOfBirth' => ['required', 'dateformat:Y-m-d']

        ], false);
    }

    public function VaildateRequest(array $formData)
    {
        $this->validator->validate($formData, [
            'id' => ['required', 'numeric']
        ], true);
    }

    public function chatMessage(array $formData)
    {
        $this->validator->validate($formData, [
            'message' => ['required', 'nospaces'],
        ], true);
    }


    public function postsValidation($formData)
    {
        $this->validator->validate($formData, [
            'content' => ['required']
        ]);
    }

    public function Mediavalidator($formData,string $type)
    {
        $singleFileInfo = [];
        $paramsToValidate = [];
        /* $type = "photo"; */
        
        $length = count($formData["name"]);
        $photoRules = ['filemaxsize:1', 'filealowedtypes:png,jpg,jpeg'];
        $videoRules = ['filemaxsize:1', 'filealowedtypes:png,jpg,jpeg'];
        
        for ($i = 0; $i < $length; $i++) {
            $singleFileInfo["$i"] = [
                "name" => $formData["name"][$i],
                "full_path" => $formData["full_path"][$i],
                "type" => $formData["type"][$i],
                "tmp_name" => $formData["tmp_name"][$i],
                "error" => $formData["error"][$i],
                "size" => $formData["size"][$i]
            ];
        
            $paramsToValidate[] = $type == 'photo' ? $photoRules : $videoRules;
        }
        // debug($singleFileInfo);
        if($type=="photo"){
            
            $this->validator->validate($singleFileInfo,$paramsToValidate);
        }

    }
}
