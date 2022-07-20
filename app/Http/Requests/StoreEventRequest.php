<?php

namespace App\Http\Requests;

use App\Models\AcademyEvent;
use App\Services\AcademyEventService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
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
            'start_date' => 'required|date',
            'start_hour' => 'required|in:' . implode(',', array_keys(AcademyEventService::getHours())),
            'start_minute' => 'required|in:' . implode(',', array_keys(AcademyEventService::getMinutes())),
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_hour' => 'required|in:' . implode(',', array_keys(AcademyEventService::getHours())),
            'end_minute' => 'required|in:' . implode(',', array_keys(AcademyEventService::getMinutes())),
            'description' => 'max:2048'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('You need to enter a name'),
            'name.max' => __('The name is too long. Maximum is 255 characters.'),
            'description.max' => __('The description is too long. Maximum is 2048 characters.'),
        ];
    }
}
