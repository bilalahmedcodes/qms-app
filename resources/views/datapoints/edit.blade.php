@extends('layouts.app')

@section('title', 'Edit Datapoints')

@section('content')
    <div class="back-area mb-3">
        <a href="{{ route('datapoint-categories.index') }}" class="btn btn-secondary btn-sm"><i
                class="fas fa-arrow-left mr-2"></i> Go Back</a>
    </div>
    <!-- Default box -->
    <div class="card">
        <form action="{{ route('datapoints.update',$datapoint) }}" method="post" autocomplete="off">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Category <span>*</span></label>
                    <select name="datapoint_category_id" class="form-control select2" required>
                        <option value="{{ $datapoint->category->id ?? '' }}">{{ $datapoint->category->name ?? '' }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Campaign <span>*</span></label>
                    <select name="campaign_id" class="form-control select2" id="campaign_list">
                        <option value="{{ $datapoint->category->campaign->id }}">{{ $datapoint->category->campaign->name }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Project <span>*</span></label>
                    <select name="project_id" class="form-control select2">
                        <option value="{{ $datapoint->category->project->id ?? '' }}">
                            {{ $datapoint->category->project->name ?? '' }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Data Point Name <span>*</span></label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Data Point Name"
                        value="{{ $datapoint->name }}" required>
                </div>
                @error('name')
                    <div class="validate-error">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="exampleInputEmail1">Question</label>
                    <input type="text" class="form-control" name="question" placeholder="Enter Question"
                        value="{{ $datapoint->question }}">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="elm1" name="description">{{ $datapoint->description ?? '' }}</textarea>
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
