@extends('layouts.app')
@section('title', 'Evaluators Report')
@section('content')
    <div class="search-area">
        <div class="d-flex justify-content-end mb-3">
            <div class="button-area">
                <button type="button" id="btn-search" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Search
                </button>
            </div>
        </div>
        <form action="{{ route('reports.evaluators', ['type' => 'evaluators']) }}" method="get" autocomplete="off"
            id="search"
            @if (isset($_GET['search'])) style="display: @if (@$_GET)block;@else none; @endif"
            @endif>
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
                    if (!empty($_GET['client_outcome'])) {
                        $outcome = $_GET['client_outcome'];
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
                                                @if ($evaluator->hrms_id == @$_GET['user_id']) selected @endif>
                                                {{ $evaluator->hrms_id }} - {{ $evaluator->name }} -
                                                {{ $evaluator->campaign->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="type" value="evaluators">
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
                                    <input type="hidden" name="type" value="evaluators">
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
                                    <label for="">From Date</label>
                                    <input type="date" class="form-control " name="from_date"
                                        value="{{ $from_date }}" />
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label for="">To Date</label>
                                    <input type="date" class="form-control " name="to_date"
                                        value="{{ $to_date }}" />
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control">Search</button>
                                    <a href="{{ route('reports.evaluators', ['type' => 'evaluators']) }}"
                                        class="ml-5">Clear
                                        Search</a>
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
                        {{-- export button --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">HRMS ID</th>
                                    <th class="text-center">Evaluator Name</th>
                                    <th class="text-center">Campaigns Evaluated</th>
                                    <th class="text-center">Projects Evaluated</th>
                                    <th class="text-center">Total Evaluations</th>
                                    <th class="text-center">Accepted</th>
                                    <th class="text-center">Rejected</th>
                                    <th class="text-center">QA Percentage</th>
                                    <th class="text-center">Overall QA Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evaluatorReports as $key => $item)
                                    <tr>
                                        <td class="text-center">{{ $evaluatorReports->firstItem() + $key }}</td>
                                        <td class="text-center">{{ $item->evaluator->hrms_id }}</td>
                                        <td class="text-center">{{ $item->evaluator->name }}</td>
                                        <td class="text-center">{{ $item->campaign->name }}</td>
                                        <td class="text-center"><?php
                                        foreach ($item->projects as $value) {
                                            echo $value->name . '<br>';
                                        }
                                        ?></td>
                                        <td class="text-center"><?php
                                        foreach ($item->projects as $value) {
                                            echo $value->Accepted + $value->Rejected . '<br>';
                                        }
                                        ?></td>
                                        <td class="text-center"><?php
                                        foreach ($item->projects as $value) {
                                            echo $value->Accepted . '<br>';
                                        }
                                        ?></td>
                                        <td class="text-center"><?php
                                        foreach ($item->projects as $value) {
                                            echo $value->Rejected . '<br>';
                                        }
                                        ?></td>
                                        <td class="text-center"><?php
                                        foreach ($item->projects as $value) {
                                            echo round($value->Percentage) . '<br>';
                                        }
                                        ?></td>
                                        <td class="text-center">{{ round($item->score) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $evaluatorReports->appends(request()->input())->links('vendor.pagination.default') }}
                    <small>Showing {{ $evaluatorReports->firstItem() }} to {{ $evaluatorReports->lastItem() }} of
                        {{ $evaluatorReports->total() }}
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
