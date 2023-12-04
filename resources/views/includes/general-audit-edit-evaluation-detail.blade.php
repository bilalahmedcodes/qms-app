<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Percentage</label>
            <input type="number" name="percentage" id="percentage" class="form-control percentage"
                value="{{ round($general_voice_audit->percentage) }}" readonly>
        </div>
        @error('percentage')
            <div class="validate-error">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control"
                value="{{ $general_voice_audit->customer_name }}" id="customer_name">
        </div>
        @error('customer_name')
            <div class="validate-error">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Customer Phone</label>
            <input type="text" name="customer_phone" value="{{ $general_voice_audit->customer_phone }}"
                class="form-control" id="customer_phone">
        </div>
        @error('customer_phone')
            <div class="validate-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Recording Duration</label>
            <input type="text" name="recording_duration" placeholder="HH:MM:SS" id="recording_duration"
                class="form-control" value="{{ $general_voice_audit->recording_duration }}">
        </div>
        @error('recording_duration')
            <div class="validate-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Recording Link</label>
            <input type="text" name="recording_link" class="form-control" id="recording_link"
                value="{{ $general_voice_audit->recording_link }}">
        </div>
        @error('recording_link')
            <div class="validate-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Outcome</label>
            <select name="agent_outcome" class="form-control select2" id="agent_outcome">
                <option value="">Select Option</option>
                <option value="accepted" @if ($general_voice_audit->agent_outcome == 'accepted') selected @endif>Accepted</option>
                <option value="rejected" @if ($general_voice_audit->agent_outcome == 'rejected') selected @endif>Rejected</option>
            </select>
        </div>
        @error('agent_outcome')
            <div class="validate-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Call Type</label>
            <select name="call_type" class="form-control select2" id="call_type">
                <option value="">Select Option</option>
                <option value="general" @if ($general_voice_audit->call_type == 'general') selected @endif>General</option>
                <option value="sales" @if ($general_voice_audit->call_type == 'sales') selected @endif>Sales</option>
            </select>
        </div>
        @error('call_type')
            <div class="validate-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" rows="3" class="form-control" id="notes">{{ $general_voice_audit->notes }}</textarea>
        </div>
        @error('notes')
            <div class="validate-error">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label">Send Critical Alert / Fatal</label>
        <div class="mb-3">
            <input type="checkbox" id="review_priority" switch="default" name="critical_alert" value="1"
                @if ($general_voice_audit->critical_alert == '1') checked @endif />
            <label class="form-label" for="review_priority" data-on-label="1" data-off-label="0"></label>
        </div>
    </div>
    
</div>
