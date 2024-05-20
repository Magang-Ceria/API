<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIndividualInternRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        $exist = $method == 'PUT' ? '' : 'sometimes';
        return [
            'address' => [$exist, 'required', 'max:255'],
            'institution' => [$exist, 'nullable', 'max:100'],
            'startperiode' => [$exist, 'required', 'date_format:Y-m-d'],
            'endperiode' => [$exist, 'required', 'date_format:Y-m-d', 'after:startperiode'],
            'document' => [$exist, 'required', 'file', 'mimetypes:application/pdf', 'max:2000']
        ];
    }
}
