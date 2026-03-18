<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'rating'  => ['required', 'integer', 'between:1,5'],
            'title'   => ['nullable', 'string', 'max:150'],
            'comment' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }
}
