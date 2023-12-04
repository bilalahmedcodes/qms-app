<?php

namespace App\Traits;

use App\Models\Project;
use App\Models\User;
/**
 *
 */
trait UserTrait
{
    public function getDetail($hrms_id)
    {
        $user = User::where('hrms_id',$hrms_id)->first();
        $campaign_id = $user->campaign_id;
        $project_ids = Project::where('campaign_id',$campaign_id)->get();
        $data = [
            'campaign_id' => $campaign_id,
            'project_ids' => $project_ids
        ];
        return response()->json($data, 200);
    }
}
