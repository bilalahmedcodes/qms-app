<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Datapoint;
use App\Models\VoiceAudit;
use App\Models\VoiceAuditPoint;
use App\Models\VoiceAuditAppeal;
use App\Models\DatapointCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\VoiceAuditCustomField;
use App\Models\AssignedVoiceAuditPoint;
use App\Models\CustomField;

/**
 *
 */
class VoiceAuditService
{
    public function insertAuditPoints($request, $audit)
    {

        foreach ($request->all() as $key => $item) {
            $key = explode('-', $key);
            if (count($key) > 1) {
                if ($key[0] == 'custom_field_id') {
                    $datapoint = Datapoint::find($key[1]);
                    $custom_field = CustomField::find($item);
                    $answer = $custom_field->values;
                    if (str_contains($answer, 'Na')) {
                        $answer = -1;
                    }
                    VoiceAuditPoint::create([
                        'datapoint_category_id' => $datapoint->datapoint_category_id,
                        'datapoint_id' => $datapoint->id,
                        'voice_audit_id' => $audit->id,
                        'custom_field_id' => $custom_field->id,
                        'answer' => $answer,
                    ]);
                }
            }
        }
    }

    public function getAuditCategories($audit)
    {
        $datapoint_categories = DatapointCategory::where('campaign_id', $audit->campaign_id)
            ->where('project_id', $audit->project_id)
            ->orderBy('id', 'asc')
            ->get();

        $categories = [];

        foreach ($datapoint_categories as $category) {
            $datapoints = Datapoint::with('customFields')
                ->where('datapoint_category_id', $category->id)
                ->where('campaign_id', $audit->campaign_id)
                ->where('project_id', $audit->project_id)
                ->orderBy('id', 'asc')
                ->get();

            $categoryData = [];

            foreach ($datapoints as $datapoint) {
                $customFields = CustomField::where('datapoint_category_id', $category->id)
                    ->where('datapoint_id', $datapoint->id)
                    ->orderBy('id', 'asc')
                    ->get();

                $datapointData = [
                    'datapoint' => $datapoint,
                    'customFields' => [],
                ];

                foreach ($customFields as $customField) {
                    $ev_points = VoiceAuditPoint::where('datapoint_category_id', $category->id)
                        ->where('datapoint_id', $datapoint->id)
                        ->where('custom_field_id', $customField->id)
                        ->where('voice_audit_id', $audit->id)
                        ->orderBy('id', 'asc')
                        ->get();

                    $customFieldData = [
                        'customField' => $customField,
                        'evPoints' => $ev_points,
                    ];

                    $datapointData['customFields'][] = $customFieldData;
                }

                $categoryData[$datapoint->name] = $datapointData;
            }

            $categories[$category->name] = $categoryData;
        }
        return $categories;
    }
    public function updateAuditPoints($request, $audit)
    {
        foreach ($request->all() as $key => $item) {
            $key = explode('-', $key);
            if (count($key) > 1) {
                if ($key[0] == 'custom_field_id') {
                    $custom_field = CustomField::find($item);
                    VoiceAuditPoint::where('datapoint_category_id', $custom_field->datapoint_category_id)
                        ->where('datapoint_id', $custom_field->datapoint_id)
                        ->update([
                            'custom_field_id' => $custom_field->id,
                            'answer' => $custom_field->values,
                        ]);
                }
            }
        }
    }
    public function auditShowAccess()
    {
        $access = false;
        if (in_array(Auth::user()->roles[0]->name, ['Director', 'Manager', 'Team Lead', 'Associate']) && Auth::user()->campaign_id == 4) {
            $access = true;
        } elseif (in_array(Auth::user()->roles[0]->name, ['Super Admin', 'Director'])) {
            $access = true;
        }

        if ($access == false) {
            abort(403);
        }

        return true;
    }

    public function auditEditAccess($voice_audit)
    {
        $access = false;
        if (in_array(Auth::user()->roles[0]->name, ['Director', 'Manager', 'Team Lead', 'Associate']) && Auth::user()->campaign_id == 4) {
            if (Auth::user()->roles[0]->name == 'Associate' && $voice_audit->user_id == Auth::user()->id) {
                $diff = $voice_audit->created_at->diffInHours(now());
                if ($diff < 24) {
                    $access = true;
                }
            } elseif (in_array(Auth::user()->roles[0]->name, ['Director', 'Manager', 'Team Lead'])) {
                $access = true;
            }
        } elseif (in_array(Auth::user()->roles[0]->name, ['Super Admin'])) {
            $access = true;
        }

        if ($access == false) {
            abort(403);
        }

        return true;
    }

    public function auditDeleteAccess($voice_audit)
    {
        $access = false;

        if (in_array(Auth::user()->roles[0]->name, ['Super Admin']) || (in_array(Auth::user()->roles[0]->name, ['Manager']) && Auth::user()->campaign_id == 4)) {
            $access = true;
        }

        if ($access == false) {
            abort(403);
        }

        return true;
    }
    // public function getAuditCategories($audit)
    // {
    //     $datapoint_categories = DatapointCategory::where('campaign_id', $audit->campaign_id)
    //         ->where('project_id', $audit->project_id)
    //         ->orderBy('id', 'asc')
    //         ->get();
    //     // get evaluation categories
    //     $categories = [];
    //     foreach ($datapoint_categories as $category) {
    //         $datapoints = Datapoint::where('datapoint_category_id', $category->id)
    //             ->where('campaign_id', $audit->campaign_id)
    //             ->where('project_id', $audit->project_id)
    //             ->orderBy('id', 'asc')
    //             ->get();
    //         foreach ($datapoints as $datapoint) {
    //             $customFields = CustomField::where('datapoint_category_id', $category->id)
    //                 ->where('datapoint_id', $datapoint->id)
    //                 ->orderBy('id', 'asc')
    //                 ->get();
    //             foreach ($customFields as $customField) {
    //                 $ev_points = VoiceAuditPoint::with('datapoint')
    //                     ->where('datapoint_category_id', $category->id)
    //                     ->where('datapoint_id', $datapoint->id)
    //                     ->where('custom_field_id', $customField->id)
    //                     ->where('voice_audit_id', $audit->id)
    //                     ->orderBy('id', 'asc')
    //                     ->get();
    //                 $categories[$category->name] = $ev_points;
    //             }
    //         }
    //     }
    //     return $categories;
    // }
}
