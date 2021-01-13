<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->id() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255|min:2',
            'last_name' => 'required|string|max:255|min:2',
            'dni' => 'required|numeric|min:8',
            'email' => 'required|email',
            'origin_id' => 'required',
            'area_range' => 'required',
            'type_financing' => 'required',
            'project_id' => 'required',
            'project_apartment_id' => 'required',
            'district_id' => 'required'
        ];
    }
}
