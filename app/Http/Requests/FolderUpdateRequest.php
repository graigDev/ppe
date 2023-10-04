<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class FolderUpdateRequest extends FormRequest
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
            'name'  =>  'required|min:2|max:100'
        ];
    }

    public function withValidator(Validator $validator): void
    {
        if($validator->fails())
        {
            $validator->after(function () {
                session()->flash('file-edit-' . $this->object->id);
            });
        }
    }
}
