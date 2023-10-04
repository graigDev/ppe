<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  =>  'required|min:2|max:100',
            'email' =>  'required|email|unique:users,email',
            'role'  =>  'required|exists:roles,id',
            'team'  =>  'required|exists:teams,id'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'role'  =>  (int)$this->role,
            'team'  =>  (int)$this->team,
        ]);

    }

    public function withValidator(Validator $validator): void
    {
        if($validator->fails())
        {
            $validator->after(function () {
                session()->flash('user-create');
            });
        }
    }
}
