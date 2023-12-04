<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Associate</label>
            <input type="text" class="form-control"
                value="{{ $general_voice_audit->associate->hrms_id }} - {{ $general_voice_audit->associate->name }}"
                disabled>
            <input type="hidden" class="form-control" name="associate_id"
                value="{{ $general_voice_audit->associate_id }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Team Lead</label>
            <input type="text" class="form-control" value="{{ $general_voice_audit->teamlead->name }}" disabled>
            <input type="hidden" class="form-control" name="team_lead_id"
                value="{{ $general_voice_audit->team_lead_id }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Manager</label>
            <input type="text" class="form-control" value="{{ $general_voice_audit->manager->name }}" disabled>
            <input type="hidden" class="form-control" name="manager_id" value="{{ $general_voice_audit->manager_id }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Campaign</label>
            <input type="text" class="form-control" value="{{ $general_voice_audit->campaign->name }}" disabled>
            <input type="hidden" class="form-control" name="campaign_id"
                value="{{ $general_voice_audit->campaign_id }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Project</label>
            <input type="text" class="form-control" value="{{ $general_voice_audit->project->name }}" disabled>
            <input type="hidden" class="form-control" name="project_id"
                value="{{ $general_voice_audit->project_id }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Call Date</label>
            <input type="text" class="form-control" value="{{ $general_voice_audit->call_date }}" disabled>
        </div>
        @error('call_date')
            <div class="validate-error">{{ $message }}</div>
        @enderror
    </div>
</div>
