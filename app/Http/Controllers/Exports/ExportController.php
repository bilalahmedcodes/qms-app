<?php

namespace App\Http\Controllers\Exports;

use Illuminate\Http\Request;
use App\Exports\GeneralAuditsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GeneralEvaluationsExport;

class ExportController extends Controller
{
    public function generalVoiceAudits(Request $request)
    {
        $now = now();
        return Excel::download(new GeneralAuditsExport($request), "General-Voice-Audits-{$now->toString()}.xlsx");
    }
    public function generalEvaluations(Request $request)
    {
        $now = now();
        return Excel::download(new GeneralEvaluationsExport($request), "General-Evaluations-{$now->toString()}.xlsx");
    }
}
