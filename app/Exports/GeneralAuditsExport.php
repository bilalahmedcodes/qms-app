<?php

namespace App\Exports;

use App\Models\VoiceAudit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class GeneralAuditsExport implements FromView
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
        if (Auth::user()->roles[0]->name == 'Evaluator' && Auth::user()->campaign_id == 11) {
            $query = $query->where('user_id', Auth::user()->hrms_id)->whereIn('campaign_id', [3, 4, 7]);
        } elseif (in_array(Auth::user()->roles[0]->name, ['Team Lead']) && Auth::user()->campaign_id == 11) {
            $query = $query->where('status', '!=', 'assigned to team lead')->whereIn('campaign_id', [3, 4, 7]);
        }
        $query = $query->when($request, function ($query, $request) {
            $query->search($request);
        });
        $general_voice_audits = $query->orderBy('id', 'desc')->get();

        return view('exports.general-voice-audits', [
            'general_voice_audits' => $general_voice_audits,
        ]);
    }
}
