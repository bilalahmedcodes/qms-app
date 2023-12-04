<?php

namespace App\Exports;

use App\Models\VoiceAudit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class GeneralEvaluationsExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $query = new VoiceAudit();
        if (in_array(Auth::user()->roles[0]->name, ['Manager', 'Team Lead']) && Auth::user()->campaign_id != 11) {
            $query = $query->where('team_lead_id', Auth::user()->hrms_id)->orWhere('manager_id', Auth::user()->hrms_id);
        }
        if (in_array(Auth::user()->hrms_id, ['87223', '238430']) && Auth::user()->campaign_id != 11) {
            $query = $query->where('campaign_id', 4);
        }
        $query = $query->when($request, function ($query, $request) {
            $query->search($request);
        });

        $voice_evaluations = $query->orderBy('id', 'desc')->get();

        return view('exports.general-evaluations', [
            'voice_evaluations' => $voice_evaluations,
        ]);
    }
}
