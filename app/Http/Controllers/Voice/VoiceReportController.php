<?php

namespace App\Http\Controllers;
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

class VoiceReportController extends Controller
{
    public function associates(Request $request)
    {
        $associates = User::role('Associate')
            ->whereIn('campaign_id', [3, 4, 7])
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
        $campaigns = Campaign::whereIn('id', [3, 4, 7])
            ->orderBy('name', 'asc')
            ->get();
        $projects = Project::orderBy('name', 'asc')->get();

        $query = new VoiceAudit();
        if (in_array(Auth::user()->roles[0]->name, ['Manager', 'Team Lead']) && Auth::user()->campaign_id != 11 && Auth::user()->hrms_id != 695957) {
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
        if ($request->campaign_id > 0) {
            $query = $query->where('voice_audits.campaign_id', '=', $request->campaign_id);
        }
        if ($request->associate_id > 0) {
            $query = $query->where('associate_id', $request->associate_id);
        }
        if ($request->project_id > 0) {
            $query = $query->where('project_id', '=', $request->project_id);
        }
        if ($request->from_date) {
            $query = $query->whereDate('voice_audits.created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query = $query->whereDate('voice_audits.created_at', '<=', $request->to_date);
        }
        $associateReports = $query->groupBy('associate_id')->paginate(15);

        return view('reports.associates', compact('associates', 'campaigns', 'associateReports', 'projects'));
    }
    public function team_leads(Request $request)
    {
        $team_leads = User::role('Team Lead')
            ->whereIn('campaign_id', [3, 4, 7])
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
        $campaigns = Campaign::whereIn('id', [3, 4, 7])
            ->orderBy('name', 'asc')
            ->get();
        $projects = Project::orderBy('name', 'asc')->get();

        $query = new VoiceAudit();

        if (in_array(Auth::user()->roles[0]->name, ['Manager', 'Team Lead']) && Auth::user()->campaign_id != 11 && Auth::user()->hrms_id != 695957) {
            $query = $query->where('team_lead_id', Auth::user()->hrms_id)->orWhere('manager_id', Auth::user()->hrms_id);
            $team_leads = User::role('Team Lead')
                ->where('reporting_to', Auth::user()->hrms_id)
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
            $team_leads = User::role('Team Lead')
                ->where('campaign_id', 4)
                ->where('status', 'active')
                ->orderBy('name', 'asc')
                ->get();
            $campaigns = Campaign::where('id', 4)->get();
            $projects = Project::where('campaign_id', 4)
                ->orderBy('name', 'asc')
                ->get();
        }
        if ($request->campaign_id > 0) {
            $query = $query->where('voice_audits.campaign_id', '=', $request->campaign_id);
        }
        if ($request->team_lead_id > 0) {
            $query = $query->where('team_lead_id', $request->team_lead_id);
        }
        if ($request->project_id > 0) {
            $query = $query->where('project_id', '=', $request->project_id);
        }
        if ($request->from_date) {
            $query = $query->whereDate('voice_audits.created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query = $query->whereDate('voice_audits.created_at', '<=', $request->to_date);
        }
        $teamLeadReports = $query->groupBy('team_lead_id')->paginate(15);

        return view('reports.team-leads', compact('team_leads', 'campaigns', 'teamLeadReports', 'projects'));
    }
    public function managers(Request $request)
    {
        $managers = User::role('Manager')
            ->whereIn('campaign_id', [3, 4, 7])
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
        $campaigns = Campaign::whereIn('id', [3, 4, 7])
            ->orderBy('name', 'asc')
            ->get();
        $projects = Project::orderBy('name', 'asc')->get();

        $query = new VoiceAudit();

        if (in_array(Auth::user()->roles[0]->name, ['Manager']) && Auth::user()->campaign_id != 11 && Auth::user()->hrms_id != 695957) {
            $query = $query->where('manager_id', Auth::user()->hrms_id);
            $managers = User::role('Manager')
                ->where('hrms_id', Auth::user()->hrms_id)
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
            $managers = User::role('Manager')
                ->where('campaign_id', 4)
                ->where('status', 'active')
                ->orderBy('name', 'asc')
                ->get();
            $campaigns = Campaign::where('id', 4)->get();
            $projects = Project::where('campaign_id', 4)
                ->orderBy('name', 'asc')
                ->get();
        }

        if ($request->campaign_id > 0) {
            $query = $query->where('voice_audits.campaign_id', '=', $request->campaign_id);
        }
        if ($request->manager_id > 0) {
            $query = $query->where('manager_id', $request->manager_id);
        }
        if ($request->project_id > 0) {
            $query = $query->where('project_id', '=', $request->project_id);
        }
        if ($request->from_date) {
            $query = $query->whereDate('voice_audits.created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query = $query->whereDate('voice_audits.created_at', '<=', $request->to_date);
        }
        $managerReports = $query->groupBy('manager_id')->paginate(15);

        return view('reports.managers', compact('managers', 'campaigns', 'managerReports', 'projects'));
    }
    public function evaluators(Request $request)
    {
        $evaluators = User::role('Evaluator')
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
        $campaigns = Campaign::whereIn('id', [3, 4, 7])
            ->orderBy('name', 'asc')
            ->get();
        $projects = Project::orderBy('name', 'asc')->get();

        $query = VoiceAudit::select('id', 'associate_id', 'team_lead_id', 'manager_id', 'campaign_id', 'project_id', 'user_id')->with('campaign:id,name', 'associate:hrms_id,name');
        if ($request->campaign_id > 0) {
            $query = $query->where('voice_audits.campaign_id', '=', $request->campaign_id);
        }
        if ($request->user_id > 0) {
            $query = $query->where('user_id', $request->user_id);
        }
        if ($request->project_id > 0) {
            $query = $query->where('project_id', '=', $request->project_id);
        }
        if ($request->from_date) {
            $query = $query->whereDate('voice_audits.created_at', '>=', $request->from_date);
        } elseif ($request->to_date) {
            $query = $query->whereDate('voice_audits.created_at', '<=', $request->to_date);
        }
        if (in_array(Auth::user()->roles[0]->name, ['Evaluator'])) {
            $query = $query->where('user_id', Auth::user()->hrms_id);
        }
        $evaluatorReports = $query->groupBy('user_id')->paginate(15);

        return view('reports.evaluators', compact('evaluators', 'campaigns', 'evaluatorReports', 'projects'));
    }
    public function campaigns(Request $request)
    {
        $campaigns = Campaign::whereIn('id', [3, 4, 7])
            ->orderBy('name', 'asc')
            ->get();
        $projects = Project::orderBy('name', 'asc')->get();

        $query = new VoiceAudit();

        if (in_array(Auth::user()->roles[0]->name, ['Manager', 'Team Lead']) && Auth::user()->campaign_id != 11 && Auth::user()->hrms_id != 695957) {
            $query = $query->where('campaign_id', Auth::user()->campaign_id);

            $campaigns = Campaign::where('id', Auth::user()->campaign_id)
                ->orderBy('name', 'asc')
                ->get();
            $projects = Project::where('campaign_id', Auth::user()->campaign_id)
                ->orderBy('name', 'asc')
                ->get();
        }

        if (in_array(Auth::user()->hrms_id, ['87223', '238430']) && Auth::user()->campaign_id != 11) {
            $query = $query->where('campaign_id', 4);
            $campaigns = Campaign::where('id', 4)->get();
            $projects = Project::where('campaign_id', 4)
                ->orderBy('name', 'asc')
                ->get();
        }

        if ($request->campaign_id > 0) {
            $query = $query->where('voice_audits.campaign_id', '=', $request->campaign_id);
        }
        if ($request->project_id > 0) {
            $query = $query->where('project_id', '=', $request->project_id);
        }
        if ($request->from_date) {
            $query = $query->whereDate('voice_audits.created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query = $query->whereDate('voice_audits.created_at', '<=', $request->to_date);
        }
        $campaignReports = $query->groupBy('campaign_id')->paginate(15);

        return view('reports.campaigns', compact('campaigns', 'campaignReports', 'projects'));
    }
    // public function timesheet(Request $request)
    // {
    //     $evaluators = User::role('Evaluator')
    //         ->where('status', 'active')
    //         ->orderBy('name', 'asc')
    //         ->get();
    //     $campaigns = Campaign::whereIn('id', [3, 4, 7])
    //         ->orderBy('name', 'asc')
    //         ->get();
    //     $projects = Project::orderBy('name', 'asc')->get();
    //     $query = new User();

    //     $query = $query->where('campaign_id', 11);

    //     $query = $query->when($request, function ($query, $request) {
    //         $query->search($request);
    //     });

    //     $query = $query->whereHas('voiceAudits', function ($query) use ($request) {
    //         $query = $query->when($request, function ($query, $request) {
    //             $query->search($request);
    //         });
    //     });

    //     $query = $query->with('voiceAudits', function ($query) use ($request) {
    //         $query = $query->when($request, function ($query, $request) {
    //             $query->search($request);
    //         });
    //     });

    //     $query = $query->orderBy('name', 'asc');

    //     // return $timeSheetReports = $query->paginate(15);

    //     return view('reports.timesheet')->with(compact('evaluators','campaigns','projects','timeSheetReports'));
    // }
}
