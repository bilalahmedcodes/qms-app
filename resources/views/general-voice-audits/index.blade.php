@extends('layouts.app')
@section('title', 'General Audits List')
@section('content')
    <div class="search-area">
        <div class="d-flex justify-content-end mb-3">
            <div class="button-area">
                <button type="button" id="btn-search" class="btn btn-primary"><i class="fas fa-filter"></i> Search</button>
            </div>
        </div>
        <form action="{{ route('general-voice-audits.index') }}" method="get" autocomplete="off" id="search"
            @if (isset($_GET['search'])) style="display: block;" @endif>
            <input type="hidden" name="search" value="1">
            @php
                $record_id = '';
                $evaluator_id = -1;
                $associate_id = -1;
                $campaign_id = -1;
                $project_id = -1;
                $customer_phone = '';
                $outcome = '';
                $status = '';
                $from_date = '';
                $to_date = '';

                if (isset($_GET['search'])) {
                    if (!empty($_GET['user_id'])) {
                        $evaluator_id = $_GET['user_id'];
                    }
                    if (!empty($_GET['associate_id'])) {
                        $associate_id = $_GET['associate_id'];
                    }
                    if (!empty($_GET['campaign_id'])) {
                        $campaign_id = $_GET['campaign_id'];
                    }
                    if (!empty($_GET['project_id'])) {
                        $project_id = $_GET['project_id'];
                    }
                    if (!empty($_GET['record_id'])) {
                        $record_id = $_GET['record_id'];
                    }
                    if (!empty($_GET['customer_phone'])) {
                        $customer_phone = $_GET['customer_phone'];
                    }
                    if (!empty($_GET['agent_outcome'])) {
                        $outcome = $_GET['agent_outcome'];
                    }
                    if (!empty($_GET['status'])) {
                        $status = $_GET['status'];
                    }
                    if (!empty($_GET['from_date'])) {
                        $from_date = $_GET['from_date'];
                    }
                    if (!empty($_GET['to_date'])) {
                        $to_date = $_GET['to_date'];
                    }
                }
            @endphp
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4 mb-3">
                                    <label for="">Select Evaluator</label>
                                    <select name="user_id" class="form-control select2" style="width: 100%;">
                                        <option value="-1">Select Option</option>
                                        @foreach ($evaluators as $evaluator)
                                            <option value="{{ $evaluator->hrms_id }}"
                                                @if ($evaluator->hrms_id == $evaluator_id) selected @endif>
                                                {{ $evaluator->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="">Select Associate</label>
                                    <select name="associate_id" class="form-control select2" style="width: 100%;">
                                        <option value="-1">Select Option</option>
                                        @foreach ($associates as $associate)
                                            <option value="{{ $associate->hrms_id }}"
                                                @if ($associate->hrms_id == $associate_id) selected @endif>
                                                {{ $associate->hrms_id }} - {{ $associate->name }} -
                                                {{ $associate->campaign->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="">Select Campaign</label>
                                    <select name="campaign_id" class="form-control select2" style="width: 100%;">
                                        <option value="-1">Select Option</option>
                                        @foreach ($campaigns as $campaign)
                                            <option value="{{ $campaign->id }}"
                                                @if ($campaign->id == $campaign_id) selected @endif>
                                                {{ $campaign->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="">Select Project</label>
                                    <select name="project_id" class="form-control select2" style="width: 100%;">
                                        <option value="-1">Select Option</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                @if ($project->id == $project_id) selected @endif>
                                                {{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="">Select Outcome</label>
                                    <select name="agent_outcome" class="form-control select2" style="width: 100%;">
                                        <option value="">Select</option>
                                        <option value="accepted" @if ($outcome == 'accepted') selected @endif>
                                            Accepted
                                        </option>
                                        <option value="rejected" @if ($outcome == 'rejected') selected @endif>
                                            Rejected
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="">Customer Phone</label>
                                    <input type="text" class="form-control" name="customer_phone"
                                        value="{{ $customer_phone }}" />
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="">From Date</label>
                                    <input type="datetime-local" class="form-control " name="from_date"
                                        value="{{ $from_date }}" />
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label for="">To Date</label>
                                    <input type="datetime-local" class="form-control " name="to_date"
                                        value="{{ $to_date }}" />
                                </div>
                                <div class="form-group col-md-4 mb-3"></div>
                                <div class="form-group col-md-4 mb-3">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('general-voice-audits.index') }}" class="ml-5">Clear Search</a>
                                </div>

                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
        </form>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('exports.general-voice-audits') }}?&user_id={{ $evaluator_id }}&associate_id={{ $associate_id }}&campaign_id={{ $campaign_id }}&project_id={{ $project_id }}&agent_outcome={{ $outcome }}&customer_phone={{ $customer_phone }}&from_date={{ $from_date }}&to_date={{ $to_date }}"
                            class="btn btn-success waves-effect waves-light" style="right: 5px;">Export</a>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#myModal">Start Audit</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>@sortablelink('created_at', 'Evaluation Date')</th>
                                    <th>@sortablelink('user_id', 'Evaluator')</th>
                                    <th>@sortablelink('associate_id', 'HRMS ID')</th>
                                    <th>@sortablelink('associate_id', 'Associate')</th>
                                    <th>@sortablelink('team_lead_id', 'Team Lead')</th>
                                    <th>@sortablelink('campaign_id', 'Campaign')</th>
                                    <th>@sortablelink('project_id', 'Project')</th>
                                    <th>@sortablelink('percentage', 'Result')</th>
                                    <th>Outcome</th>
                                    <th>@sortablelink('customer_phone', 'Customer Phone')</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    @if (Auth::user()->roles[0]->name == 'Super Admin')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($general_voice_audits) > 0)
                                    @foreach ($general_voice_audits as $key => $general_voice_audit)
                                        <tr>
                                            <td>{{ $general_voice_audits->firstItem() + $key }}</td>
                                            <td>{{ $general_voice_audit->created_at->format('m-d-Y g:i:s A') }}</td>
                                            <td>{{ $general_voice_audit->evaluator->name ?? '' }}</td>
                                            <td>{{ $general_voice_audit->associate_id ?? 0 }}</td>
                                            <td>{{ $general_voice_audit->associate->name ?? '' }}</td>
                                            <td>{{ $general_voice_audit->teamLead->name ?? '' }}</td>
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
                                            <td>{{ $general_voice_audit->customer_phone ?? 0 }}</td>
                                            <td>@include('includes.status', [
                                                'status' => $general_voice_audit->status,
                                            ])</td>
                                            <td>{{ $general_voice_audit->notes ?? '' }}</td>
                                            @if (in_array(Auth::user()->roles[0]->name, ['Super Admin', 'Admin']) ||
                                                    (in_array(Auth::user()->roles[0]->name, ['Super Admin', 'Admin']) && Auth::user()->campaign_id == 11) ||
                                                    Auth::user()->hrms_id == 695957)
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('general-voice-audits.show', $general_voice_audit) }}"
                                                            class="btn btn-success btn-sm me-2">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('general-voice-audits.edit', $general_voice_audit) }}"
                                                            class="btn btn-primary btn-sm me-2">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if (in_array(Auth::user()->roles[0]->name, ['Super Admin']))
                                                            <form
                                                                action="{{ route('general-voice-audits.destroy', $general_voice_audit) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="15" class="text-center">No record found!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($general_voice_audits->total() > 10)
                        {{ $general_voice_audits->appends(request()->input())->links('vendor.pagination.default') }}
                    @endif
                    <small>Showing {{ $general_voice_audits->firstItem() }} to {{ $general_voice_audits->lastItem() }} of
                        {{ $general_voice_audits->total() }}
                        entries</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4 col-xl-3">
        <!-- sample modal content -->
        <div id="myModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Start Audit
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('general-voice-audits.create') }}" method="get" autocapitalize="off">
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="">Select Associate <span>*</span></label>
                                    <select name="associate_id" id="associate" class="form-control select2"
                                        style="width: 100%" required>
                                        <option value="">Select Option</option>
                                        @foreach ($associates as $associate)
                                            <option value="{{ $associate->hrms_id }}">{{ $associate->hrms_id ?? 0 }} -
                                                {{ $associate->name }} - {{ $associate->campaign->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="campaign_id" id="campaign">
                                <div class="form-group mb-3">
                                    <label for="">Select Project</label>
                                    <select name="project_id" id="projects" class="form-control select2"
                                        style="width: 100%" required>
                                        <option value="">Select Option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Start Audit</button>
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#btn-search").click(function() {
                $("#search").toggle();
            });
            $('#myModal').on('hidden.bs.modal', function() {
                $("#associate").val('').trigger('change');
                $("#campaign").val('');
                $("#projects").val('').trigger('change');
            });
            $("#associate").select2({
                dropdownParent: $("#myModal")
            });
            $("#projects").select2({
                dropdownParent: $("#myModal")
            });
            $('#associate').change(function() {
                let user_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: `{{ route('main') }}/get-user-detail/${user_id}`,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $("#campaign").val(response.campaign_id); // Set the campaign_id value

                        let projects = response.project_ids;
                        let projectsSelect = $("#projects");
                        projectsSelect.empty(); // Clear previous options

                        // Add "Select Option" placeholder as the initial option
                        projectsSelect.append($('<option>', {
                            value: "",
                            text: "Select Option"
                        }));

                        projects.forEach(project => {
                            projectsSelect.append($('<option>', {
                                value: project.id,
                                text: project.name
                            }));
                        });

                        // Refresh Select2 plugin for the projects select element
                        projectsSelect.trigger('change');
                    }
                });
                $("#campaign").val('');
                $("#projects").empty().append($('<option>', {
                    value: "",
                    text: "Select Option"
                }));
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
    </script>
@endsection
