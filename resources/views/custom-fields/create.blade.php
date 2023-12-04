@extends('layouts.app')

@section('title', 'Create Custom Fields')

@section('content')
    <div class="back-area mb-3">
        <a href="{{ route('datapoint-categories.index') }}" class="btn btn-secondary btn-sm"><i
                class="fas fa-arrow-left mr-2"></i> Go Back</a>
    </div>
    <!-- Default box -->
    <div class="card">
        <form action="{{ route('custom-fields.store') }}" method="post" autocomplete="off">
            @csrf
            <input type="hidden" name="datapoint_category_id" value="{{ $datapoint_category->id }}">
            <input type="hidden" name="datapoint_id" value="{{ $datapoint->id }}">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Label</label>
                    <input type="text" class="form-control" name="label" placeholder="Enter Label">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Place Holder</label>
                    <input type="text" class="form-control" name="placeholder" placeholder="Enter Place Holder">
                </div>
                <div class="form-group">
                    <label for="">Select Type <span>*</span></label>
                    <select name="type" class="form-control select2">
                        <option value="radio">Radio</option>
                        <option value="text">Text</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="textarea">Text Area</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Options</label>
                    <input type="text" class="form-control" name="options" placeholder="Enter Options">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Values</label>
                    <input type="text" class="form-control" name="values" placeholder="Enter Values">
                </div>
                <div class="form-group">
                    <label for="">Required <span>*</span></label>
                    <select name="required" class="form-control select2">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
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
