@extends('layouts.app')
@section('title', 'Create General Audit')
@section('content')
    <div class="back-area mb-3">
        <a href="{{ route('general-voice-audits.index') }}" class="btn btn-secondary btn-sm"><i
                class="fas fa-arrow-left mr-2"></i> Go
            Back</a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('general-voice-audits.store') }}" method="POST" id="general-audits">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Step 1 - Agent Details</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Associate</label>
                                    <input type="text" class="form-control"
                                        value="{{ $associate->hrms_id }} - {{ $associate->name }}" disabled>
                                    <input type="hidden" class="form-control" name="associate_id"
                                        value="{{ $associate->hrms_id }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Team Lead</label>
                                    <input type="text" class="form-control" value="{{ $team_lead->name }}" disabled>
                                    <input type="hidden" class="form-control" name="team_lead_id"
                                        value="{{ $team_lead->hrms_id }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Manager</label>
                                    <input type="text" class="form-control" value="{{ $manager->name }}" disabled>
                                    <input type="hidden" class="form-control" name="manager_id"
                                        value="{{ $manager->hrms_id }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Campaign</label>
                                    <input type="text" class="form-control" id="campaign-name"
                                        value="{{ $campaign->name }}" disabled>
                                    <input type="hidden" class="form-control" name="campaign_id"
                                        value="{{ $campaign->id }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Project</label>
                                    <input type="text" class="form-control" id="project-name"
                                        value="{{ $project->name }}" disabled>
                                    <input type="hidden" class="form-control" name="project_id"
                                        value="{{ $project->id }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Call Date</label><span style="color: red;">*</span>
                                    <input type="date" name="call_date" class="form-control" id="call_date">
                                </div>
                                @error('call_date')
                                    <div class="validate-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Step 2 - Datapoints</h4>
                        <div class="row">
                            @php
                                $totalScore = 0;
                            @endphp
                            @if (count($categories) > 0)
                                @foreach ($categories as $category)
                                    <div class="d-flex justify-content-start">
                                        <h3>{{ $category->name }}</h3>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <small style="font-size: 10px;">({{ $category->project->name ?? '' }} -
                                            {{ $category->campaign->name ?? '' }}) </small>
                                    </div>
                                    <table class="table table-striped table-hover">
                                        @if (count($category->datapoints) > 0)
                                            @foreach ($category->datapoints as $datapoint)
                                                <tr>
                                                    <td class="w-25">{{ $datapoint->name }}</td>
                                                    <td class="w-50">
                                                        {{ $datapoint->question }} <br>
                                                        <small>{!! $datapoint->description !!}</small>
                                                    </td>
                                                    @foreach ($datapoint->customFields as $customField)
                                                        @php
                                                            if ($customField->values == 100) {
                                                                $totalScore = $totalScore + $customField->values;
                                                            }
                                                        @endphp
                                                        <td class="radios">
                                                            @if ($customField->type == 'radio')
                                                                <div class="form-check-right form-check-inline qrating">
                                                                    <input type="radio"
                                                                        id="datapoint_id-{{ $customField->id }}"
                                                                        name="datapoint_id-{{ $customField->datapoint_id }}"
                                                                        class="form-check-input"
                                                                        value="{{ $customField->values }}"
                                                                        data-id="{{ @$datapoint->customFields[0]->values }}"
                                                                        onclick="setCustomFieldId({{ $customField->id }},{{ $datapoint->id }},{{ $customField->values }})"
                                                                        @if ($customField->label == 'Yes') checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="">{{ $customField->label }}
                                                                        <small>{{ $customField->values }}</small>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    <input id="custom_field_id-{{ $datapoint->id }}" class="hid"
                                                        type="hidden" name="custom_field_id-{{ $datapoint->id }}"
                                                        value="{{ @$datapoint->customFields[0]->id }}">
                                                </tr>
                                            @endforeach
                                        @else
                                            <td>No data points found!</td>
                                        @endif
                                    </table>
                                @endforeach
                            @else
                                <td class="text-center">No records found</td>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Step 3 - Evaluation Details</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Percentage</label>
                                    <input type="number" name="percentage" id="percentage"
                                        class="form-control percentage" value="100" readonly>
                                </div>
                                @error('percentage')
                                    <div class="validate-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label><span style="color: red;">*</span>
                                    <input type="text" name="customer_name" class="form-control" id="customer_name">
                                </div>
                                @error('customer_name')
                                    <div class="validate-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Customer Phone</label><span style="color: red;">*</span>
                                    <input type="text" name="customer_phone" class="form-control"
                                        id="customer_phone">
                                </div>
                                @error('customer_phone')
                                    <div class="validate-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Recording Duration</label><span style="color: red;">*</span>
                                    <input type="text" name="recording_duration" placeholder="HH:MM:SS"
                                        id="recording_duration" class="form-control">
                                </div>
                                @error('recording_duration')
                                    <div class="validate-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Recording Link</label><span style="color: red;">*</span>
                                    <input type="text" name="recording_link" class="form-control"
                                        id="recording_link">
                                </div>
                                @error('recording_link')
                                    <div class="validate-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Outcome</label><span style="color: red;">*</span>
                                    <select name="agent_outcome" class="form-control select2" id="agent_outcome">
                                        <option value="">Select Option</option>
                                        <option value="accepted">Accepted</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                                @error('agent_outcome')
                                    <div class="validate-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Call Type</label><span style="color: red;">*</span>
                                    <select name="call_type" class="form-control select2" id="call_type">
                                        <option value="">Select Option</option>
                                        <option value="general">General</option>
                                        <option value="sales">Sales</option>
                                    </select>
                                </div>
                                @error('call_type')
                                    <div class="validate-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Notes</label><span style="color: red;">*</span>
                                    <textarea name="notes" rows="3" class="form-control" id="notes"></textarea>
                                </div>
                                @error('notes')
                                    <div class="validate-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Send Critical Alert / Fatal</label>
                                <div class="mb-3">
                                    <input type="checkbox" id="review_priority" switch="default" name="critical_alert"
                                        value="1" />
                                    <label class="form-label" for="review_priority" id="review_priority_label"
                                        data-on-label="1" data-off-label="0"></label>
                                </div>
                            </div>
                        </div>
                        <div class="timer-area" style="float: right;">
                            <div class="timer" id="timer" style="font-size: 18px;"></div>
                            <input type="hidden" name="evaluation_time" class="timer" id="evaluation_time">
                        </div>
                        <button class="btn btn-primary" type="submit" id="submitBtn"
                            disabled='disabled'>Submit</button>
                    </div>
                </div>
            </form>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            let campaign = document.getElementById('campaign-name').value;
            // console.log(campaign);
            let project = document.getElementById('project-name').value;
            // calculation of total score for DSS of the radio buttons that are checked by default
            let totalDSSScore = 0;
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radioButton => {
                if (radioButton.checked) {
                    let value = parseInt(radioButton.value);
                    totalDSSScore += value;
                }
            });
            // score calculation on radio button selection
            $('.qrating').change(function() {
                let total = 0;
                let countForFatal = 0;
                let percentage = 0;
                let naCount = 0;
                $("input[type='radio']:checked").each(function() {

                    if (campaign == 'DSS') {
                        if (parseInt(this.value) == -1) {
                            naCount = naCount + 1;
                        }
                        percentage += parseInt(this.value);
                    }
                    total = parseInt(total) + parseInt(this.value)
                    if (this.value < 0) {
                        total = parseInt(total) + parseInt($(this).attr("data-id"));
                    }
                    if (parseInt(this.value) == -50) {
                        countForFatal++;
                        document.getElementById('review_priority').checked = true;
                    } else if (countForFatal == 0) {
                        document.getElementById('review_priority').checked = false;
                    }
                })
                if (campaign == 'DSS') {
                    total = ((percentage + naCount) / totalDSSScore) * 100;
                    $("#percentage").val(Math.round(total));
                }
                if (total < 0) {
                    $("#percentage").val(0);
                } else {
                    $("#percentage").val(total);
                }
            });

            // $('input[type=radio]').change(function() {
            //     total = 0;
            //     total_no = 0;
            //     $('input[type=radio]:checked').each(function() {
            //         if (this.value == 0) {
            //             total_no++;
            //         }
            //         total++;
            //     })
            //     total_yes = total - total_no;
            //     percentage = (total_yes / total) * 100;
            //     $("#percentage").val(percentage);

            // });
        });
        // Function to check if all required fields have values
        function checkRequiredFields() {
            // Get the values of the required fields
            let callDate = $('#call_date').val();
            let customerName = $('#customer_name').val();
            let customerPhone = $('#customer_phone').val();
            let recordingDuration = $('#recording_duration').val();
            let recordingLink = $('#recording_link').val();
            let agentOutcome = $('#agent_outcome').val();
            let callType = $('#call_type').val();
            let notes = $('#notes').val();
            // Add more fields as needed
            // Enable or disable the submit button based on the values
            if (callDate !== '' && customerName !== '' && customerPhone !== '' && recordingDuration !== '' &&
                recordingLink !== '' && agentOutcome !== '' && callType !== '' && notes !== '') {
                $('#submitBtn').prop('disabled', false);
            } else {
                // $('#call_date').
                // $('#customer_name').
                // $('#customer_phone').
                // $('#recording_duration').
                // $('#recording_link').
                // $('#agent_outcome').
                // $('#call_type').
                // $('#notes').
                $('#submitBtn').prop('disabled', true);
            }
        }
        // Add event listeners to the required fields
        $('#call_date').on('input', function() {
            checkRequiredFields();
        });
        $('#customer_name').on('input', function() {
            checkRequiredFields();
        });
        $('#customer_phone').on('input', function() {
            checkRequiredFields();
        });
        $('#recording_duration').on('input', function() {
            checkRequiredFields();
        });
        $('#recording_link').on('input', function() {
            checkRequiredFields();
        });
        $('#agent_outcome').on('input', function() {
            checkRequiredFields();
        });
        $('#call_type').on('input', function() {
            checkRequiredFields();
        });
        $('#notes').on('input', function() {
            checkRequiredFields();
        });
        $(function() {
            //start a timer
            let timer = $('.timer');
            timer.timer({
                format: '%H:%M:%S'
            });
            let recordingDurationInput = document.getElementById('recording_duration');
            let cleave = new Cleave(recordingDurationInput, {
                time: true,
                timePattern: ['h', 'm', 's']
            });
            $("input[name='customer_phone']").on('input', function(e) {
                let inputValue = $(this).val().replace(/[^0-9]/g, ''); // Remove non-digit characters
                let maxLength = 15;
                let minLength = 5;

                // Limit the input length
                if (inputValue.length > maxLength) {
                    inputValue = inputValue.slice(0, maxLength);
                }

                // Update the input value with the sanitized value
                $(this).val(inputValue);
            });
        });

        function setCustomFieldId(custom_field_id, datapoint_id) {
            document.getElementById('custom_field_id-' + datapoint_id).value = custom_field_id;
        }
    </script>
@endsection
