<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Sortable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'password_text',
        'hrms_id',
        'reporting_to',
        'campaign_id',
        'designation_id',
        'status',
        'campaign_name',
        'designation'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public $sortable = ['name', 'email', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $dates = ['deleted_at'];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function campaign()
    {
        return $this->hasOne(Campaign::class, 'id', 'campaign_id');
    }

    public function designation()
    {
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }
    public function voiceAudits()
    {
        return $this->hasMany(VoiceAudit::class, 'user_id', 'id');
    }
    public function supervisor()
    {
        return $this->hasOne(User::class, 'hrms_id', 'reporting_to');
    }

    public function scopeSearch($query, $request)
    {
        if ($request->has('id')) {
            if (!empty($request->id)) {
                $query = $query->where('id', $request->id);
            }
        }
        if ($request->has('hrms_id')) {
            if (!empty($request->hrms_id)) {
                $query = $query->where('hrms_id', $request->hrms_id);
            }
        }
        if ($request->has('name')) {
            if (!empty($request->name)) {
                $query = $query->where('name', 'LIKE', "%{$request->name}%");
            }
        }

        if ($request->has('username')) {
            if (!empty($request->username)) {
                $query = $query->where('username', 'LIKE', "%{$request->username}%");
            }
        }

        if ($request->has('email')) {
            if (!empty($request->email)) {
                $query = $query->where('email', 'LIKE', "%{$request->email}%");
            }
        }

        if ($request->has('campaign_id')) {
            if (!empty($request->campaign_id)) {
                $query = $query->where('campaign_id', $request->campaign_id);
            }
        }

        if ($request->has('status')) {
            if (!empty($request->status)) {
                $query = $query->where('status', $request->status);
            }
        }

        return $query;
    }

    public function scopeRole($query, $role)
    {
        return $query->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        });
    }

}
