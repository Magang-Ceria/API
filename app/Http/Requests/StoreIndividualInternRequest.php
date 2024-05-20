<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIndividualInternRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !=null && $user->tokenCan('aplicant:create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address' => ['required', 'max:255'],
            'institution' => ['nullable', 'max:100'],
            'startperiode' => ['required', 'date_format:Y-m-d'],
            'endperiode' => ['required', 'date_format:Y-m-d', 'after:startperiode'],
            'document' => ['required', 'file', 'mimetypes:application/pdf', 'extension:pdf', 'size:2000'],
        ];
    }
}
