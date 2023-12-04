<?php

namespace App\Http\Controllers\Voice;

use App\Models\User;
use App\Models\Project;
use App\Models\Campaign;
use App\Models\VoiceAudit;
use Illuminate\Http\Request;
use App\Services\VoiceAuditService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VoiceEvaluationReviewController extends Controller
{
    public $voiceAuditService;

    public function __construct(VoiceAuditService $voiceAuditService)
    {
        $this->voiceAuditService = $voiceAuditService;
    }
    public function index(Request $request)
    {
        $query = new VoiceAudit();
        if (in_array(Auth::user()->roles[0]->name, ['Manager', 'Team Lead']) && Auth::user()->campaign_id != 11) {
            $query = $query->where('team_lead_id', Auth::user()->hrms_id)->orWhere('manager_id', Auth::user()->hrms_id);
            $associates = User::role('Associate')
                ->where('campaign_id', 4)
                ->where('status', 'active')
                ->orderBy('name', 'asc')
                ->get();
            $campaigns = Campaign::where('id', Auth::user()->campaign_id)
                ->orderBy('name', 'asc')
                ->get();
            $projects = Project::where('campaign_id', Auth::user()->campaign_id)
                ->orderBy('name', 'asc')
                ->get();
        }
        if (in_array(Auth::user()->hrms_id, ['87223', '238430']) && Auth::user()->campaign_id != 11) {
            $query = $query->where('campaign_id', 4);
            $associates = User::role('Associate')
                ->where('campaign_id', 4)
                ->where('status', 'active')
                ->orderBy('name', 'asc')
                ->get();
            $campaigns = Campaign::where('id', 4)->get();
            $projects = Project::where('campaign_id', 4)
                ->orderBy('name', 'asc')
                ->get();
        }
        $query = $query->when($request, function ($query, $request) {
            $query->search($request);
        });
        $voice_evaluations = $query->orderBy('id', 'desc')->paginate(100);
        return view('voice-evaluations.index', compact('associates', 'campaigns', 'projects', 'voice_evaluations'));
    }
}
