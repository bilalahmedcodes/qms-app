<div class="card">
    <div class="card-body">
        <h4 class="card-title">General Audit Details</h4>
        <table class="table table-striped">
            @if (in_array(Auth::user()->roles[0]->name, ['Super Admin', 'Admin']) ||
                    Auth::user()->hrms_id == 695957 ||
                    (in_array(Auth::user()->roles[0]->name, ['Team Lead', 'Evaluator']) && Auth::user->campaign_id == 11))
                <tr>
                    <th>Evaluator</th>
                    <td>{{ $general_voice_audit->evaluator->name ?? '' }}</td>
                </tr>
            @endif
            <tr>
                <th>Evaluation Date</th>
                <td>{{ $general_voice_audit->created_at->format('m-d-Y g:i:s A') }}</td>
            </tr>
            <tr>
                <th>Call Date</th>
                <td>{{ $general_voice_audit->call_date }}</td>
            </tr>
            <tr>
                <th>Associate</th>
                <td>{{ $general_voice_audit->associate->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Team Lead</th>
                <td>{{ $general_voice_audit->teamLead->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Manager</th>
                <td>{{ $general_voice_audit->manager->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Campaign</th>
                <td>{{ $general_voice_audit->campaign->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Project</th>
                <td>{{ $general_voice_audit->project->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Result</th>
                <td>{{ round($general_voice_audit->percentage) ?? 0 }}%</td>
            </tr>
            <tr>
                <th>Outcome</th>
                <td>
                    @if ($general_voice_audit->agent_outcome == 'accepted')
                        <span class="badge bg-success">Accepted</span>
                    @else
                        <span class="badge bg-danger">Rejected
                        </span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @include('includes.status', ['status' => $general_voice_audit->status])
                </td>
            </tr>
            <tr>
                <th>Customer Name</th>
                <td>{{ $general_voice_audit->customer_name ?? '' }}</td>
            </tr>
            <tr>
                <th>Customer Phone</th>
                <td>{{ $general_voice_audit->customer_phone ?? '' }}</td>
            </tr>
            <tr>
                <th>Rec. Duration</th>
                <td>{{ $general_voice_audit->recording_duration ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Notes</strong><br>
                    {{ $general_voice_audit->notes ?? '' }}
                </td>
            </tr>
        </table>
    </div>
</div>
