<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEmployeesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check(true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string|in:MALE,FEMALE',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:255',
            'role_id' => 'nullable|integer',
            'team_id' => 'nullable|integer'
        ];
    }
}
