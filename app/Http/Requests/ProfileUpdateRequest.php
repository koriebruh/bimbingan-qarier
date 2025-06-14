<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Jika role user adalah 'pasien', set poli_id jadi null
        if ($this->user()->role === 'pasien') {
            $this->merge([
                'poli_id' => null,
            ]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:500'],
            'no_ktp' => ['required', 'string', 'max:20', Rule::unique(User::class)->ignore($this->user()->id)],
            'no_hp' => ['required', 'string', 'max:15'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'poli_id' => [
                'nullable',
                'exists:poli,id',
            ],
        ];
    }
}
