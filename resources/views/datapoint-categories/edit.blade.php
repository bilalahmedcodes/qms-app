@extends('layouts.app')

@section('title', 'Edit Datapoint Category')
@section('content')

    <div class="back-area mb-3">
        <a href="{{ route('datapoint-categories.index') }}" class="btn btn-secondary btn-sm"><i
                class="fas fa-arrow-left mr-2"></i> Go Back</a>
    </div>

    <!-- Default box -->
    <div class="card">
        <form action="{{ route('datapoint-categories.update', $datapoint_category) }}" method="post" autocomplete="off">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="form-group">
                    <label for="">Select Campaigns</label>
                    <select name="campaign_id" id="campaigns" class="form-control select2">
                        <option value="">Select Option</option>
                        @foreach ($campaigns as $campaign)
                            <option value="{{ $campaign->id }}"@if ($campaign->id == $datapoint_category->campaign_id) selected @endif>
                                {{ $campaign->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('campaign_id')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="">Select Project</label>
                    <select name="project_id" id="projects" class="form-control select2">
                        <option value="">Select Option</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"@if ($project->id == $datapoint_category->project_id) selected @endif>
                                {{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('project_id')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">Datapoint Category Name <span>*</span></label>
                    <input type="text" class="form-control" name="name"
                        value="{{ old('name', $datapoint_category->name) }}" placeholder="Enter Datapoint Category Name"
                        required>
                </div>
                @error('name')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="exampleInputPassword1">Select Status</label>
                    <select name="status" class="form-control select2" required>
                        <option value="active" @if ($datapoint_category->status == 'active') selected @endif>Active</option>
                        <option value="disable" @if ($datapoint_category->status == 'disable') selected @endif>Disable</option>
                    </select>
                </div>
                @error('status')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!-- /.card-footer-->

        </form>
    </div>
    <!-- /.card -->

@endsection
