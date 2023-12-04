@extends('layouts.app')

@section('title', 'Edit Custom Fields')

@section('content')
    <div class="back-area mb-3">
        <a href="{{ route('datapoint-categories.index') }}" class="btn btn-secondary btn-sm"><i
                class="fas fa-arrow-left mr-2"></i> Go Back</a>
    </div>
    <!-- Default box -->
    <div class="card">
        <form action="{{ route('custom-fields.update', $customField) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <input type="hidden" name="datapoint_category_id" value="{{ $customField->datapoint_category_id }}">
            <input type="hidden" name="datapoint_id" value="{{ $customField->datapoint_id }}">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Label</label>
                    <input type="text" class="form-control" name="label" value="{{ $customField->label }}"
                        placeholder="Enter Label">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Place Holder</label>
                    <input type="text" class="form-control" name="placeholder" value="{{ $customField->placeholder }}"
                        placeholder="Enter Place Holder">
                </div>
                <div class="form-group">
                    <label for="">Select Type <span>*</span></label>
                    <select name="type" class="form-control select2">
                        <option value="">Select Option</option>
                        <option value="radio" @if ($customField->type == 'radio') selected @endif>Radio</option>
                        <option value="text" @if ($customField->type == 'text') selected @endif>Text</option>
                        <option value="dropdown" @if ($customField->type == 'dropdown') selected @endif>Dropdown</option>
                        <option value="checkbox" @if ($customField->type == 'checkbox') selected @endif>Checkbox</option>
                        <option value="textarea" @if ($customField->type == 'textarea') selected @endif>Text Area</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Options</label>
                    <input type="text" class="form-control" name="options" value="{{ $customField->options }}"
                        placeholder="Enter Options">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Values</label>
                    <input type="text" class="form-control" name="values" value="{{ $customField->values }}"
                        placeholder="Enter Values">
                </div>
                <div class="form-group">
                    <label for="">Required <span>*</span></label>
                    <select name="required" class="form-control select2">
                        <option value="">Select Option</option>
                        <option value="yes" @if ($customField->required == 'yes') selected @endif>Yes</option>
                        <option value="no" @if ($customField->required == 'no') selected @endif>No</option>
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
