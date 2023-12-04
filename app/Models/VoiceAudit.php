<?php

namespace App\Models;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Campaign;
use App\Mail\CriticalAlertMail;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VoiceAudit extends Model
{
    use HasFactory, SoftDeletes;
    protected $appends = ['projects', 'score'];
    protected $fillable = ['associate_id', 'team_lead_id', 'manager_id', 'campaign_id', 'project_id', 'user_id', 'percentage', 'call_date', 'customer_name', 'customer_phone', 'record_id', 'recording_link', 'recording_duration', 'client_outcome', 'agent_outcome', 'notes', 'critical_alert', 'status', 'call_type', 'evaluation_time', 'audit_date', 'chat_date', 'customer_feedback', 'start_time', 'queue', 'agent_group', 'caller_id', 'ast_clid', 'ref_no', 'chat_id', 'call_detail'];

    public $sortable = ['id', 'user_id', 'associate_id', 'team_lead_id', 'manager_id', 'call_date', 'customer_name', 'customer_phone', 'agent_outcome', 'client_outcome', 'percentage', 'created_at'];

    protected static function boot()
    {
        parent::boot();
        VoiceAudit::creating(function ($model) {
            $model->user_id = Auth::user()->hrms_id;
        });
        VoiceAudit::created(function ($model) {
            if ($model->critical_alert == 1) {
                $reportingTo = $model->teamLead->email;
                Mail::to($reportingTo)
                    ->cc(['qa@touchstone.com.pk', 'Training@touchstone.com.pk', 'hujaved@touchstone.com.pk', $model->manager->email])
                    ->bcc(['asaadat@touchstonebpo.com', 'mrasul@touchstone.com.pk', 'myounus@touchstone.com.pk', 'biahmed@touchstone.com.pk'])
                    ->send(new CriticalAlertMail($model));
            }
        });
    }
    public function getCallDateAttribute($value)
    {
        $call_date = Carbon::parse($value);
        return $call_date->format('m-d-Y');
    }
    public function evaluator()
    {
        return $this->hasOne(User::class, 'hrms_id', 'user_id');
    }

    public function teamLead()
    {
        return $this->hasOne(User::class, 'hrms_id', 'team_lead_id');
    }
    public function manager()
    {
        return $this->hasOne(User::class, 'hrms_id', 'manager_id');
    }

    public function associate()
    {
        return $this->hasOne(User::class, 'hrms_id', 'associate_id');
    }

    public function campaign()
    {
        return $this->hasOne(Campaign::class, 'id', 'campaign_id');
    }
    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
    public function getScoreAttribute()
    {
        $request = request();

        $projects = \DB::table('voice_audits');
        if ($request->type == 'evaluators') {
            $projects = $projects->where('voice_audits.user_id', $this->user_id);
        }
        if ($request->type == 'associates') {
            $projects = $projects->where('voice_audits.associate_id', $this->associate_id);
        }
        if ($request->type == 'teamLeads') {
            $projects = $projects->where('voice_audits.team_lead_id', $this->team_lead_id);
        }
        if ($request->campaign_id > 0) {
            $projects = $projects->where('voice_audits.campaign_id', '=', $request->campaign_id);
        }
        if ($request->project_id > 0) {
            $projects = $projects->where('voice_audits.project_id', '=', $request->project_id);
        }
        if ($request->start_date) {
            $projects = $projects->whereDate('voice_audits.created_at', '>=', $request->start_date);
        }
        if ($request->to_date) {
            $projects = $projects->where('voice_audits.created_at', '<=', $request->to_date);
        }
        return $projects = $projects->avg('percentage');
    }
    public function getProjectsAttribute()
    {
        $request = request();
        $projects = \DB::table('voice_audits')->select('project_id', 'name');
        if ($request->type == 'evaluators') {
            $projects = $projects->where('voice_audits.user_id', $this->user_id);
        }
        if ($request->type == 'associates') {
            $projects = $projects->where('voice_audits.associate_id', $this->associate_id);
        }
        if ($request->type == 'teamLeads') {
            $projects = $projects->where('voice_audits.team_lead_id', $this->team_lead_id);
        }
        if ($request->type == 'managers') {
            $projects = $projects->where('voice_audits.manager_id', $this->manager_id);
        }
        if ($request->type == 'campaigns') {
            $projects = $projects->where('voice_audits.campaign_id', $this->campaign_id);
        }
        $projects = $projects
            ->selectRaw(
                "Count(CASE WHEN (voice_audits.agent_outcome = 'accepted' OR voice_audits.client_outcome = 'accepted') THEN True ELSE   Null END) AS Accepted,
                Count(CASE WHEN (voice_audits.agent_outcome = 'rejected' OR voice_audits.client_outcome = 'rejected' )THEN True ELSE   Null END) AS Rejected,
                Avg(voice_audits.percentage ) AS Percentage",
            )
            ->join('projects', 'projects.id', '=', 'voice_audits.project_id')
            ->groupBy('project_id');
        if ($request->campaign_id > 0) {
            $projects = $projects->where('voice_audits.campaign_id', '=', $request->campaign_id);
        }
        if ($request->project_id > 0) {
            $projects = $projects->where('voice_audits.project_id', '=', $request->project_id);
        }
        if ($request->user_id > 0) {
            $projects = $projects->where('user_id', $request->user_id);
        }
        if ($request->associate_id > 0) {
            $projects = $projects->where('associate_id', $request->associate_id);
        }
        if ($request->team_lead_id > 0) {
            $projects = $projects->where('team_lead_id', $request->team_lead_id);
        }
        if ($request->manager_id > 0) {
            $projects = $projects->where('manager_id', $request->manager_id);
        }
        if ($request->from_date) {
            $projects = $projects->whereDate('voice_audits.created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $projects = $projects->whereDate('voice_audits.created_at', '<=', $request->to_date);
        }

        return $projects = $projects->get();
    }
    public function scopeSearch($query, $request)
    {
        if ($request->has('record_id')) {
            if (!empty($request->record_id)) {
                $query = $query->where('record_id', $request->record_id);
            }
        }
        if ($request->has('customer_phone')) {
            if (!empty($request->customer_phone)) {
                $query = $query->where('customer_phone', $request->customer_phone);
            }
        }
        if ($request->has('user_id')) {
            if ($request->user_id > 0) {
                $query = $query->where('user_id', $request->user_id);
            }
        }
        if ($request->has('associate_id')) {
            if ($request->associate_id > 0) {
                $query = $query->where('associate_id', $request->associate_id);
            }
        }
        if ($request->has('campaign_id')) {
            if ($request->campaign_id > 0) {
                $query = $query->where('campaign_id', $request->campaign_id);
            }
        }
        if ($request->has('project_id')) {
            if ($request->project_id > 0) {
                $query = $query->where('project_id', $request->project_id);
            }
        }
        if ($request->has('client_outcome')) {
            if (!empty($request->client_outcome)) {
                $query = $query->where('client_outcome', $request->client_outcome);
            }
        }
        if ($request->has('agent_outcome')) {
            if (!empty($request->agent_outcome)) {
                $query = $query->where('agent_outcome', $request->agent_outcome);
            }
        }
        if ($request->has('status')) {
            if (!empty($request->status)) {
                $query = $query->where('status', $request->status);
            }
        }
        if ($request->has('from_date')) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereDate('created_at', '>=', $request->from_date);
                $query = $query->whereDate('created_at', '<=', $request->to_date);
            }
        }
        return $query;
    }
}
