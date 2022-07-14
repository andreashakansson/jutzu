<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTechniqueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'nullable|integer', // @todo: Handle this validation in some other way?
            'name' => 'required|max:255',
            'description' => 'max:2048',
            'youtube_url' => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => _('You need to enter a name'),
            'name.max' => _('The name is too long. Maximum is 255 characters.'),
            'description.max' => _('The description is too long. Maximum is 2048 characters.'),
            'youtube_url.url' => _('Not a valid Youtube link')
        ];
    }
}
