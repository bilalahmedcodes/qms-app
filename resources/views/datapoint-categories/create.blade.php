@extends('layouts.app')

@section('title', 'Create Datapoint Categories')


@section('content')

    <div class="back-area mb-3">
        <a href="{{ route('datapoint-categories.index') }}" class="btn btn-secondary btn-sm"><i
                class="fas fa-arrow-left mr-2"></i> Go
            Back</a>
    </div>
    <!-- Default box -->
    <div class="card">
        <form action="{{ route('datapoint-categories.store') }}" method="post" autocomplete="off">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="">Select Campaign <span>*</span></label>
                    <select name="campaign_id" id="campaigns" class="form-control select2">
                        <option value="">Select Option</option>
                        @foreach ($campaigns as $campaign)
                            <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                @error('campaign_id')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="">Select Project <span>*</span></label>
                    <select name="project_id" class="form-control select2">
                        <option value="">Select Option</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                @error('project_id')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">Name <span>*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                        placeholder="Enter Name">
                </div>
                <br>
                @error('name')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="">Select Status <span>*</span></label>
                    <select name="status" class="form-control select2">
                        <option value="active">Active</option>
                        <option value="disable">Disable</option>
                    </select>
                </div>
                <br>
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
