<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Datapoint extends Model
{
    use HasFactory;
    protected $fillable = ['datapoint_category_id', 'campaign_id', 'project_id', 'name', 'question','description', 'added_by'];

    protected static function boot()
    {
        parent::boot();

        Datapoint::creating(function ($model) {
            $model->added_by = Auth::user()->hrms_id;
        });
    }

    public function category()
    {
        return $this->belongsTo(DatapointCategory::class, 'datapoint_category_id');
    }
    public function customFields()
    {
        return $this->hasMany(CustomField::class, 'datapoint_id', 'id');
    }
}
