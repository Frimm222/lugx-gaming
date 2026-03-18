<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:games,slug,' . $this->game?->id,
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'discount_price'    => 'nullable|numeric|min:0|lte:price',
            'cover_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'game_id_code'      => 'nullable|string|max:50',
            'release_date'      => 'nullable|date',
            'developer'         => 'nullable|string|max:100',
            'publisher'         => 'nullable|string|max:100',
            'genres'            => 'array',
            'platforms'         => 'array',
            'tags'              => 'array',
        ];

        return $rules;
    }
}
