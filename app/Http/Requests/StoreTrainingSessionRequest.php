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
            'techniques.*.id' => 'nullable|integer', // @todo: Handle this validation in some other way?
            'techniques.*.name' => 'required|max:255',
            'techniques.*.description' => 'max:2048',
            'techniques.*.youtube_url' => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'date.required' => __('You need to select a date'),
            'date.date' => __('Incorrect date format'),
            'description.max' => __('The description is too long. Maximum is 2048 characters.'),
            'techniques.*.name.required' => __('You need to enter a name'),
            'techniques.*.name.max' => __('The name is too long. Maximum is 255 characters.'),
            'techniques.*.description.max' => __('The description is too long. Maximum is 2048 characters.'),
            'techniques.*.youtube_url.url' => __('Not a valid Youtube link')
        ];
    }
}
