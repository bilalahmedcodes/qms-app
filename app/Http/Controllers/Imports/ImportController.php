<?php

namespace App\Http\Controllers\Imports;

use Illuminate\Http\Request;
use App\Imports\VoiceAuditsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import()
    {
        Excel::import(new VoiceAuditsImport, 'Book1.xlsx');
    }
}
