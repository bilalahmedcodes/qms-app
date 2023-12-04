<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatapointCategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'campaign_id' => 'required',
            'project_id' => 'required',
            'name' => 'required',
            'status' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'campaign_id' => 'campaign',
            'project_id' => 'project',
        ];
    }
}
