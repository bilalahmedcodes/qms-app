<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralAuditRequest extends FormRequest
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
            'associate_id' => 'required',
            'team_lead_id' => 'required',
            'manager_id' => 'required',
            'campaign_id' => 'required',
            'project_id' => 'required',
            'call_date' => 'required',
            'percentage' => 'required',
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'recording_duration' => 'required',
            'recording_link' => 'required',
            'agent_outcome' => 'required',
            'call_type' => 'required',
            'notes' => 'required',
        ];
    }
}
