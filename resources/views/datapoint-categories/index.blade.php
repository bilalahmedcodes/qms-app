@extends('layouts.app')

@section('title', 'Datapoint Categories and Datapoints')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('datapoint-categories.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Category
                        </a>
                    </div>
                    <br><br>
                    @if (count($categories) > 0)
                        @foreach ($categories as $category)
                            <div class="d-flex justify-content-end">
                                <div class="d-inline-flex" style="gap: 2px">
                                    <a href="{{ route('datapoints.create', $category) }}"
                                        class="btn btn-success btn-xs waves-effect waves-light">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('datapoint-categories.edit', $category) }}"
                                        class="btn btn-warning btn-xs waves-effect waves-light">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('datapoint-categories.destroy', $category) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-xs waves-effect waves-light"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start">
                                <h3>{{ $category->name }}</h3>
                            </div>
                            <div class="d-flex justify-content-start">
                                <small style="font-size: 10px;">({{ $category->project->name ?? '' }} -
                                    {{ $category->campaign->name ?? '' }})</small>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    @if (count($category->datapoints) > 0)
                                        @foreach ($category->datapoints as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->question }}</td>
                                                <td>{!! $item->description !!}</td>
                                                <td class="d-inline-flex" style="gap: 2px">
                                                    <a href="{{ route('datapoints.edit', $item) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('datapoints.destroy', $item) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('custom-fields.create', ['campaign'=>$category->campaign_id,'project'=>$category->project_id,'datapoint_category' => $item->datapoint_category_id, 'datapoint' => $item]) }}"
                                                        class="btn btn-secondary btn-sm">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </td>
                                                @foreach ($item->customFields as $item)
                                                    <td>
                                                        @if ($item->type == 'radio')
                                                            <div class="form-check mb-2">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    {{ $item->label }} <small>{{ $item->values }}</small>
                                                                </label>
                                                            </div>
                                                        @elseif($item->type == 'checkbox')
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $item->values }}" id="flexRadioDefault1">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    {{ $item->label }}
                                                                </label>
                                                            </div>
                                                        @elseif($item->type == 'dropdown')
                                                            @php
                                                                $options = explode(',', $item->options);
                                                                $values = explode(',', $item->values);
                                                            @endphp
                                                            <div class="mb-2">
                                                                <label class="form-label">{{ $item->label }}</label>
                                                                <select class="form-control select2">
                                                                    <option value="">Select Option</option>
                                                                    @foreach ($options as $index => $option)
                                                                        <option value="{{ $values[$index] }}">
                                                                            {{ $option }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="d-inline-flex" style="gap: 2px">
                                                        <a href="{{ route('custom-fields.edit', $item) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('custom-fields.destroy', $item) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @else
                                        <td>No data points found!</td>
                                    @endif
                                </table>

                            </div>
                        @endforeach
                    @else
                        <td class="text-center">No records found</td>
                    @endif
                    @if ($categories->total() > 15)
                        @if ($categories->total() > 15)
                            {{ $categories->appends(request()->input())->links('vendor.pagination.default') }}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection



@section('scripts')

    <script>
        $(function() {
            $("#btn-search").click(function(e) {
                e.preventDefault();
                $("#search").slideToggle();
            });

        });
    </script>

@endsection
