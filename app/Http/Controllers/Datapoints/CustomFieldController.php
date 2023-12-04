<?php

namespace App\Http\Controllers\Datapoints;

use App\Models\Project;
use App\Models\Campaign;
use App\Models\Datapoint;
use App\Models\CustomField;
use Illuminate\Http\Request;
use App\Models\DatapointCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomFieldRequest;

class CustomFieldController extends Controller
{
    public function create(DatapointCategory $datapoint_category, Datapoint $datapoint)
    {
        return view('custom-fields.create', compact('datapoint_category', 'datapoint'));
    }
    public function store(CustomFieldRequest $request)
    {
        CustomField::create($request->all());
        return redirect()
            ->route('datapoint-categories.index')
            ->with('success', 'Custom Field Added successfully!');
    }
    public function edit(CustomField $customField)
    {
        return view('custom-fields.edit')->with(compact('customField'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomFieldRequest $request, CustomField $customField)
    {
        $customField->update($request->all());
        return redirect()
            ->route('datapoint-categories.index')
            ->with('success', 'Custom Field updated successfully!');
    }
    public function destroy(CustomField $customField)
    {
        $customField->delete();
        return redirect()
            ->back()
            ->with('success', 'Custom Field deleted successfully!');
    }
}
