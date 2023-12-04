<?php

namespace App\Imports;

use App\Models\VoiceAudit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Http\Request;use Carbon\Carbon;

class VoiceAuditsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function Collection(Collection $rows)
    {
        foreach ($rows as $row) {
            VoiceAudit::where('customer_phone', $row['customer_phone'])->update([
                'agent_outcome' => $row['outcome'],
                'notes' => $row['notes']
            ]);
        }

    }
}
