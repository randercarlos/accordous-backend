<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;

class PropertyFormRequest extends FormRequest
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
            'owner_email' => ['required', 'email'],
            'address' => ['required', 'max:200'],
            'neighborhood' => ['required', 'max:60'],
            'city' => ['required', 'max:60'],
            'state' => ['required', 'size:2'],
        ];
    }
}
