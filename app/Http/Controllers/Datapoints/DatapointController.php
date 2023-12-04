<?php

namespace App\Http\Controllers\Datapoints;

use Illuminate\Http\Request;
use App\Models\DatapointCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\DatapointRequest;
use App\Models\Datapoint;
use Illuminate\Support\Facades\Auth;

class DatapointController extends Controller
{
    public function create(DatapointCategory $datapoint_category)
    {
        return view('datapoints.create')->with(compact('datapoint_category'));
    }
    public function store(DatapointRequest $request)
    {
        Datapoint::create($request->all());
        return redirect()
            ->route('datapoint-categories.index')
            ->with('success', 'Datapoint Added successfully!');
    }
    public function edit(Datapoint $datapoint)
    {
        return view('datapoints.edit', compact('datapoint'));
    }
    public function update(DataPointRequest $request, Datapoint $datapoint)
    {
        $datapoint->update($request->all());
        return redirect()
            ->route('datapoint-categories.index')
            ->with('success', 'Datapoint updated successfully!');
    }
    public function destroy(Datapoint $datapoint)
    {
        $datapoint->delete();
        return redirect()
            ->back()
            ->with('success', 'Datapoint deleted successfully!');
    }
}
