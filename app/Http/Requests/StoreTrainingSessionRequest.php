<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingSessionRequest extends FormRequest
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
            'date' => 'required|date',
            'type' => 'required|in:' . implode(',', array_keys(config('project.trainingSession.types'))),
            'description' => 'max:2048',
            'techniques.*.name' => 'required|max:255',
            'techniques.*.description' => 'max:2048',
            'techniques.*.youtubeUrl' => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'date.required' => _('You need to select a date'),
            'date.date' => _('Incorrect date format'),
            'description.max' => _('Description is too long. Maximum is 2048 characters.'),
            'techniques.*.name.required' => _('You need to enter a name'),
            'techniques.*.name.max' => _('The name is too long. Maximum is 255 characters.'),
            'techniques.*.description.max' => _('The description is too long. Maximum is 2048 characters.'),
            'techniques.*.youtubeUrl.url' => _('Not a valid Youtube link')
        ];
    }
}
