<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomField extends Model
{
    use HasFactory;
    protected $fillable = ['campaign_id', 'project_id', 'datapoint_category_id', 'datapoint_id', 'label', 'placeholder', 'type', 'options', 'values', 'required', 'added_by'];
    protected static function boot()
    {
        parent::boot();
        CustomField::creating(function ($model) {
            $model->added_by = Auth::user()->hrms_id;
        });
    }
}
