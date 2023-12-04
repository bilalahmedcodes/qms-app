<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DatapointCategory extends Model
{
    use HasFactory;
    protected $fillable = ['campaign_id', 'project_id', 'name', 'status', 'added_by'];
    protected static function boot()
    {
        parent::boot();

        DatapointCategory::creating(function ($model) {
            $model->added_by = Auth::user()->hrms_id;
        });
        DatapointCategory::updating(function ($model) {
            $model->added_by = Auth::user()->hrms_id;
        });
    }
    public function datapoints()
    {
        return $this->hasMany(Datapoint::class, 'datapoint_category_id', 'id');
    }
    /**
     * The campaigns that belong to the categories.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function customFields()
    {
        return $this->hasMany(CustomField::class, 'datapoint_category_id', 'id');
    }
}
