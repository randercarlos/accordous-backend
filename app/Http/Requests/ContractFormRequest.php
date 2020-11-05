<?php

namespace App\Http\Requests;

use App\Models\Contract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractFormRequest extends FormRequest
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
            'contractor_fullname' => ['required', 'max:100'],
            'contractor_email' => ['required', 'email'],
            'person_type' => ['required', Rule::in(['PF', 'PJ'])],
            'document' => ['required', 'max:60', 'formato_cpf_cnpj' ,'cpf_cnpj'],
            'property_id' => ['required', 'exists:properties,id'],
        ];
    }
}
