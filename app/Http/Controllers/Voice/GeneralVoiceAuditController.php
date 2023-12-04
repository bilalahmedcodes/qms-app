<?php

namespace App\Http\Controllers\Voice;

use App\Models\User;
use App\Models\Project;
use App\Models\Campaign;
use App\Models\VoiceAudit;
use Illuminate\Http\Request;
use App\Models\DatapointCategory;
use App\Services\VoiceAuditService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GeneralAuditRequest;
use App\Http\Requests\EditGeneralAuditRequest;

class GeneralVoiceAuditController extends Controller
{
    public $voiceAuditService;

    public function __construct(VoiceAuditService $voiceAuditService)
    {
        $this->voiceAuditService = $voiceAuditService;
    }
    public function index(Request $request)
    {
        $query = new VoiceAudit();
        if (Auth::user()->roles[0]->name == 'Evaluator' && Auth::user()->campaign_id == 11) {
            $query = $query->where('user_id', Auth::user()->hrms_id)->whereIn('campaign_id', [3, 4, 7]);
        } elseif (in_array(Auth::user()->roles[0]->name, ['Team Lead']) && Auth::user()->campaign_id == 11) {
            $query = $query->where('status', '!=', 'assigned to team lead')->whereIn('campaign_id', [3, 4, 7]);
        }
        $query = $query->when($request, function ($query, $request) {
            $query->search($request);
        });
        $associates = User::role('Associate')
            ->whereIn('campaign_id', [3, 4, 7])
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
        $campaigns = Campaign::whereIn('id', [3, 4, 7])
            ->orderBy('name', 'asc')
            ->get();
        $evaluators = User::role('Evaluator')
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
        $projects = Project::orderBy('name', 'asc')->get();
        $general_voice_audits = $query->orderBy('id', 'desc')->paginate(10);
        return view('general-voice-audits.index', compact('associates', 'campaigns', 'evaluators', 'general_voice_audits', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $campaign = Campaign::findOrFail($request->campaign_id);
        $project = Project::findOrFail($request->project_id);
        $associate = User::where('hrms_id', $request->associate_id)->first();
        $team_lead = User::where('hrms_id', $associate->reporting_to)->first();
        $manager = User::where('hrms_id', $team_lead->reporting_to)->first();
        $categories = DatapointCategory::where('campaign_id', $request->campaign_id)
            ->where('project_id', $request->project_id)
            ->where('status', 'active')
            ->with('datapoints')
            ->orderBy('id', 'asc')
            ->get();
        return view('general-voice-audits.create')->with(compact('categories', 'campaign', 'project', 'associate', 'team_lead', 'manager'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralAuditRequest $request)
    {
        // return $request->all();
        $voice_audit = VoiceAudit::create($request->all());
        if ($voice_audit) {
            $this->voiceAuditService->insertAuditPoints($request, $voice_audit);
            return redirect()
                ->back()
                ->with('success', 'Voice Audit created successfully!');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VoiceAudit $general_voice_audit)
    {
        $categories = $this->voiceAuditService->getAuditCategories($general_voice_audit);
        // dd($categories);
        return view('general-voice-audits.show')->with(compact('general_voice_audit', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(VoiceAudit $general_voice_audit)
    {
        $categories = $this->voiceAuditService->getAuditCategories($general_voice_audit);

        return view('general-voice-audits.edit')->with(compact('general_voice_audit', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditGeneralAuditRequest $request, VoiceAudit $general_voice_audit)
    {
        $this->voiceAuditService->auditEditAccess($general_voice_audit);
        $general_voice_audit->update($request->all());
        $this->voiceAuditService->updateAuditPoints($request, $general_voice_audit);
        return redirect()
            ->back()
            ->with('success', 'Audit updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoiceAudit $general_voice_audit)
    {
        $general_voice_audit->delete();
        return redirect()
            ->back()
            ->with('success', 'Voice Audit Deleted Successfully!');
    }
}
