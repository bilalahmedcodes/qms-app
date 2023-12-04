<table>
    <thead>
        <tr>
            <th>Evaluation Date</th>
            <th>Call Date</th>
            <th>Evaluator</th>
            <th>HRMS ID</th>
            <th>Associate</th>
            <th>Team Lead</th>
            <th>Manager</th>
            <th>Campaign</th>
            <th>Project</th>
            <th>Result</th>
            <th>Outcome</th>
            <th>Customer Name</th>
            <th>Customer Phone</th>
            <th>Recording Link</th>
            <th>Status</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        @if (count($general_voice_audits) > 0)
            @foreach ($general_voice_audits as $key => $general_voice_audit)
                <tr>
                    <td>{{ $general_voice_audit->created_at->format('m-d-Y g:i:s A') }}</td>
                    <td>{{ $general_voice_audit->call_date }}</td>
                    <td>{{ $general_voice_audit->evaluator->name ?? '' }}</td>
                    <td>{{ $general_voice_audit->associate_id ?? 0 }}</td>
                    <td>{{ $general_voice_audit->associate->name ?? '' }}</td>
                    <td>{{ $general_voice_audit->teamLead->name ?? '' }}</td>
                    <td>{{ $general_voice_audit->manager->name ?? '' }}</td>
                    <td>{{ $general_voice_audit->campaign->name ?? '' }}</td>
                    <td>{{ $general_voice_audit->project->name ?? '' }}</td>
                    <td>{{ $general_voice_audit->percentage }}</td>
                    <td>
                        @if ($general_voice_audit->agent_outcome == 'accepted')
                            <span class="badge bg-success">Accepted</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $general_voice_audit->customer_name ?? '' }}</td>
                    <td>{{ $general_voice_audit->customer_phone ?? 0 }}</td>
                    <td>{{ $general_voice_audit->recording_link ?? '' }}</td>
                    <td>@include('includes.status', [
                        'status' => $general_voice_audit->status,
                    ])</td>
                    <td>{{ $general_voice_audit->notes ?? '' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="15" class="text-center">No record found!</td>
            </tr>
        @endif
    </tbody>
</table>
