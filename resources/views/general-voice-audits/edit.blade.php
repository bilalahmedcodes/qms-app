@extends('layouts.app')
@section('title', 'Edit General Audit')
@section('content')
    <div class="back-area mb-3">
        <a href="{{ route('general-voice-audits.index') }}" class="btn btn-secondary btn-sm"><i
                class="fas fa-arrow-left mr-2"></i> Go
            Back</a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('general-voice-audits.update', $general_voice_audit) }}" method="POST" id="general-audits">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Step 1 - Agent Details</h4>
                        @include('includes.general-audit-edit-agent-detail')
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Step 2 - Datapoints</h4>
                        @include('includes.general-audit-edit-datapoints')
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Step 3 - Evaluation Details</h4>
                        @include('includes.general-audit-edit-evaluation-detail')
                        {{-- <div class="timer-area" style="float: right;">
                            <div class="timer" id="timer" style="font-size: 18px;"></div>
                            <input type="hidden" name="evaluation_time" class="timer" id="evaluation_time">
                        </div> --}}
                        <button class="btn btn-primary" type="submit" id="submitBtn">Submit</button>
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
            $('.qrating').change(function() {
                let total = 0;
                let countForFatal = 0;
                $("input[type='radio']:checked").each(function() {
                    total = parseInt(total) + parseInt(this.value)
                    if (this.value < 0) {
                        total = parseInt(total) + parseInt($(this).attr("data-id"));
                    }
                })
                if (total < 0) {
                    $("#percentage").val(0);
                } else {
                    $("#percentage").val(total);
                }
            });
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
