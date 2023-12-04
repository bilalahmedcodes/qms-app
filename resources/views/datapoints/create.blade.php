@extends('layouts.app')

@section('title', 'Create Datapoints')

@section('content')
    <div class="back-area mb-3">
        <a href="{{ route('datapoint-categories.index') }}" class="btn btn-secondary btn-sm"><i
                class="fas fa-arrow-left mr-2"></i> Go Back</a>
    </div>
    <!-- Default box -->
    <div class="card">
        <form action="{{ route('datapoints.store') }}" method="post" autocomplete="off">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Category <span>*</span></label>
                    <select name="datapoint_category_id" class="form-control select2" required>
                        <option value="{{ $datapoint_category->id }}">{{ $datapoint_category->name }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Campaign <span>*</span></label>
                    <select name="campaign_id" class="form-control select2">
                        <option value="{{ $datapoint_category->campaign->id }}">{{ $datapoint_category->campaign->name }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Project <span>*</span></label>
                    <select name="project_id" class="form-control select2">
                        <option value="{{ $datapoint_category->project->id ?? '' }}">
                            {{ $datapoint_category->project->name ?? 'No Project' }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Data Point Name <span>*</span></label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Data Point Name" required>
                </div>
                @error('name')
                    <div class="validate-error">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="exampleInputEmail1">Question</label>
                    <input type="text" class="form-control" name="question" placeholder="Enter Question">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="elm1" name="description"></textarea>
                </div>
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
