<?php

namespace App\Http\Requests;

use App\Models\Technique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $techniqueId = null;
        if ($this->id !== null) {
            // Avoid SQL injection by checking if user supplied technique ID exists
            $technique = Technique::findOrFail($this->id);
            $techniqueId = $technique->id;
        }

        $academyId = Auth::user()->academies()->first()->id;

        return [
            'id' => 'nullable|integer', // @todo: Handle this validation in some other way?
            'name' => [
                'required',
                'max:255',
                Rule::unique('techniques')
                    ->where(fn ($q) => $q->where('academy_id', $academyId))
                    ->ignore($techniqueId)
            ],
            'description' => 'max:2048',
            'youtube_url' => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => _('You need to enter a name'),
            'name.max' => _('The name is too long. Maximum is 255 characters.'),
            'name.unique' => _('This technique already exists'),
            'description.max' => _('The description is too long. Maximum is 2048 characters.'),
            'youtube_url.url' => _('Not a valid Youtube link')
        ];
    }
}
