<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // или $this->user()->can('update-profile') и т.д.
    }

    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'name'       => ['required', 'string', 'max:255'],
            'nickname'   => [
                'nullable',
                'string',
                'max:50',
                "unique:users,nickname,{$userId}", // игнорируем текущего пользователя
            ],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                "unique:users,email,{$userId}",
            ],
            'country'    => ['nullable', 'string', 'size:2'], // ISO 3166-1 alpha-2
            'city'       => ['nullable', 'string', 'max:100'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before:-13 years'], // минимум 13 лет

            // пароль — опционально, если заполнен — проверяем
            'password'   => ['nullable', 'string', Password::defaults(), 'confirmed'],

            // аватарка
            'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nickname.unique' => 'Этот никнейм уже занят.',
            'email.unique'    => 'Этот email уже используется.',
            'birth_date.before' => 'Вы должны быть старше 13 лет.',
            'avatar.max'      => 'Размер файла не должен превышать 2 МБ.',
        ];
    }

    protected function prepareForValidation()
    {
        // если пароль не заполнен — убираем его из данных
        if (!$this->filled('password')) {
            $this->request->remove('password');
            $this->request->remove('password_confirmation');
        }
    }
}
