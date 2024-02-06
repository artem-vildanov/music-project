<?php

namespace App\Http\Requests\Album;

use Illuminate\Foundation\Http\FormRequest;

class CreateAlbumRequest extends FormRequest
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
            'name' => 'required|string',
            'photo' => 'required|mimes:png,jpg,jpeg',
            'songs' => 'required|array',
//            'songs.*' => [
//                'name' => 'required|string',
//                'music' => 'required|mimes:mp3',
//            ]
        ];
    }
}
