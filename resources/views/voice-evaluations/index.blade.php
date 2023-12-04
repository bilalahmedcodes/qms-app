@extends('layouts.app')
@section('title', 'Voice Evaluations List')
@section('content')
    <div class="search-area">
        <div class="d-flex justify-content-end mb-3">
            <div class="button-area">
                <button type="button" id="btn-search" class="btn btn-primary"><i class="fas fa-filter"></i> Search</button>
            </div>
        </div>
        <form action="{{ route('voice-evaluations.index') }}" method="get" autocomplete="off" id="search"
            @if (isset($_GET['search'])) style="display: block;" @endif>
            <input type="hidden" name="search" value="1">
            @php
                $associate_id = -1;
                $campaign_id = -1;
                $project_id = -1;
                $customer_phone = '';
                $outcome = '';
                $status = '';
                $from_date = '';
                $to_date = '';

                if (isset($_GET['search'])) {
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
                                    <input type="date" class="form-control " name="from_date"
                                        value="{{ $from_date }}" />
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label for="">To Date</label>
                                    <input type="date" class="form-control " name="to_date"
                                        value="{{ $to_date }}" />
                                </div>
                                <div class="form-group col-md-4 mb-3"></div>
                                <div class="form-group col-md-4 mb-3">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('voice-evaluations.index') }}" class="ml-5">Clear Search</a>
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
                        <a href="{{ route('exports.general-evaluations') }}?&associate_id={{ $associate_id }}&campaign_id={{ $campaign_id }}&project_id={{ $project_id }}&agent_outcome={{ $outcome }}&customer_phone={{ $customer_phone }}&from_date={{ $from_date }}&to_date={{ $to_date }}"
                            class="btn btn-success waves-effect waves-light">Export</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-dark">#</th>
                                    <th class="text-dark">Evaluation Date</th>
                                    <th class="text-dark">Call Date</th>
                                    <th class="text-dark">HRMS ID</th>
                                    <th class="text-dark">Associate</th>
                                    <th class="text-dark">Team Lead</th>
                                    <th class="text-dark">Campaign</th>
                                    <th class="text-dark">Project</th>
                                    <th class="text-dark">Result</th>
                                    <th class="text-dark">Outcome</th>
                                    <th class="text-dark">Customer Name</th>
                                    <th class="text-dark">Customer Phone</th>
                                    <th class="text-dark">Recording Link</th>
                                    <th class="text-dark">Status</th>
                                    <th class="text-dark">Notes</th>
                                    {{-- <th class="text-dark">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($voice_evaluations) > 0)
                                    @foreach ($voice_evaluations as $key => $evaluation)
                                        <tr>
                                            <td>{{ $voice_evaluations->firstItem() + $key }}</td>
                                            <td>{{ $evaluation->created_at->format('m-d-Y g:i:s A') }}</td>
                                            <td>{{ $evaluation->call_date }}</td>
                                            <td>{{ $evaluation->associate_id ?? 0 }}</td>
                                            <td>{{ $evaluation->associate->name ?? '' }}</td>
                                            <td>{{ $evaluation->teamLead->name ?? '' }}</td>
                                            <td>{{ $evaluation->campaign->name ?? '' }}</td>
                                            <td>{{ $evaluation->project->name ?? '' }}</td>
                                            <td>{{ $evaluation->percentage ?? 0 }}</td>
                                            <td>
                                                @if ($evaluation->agent_outcome == 'accepted')
                                                    <span class="badge bg-success">Accepted</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $evaluation->customer_name ?? 0 }}</td>
                                            <td>{{ $evaluation->customer_phone ?? 0 }}</td>
                                            <td>{{ $evaluation->recording_link ?? '' }}</td>
                                            <td>@include('includes.status', ['status' => $evaluation->status])</td>
                                            <td>{{ $evaluation->notes ?? '' }}</td>
                                            {{-- <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('voice-evaluations.show', $evaluation) }}"
                                                        class="btn btn-success btn-sm me-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td> --}}
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
                    @if ($voice_evaluations->total() > 10)
                        {{ $voice_evaluations->appends(request()->input())->links('vendor.pagination.default') }}
                    @endif
                    <small>Showing {{ $voice_evaluations->firstItem() }} to {{ $voice_evaluations->lastItem() }} of
                        {{ $voice_evaluations->total() }}
                        entries</small>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#btn-search").click(function() {
                $("#search").toggle();
            });
        });
    </script>
@endsection
