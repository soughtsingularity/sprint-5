<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginUserRequest;

class LoginUserValidationTest extends TestCase
{
    public function test_email_is_required()
    {
        $data = [
            'email' => '',
            'password' => '12345678!',
        ];

        $request = new LoginUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());
        if($validator->fails()){
            throw new ValidationException($validator);
        }    
    }

    public function test_email_is_valid()
    {
        $data = [
            'email' => 'example',
            'password' => '12345678!',
        ];

        $request = new LoginUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());
        if($validator->fails()){
            throw new ValidationException($validator);
        }    
    }

    public function test_password_is_required()
    {
        $data = [
            'email' => 'example@example.com',
            'password' => '',
        ];

        $request = new LoginUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());
        if($validator->fails()){
            throw new ValidationException($validator);
        }    
    }

    public function test_password_must_have_at_least_8_characters()
    {
        $data = [
            'email' => 'example@example.com',
            'password' => 'asdc!',
        ];

        $request = new LoginUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());
        if($validator->fails()){
            throw new ValidationException($validator);
        }    
    }

    
}
