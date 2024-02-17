<?php

namespace App\Http\Requests\User;

use App\Http\RequestModels\CreateUserModel;
use App\Http\Requests\BaseFormRequest;

class CreateUserRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ];
    }

    public function body(): CreateUserModel
    {
        $model = new CreateUserModel();
        $model->name = $this->string('name');
        $model->email = $this->string('email');
        $model->password = $this->string('password');

        return $model;
    }
}
