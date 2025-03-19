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
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ];

        $request = new RegisterUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());
        if($validator->fails()){
            throw new ValidationException($validator);
        }
    }

    public function test_user_name_have_at_least_two_characters()
    {
        $data = [
            'username' => 'a',
            'email' => 'example@gmail.com',
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ];

        $request = new RegisterUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());

        if($validator->fails()){
            throw new ValidationException($validator);
        }
    }

    public function test_user_name_have_max_twenty_charachers()
    {
        $data = [
            'username' => 'asdfcfdcdsdcfdcfdcfds',
            'email' => 'example@gmail.com',
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ];

        $request = new RegisterUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());

        if($validator->fails()){
            throw new ValidationException($validator);
        }
    }

    public function test_email_is_required()
    {
        $data = [
            'username' => 'example',
            'email' => '',
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ];

        $request = new RegisterUserRequest();
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
            'username' => 'example',
            'email' => 'invalidemail',
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ];

        $request = new RegisterUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());

        if($validator->fails()){
            throw new ValidationException($validator);
        }
    }

    public function test_email_must_be_unique()
    {
        $this->expectException(ValidationException::class);

        User::factory()->create(['email' => 'existing@email.com']);
    
        $data = [
            'username' => 'example',
            'email' => 'existing@email.com',
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ];

        $request = new RegisterUserRequest();

        $validator = Validator::make($data, $request->rules());

        if($validator->fails()){
            throw new ValidationException($validator);
        }
    }

    public function test_password_is_required()
    {
        $data = [
            'username' => 'example',
            'email' => 'example@gmail.com',
            'password' => '',
            'password_confirmation' => '',
        ];

        $request = new RegisterUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());

        if($validator->fails()){
            throw new ValidationException($validator);
        }
    }

    public function test_password_must_have_at_least_eight_characters()
    {
        $data = [
            'username' => 'a',
            'email' => 'example@gmail.com',
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ];

        $request = new RegisterUserRequest();
        $request->merge($data);

        $this->expectException(ValidationException::class);

        $validator = Validator::make($request->all(), $request->rules());

        if($validator->fails()){
            throw new ValidationException($validator);
        }
    }

    public function test_password_must_have_special_characters()
    {
        $invalidPasswords = [
            'password1', 
            'Test1234',  
            'abcdefg8',  
        ];
    
        foreach ($invalidPasswords as $invalidPassword) {
            $data = [
                'username' => 'example',
                'email' => 'example@gmail.com',
                'password' => $invalidPassword,
                'password_confirmation' => $invalidPassword,
            ];
    
            $request = new RegisterUserRequest();
            $request->merge($data);
    
            $this->expectException(ValidationException::class);
    
            $validator = Validator::make($request->all(), $request->rules());
    
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }

    }

    public function test_password_must_be_confirmed()
    {
        $data = [
            'username' => 'example',
            'email' => 'example@gmail.com',
            'password' => '12345678!',
            'password_confirmation' => '12345432!',
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
