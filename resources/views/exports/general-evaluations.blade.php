<table>
    <thead>
        <tr>
            <th>Evaluation Date</th>
            <th>Call Date</th>
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
        @if (count($voice_evaluations) > 0)
            @foreach ($voice_evaluations as $key => $evaluation)
                <tr>
                    <td>{{ $evaluation->created_at->format('m-d-Y g:i:s A') }}</td>
                    <td>{{ $evaluation->call_date }}</td>
                    <td>{{ $evaluation->associate_id ?? 0 }}</td>
                    <td>{{ $evaluation->associate->name ?? '' }}</td>
                    <td>{{ $evaluation->teamLead->name ?? '' }}</td>
                    <td>{{ $evaluation->manager->name ?? '' }}</td>
                    <td>{{ $evaluation->campaign->name ?? '' }}</td>
                    <td>{{ $evaluation->project->name ?? '' }}</td>
                    <td>{{ $evaluation->percentage }}</td>
                    <td>
                        @if ($evaluation->agent_outcome == 'accepted')
                            <span class="badge bg-success">Accepted</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $evaluation->customer_name ?? '' }}</td>
                    <td>{{ $evaluation->customer_phone ?? 0 }}</td>
                    <td>{{ $evaluation->recording_link ?? '' }}</td>
                    <td>@include('includes.status', [
                        'status' => $evaluation->status,
                    ])</td>
                    <td>{{ $evaluation->notes ?? '' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="15" class="text-center">No record found!</td>
            </tr>
        @endif
    </tbody>
</table>
