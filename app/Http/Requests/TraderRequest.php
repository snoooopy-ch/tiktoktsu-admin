<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TraderRequest extends FormRequest
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
        $id = $this->request->get('id');

        if ($id > 0) {
            // For update
            return [
                'account'       => 'required|max:255|unique:ea_users,account,' . $id,
                'name'          => 'required|max:255',
                'status'        => 'required',
            ];
        }

        return [
            'account'       => 'required|max:255|unique:ea_users',
            'name'          => 'required|max:255',
            'status'        => 'required',
        ];
    }

    public function messages()
    {
        return [
            'account.required'      => trans('auth.required'),
            'account.max'           => trans('auth.max255'),
            'account.unique'        => trans('auth.unique'),
            'name.required'         => trans('auth.required'),
            'name.max'              => trans('auth.max255'),
            'status.required'       => trans('auth.required'),
        ];
    }
}
