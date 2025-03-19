<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class RegisterUserValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_name_ir_required()    
    {

        $data = [
            'username' => '',
            'email' => 'example@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $request = new RegisterUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());
        if($validator->fails()){
            throw new ValidationException($validator);
        }
    }
    
}
