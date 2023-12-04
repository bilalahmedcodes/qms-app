<?php

namespace App\Http\Controllers\Datapoints;

use App\Http\Controllers\Controller;
use App\Http\Requests\DatapointCategoryRequest;
use App\Models\Campaign;
use App\Models\DatapointCategory;
use App\Models\Project;
use Illuminate\Http\Request;

class DatapointCategoryController extends Controller
{
    public function index()
    {
        $categories = DatapointCategory::where('status', 'active')
            ->orderBy('id', 'asc')
            ->paginate(15);
        /* $categories = DatapointCategory::where('status', 'active')->orderBy('id', 'desc')
         ->with('datapoints')->paginate(15); */
        return view('datapoint-categories.index', compact('categories'));
    }
    public function create()
    {
        $campaigns = Campaign::all();
        $projects = Project::all();
        return view('datapoint-categories.create', compact('campaigns', 'projects'));
    }
    public function store(DatapointCategoryRequest $request)
    {
        DatapointCategory::create($request->all());
        return redirect()
            ->route('datapoint-categories.index')
            ->with('success', 'Datapoint Category created successfully!');
    }
    public function edit(DatapointCategory $datapoint_category)
    {
        $campaigns = Campaign::where('status', 'active')->get();
        $projects = Project::all();
        return view('datapoint-categories.edit')->with(compact('datapoint_category', 'campaigns', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DatapointCategoryRequest $request, DatapointCategory $datapoint_category)
    {
        $datapoint_category->update($request->all());

        return redirect()
            ->route('datapoint-categories.index')
            ->with('success', 'Datapoint Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DatapointCategory $datapoint_category)
    {
        $datapoint_category->delete();
        return redirect()
            ->back()
            ->with('success', 'Datapoint Category deleted successfully!');
    }
}
