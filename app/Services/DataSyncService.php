<?php

namespace App\Services;

use App\Models\Designation;
use App\Models\User;
use App\Models\Project;
use App\Models\Campaign;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class DataSyncService
{
    // campaigns
    public function campaigns()
    {
        $response = Http::get('https://crm.touchstone-communications.com/api/touchstone-campaigns')->body();
        $response = json_decode($response);
        if ($response->success == 200) {
            $campaigns = $response->data;
            if (count($campaigns) > 0) {
                $existingCampaigns = Campaign::pluck('name')->toArray(); // Get existing campaign names from the database
                foreach ($campaigns as $qms_campaign) {
                    if ($qms_campaign->id > 0) {
                        $campaignName = $this->assignCampaignName($qms_campaign->name);
                        if (!in_array($campaignName, $existingCampaigns)) {
                            $campaign = new Campaign();
                            $campaign->name = $campaignName;
                            $campaign->status = $qms_campaign->status;
                            $campaign->save();
                            $existingCampaigns[] = $campaignName; // Add the new campaign name to the existing array
                        }
                    }
                }
            }
        }
    }
    public function assignCampaignName($campaign)
    {
        $campaign_name = '';
        if (in_array($campaign, ['Mortgage', 'Mortgage x', 'Mortgage Vertical', 'Debt', 'Debt MGMT Team Zameer'])) {
            $campaign_name = 'Debt';
        } elseif (in_array($campaign, ['Solar', 'Solar X', 'Solar MGMT Team Iram', 'Solar SM MGMT Team Farhan'])) {
            $campaign_name = 'Solar';
        } elseif ($campaign == 'Home Warranty') {
            $campaign_name = 'Home Warranty';
        } elseif ($campaign == 'QA vocie Team Humayun') {
            $campaign_name = 'Quality Assurance';
        } elseif (in_array($campaign, ['Guidance', 'Guidance Financial'])) {
            $campaign_name = 'Guidance';
        } elseif (in_array($campaign, ['Eddy MGMT Team Iram', 'Education Dynamics'])) {
            $campaign_name = 'Eddy';
        } elseif ($campaign == 'Education First') {
            $campaign_name = 'Education First';
        } elseif ($campaign == 'Discount School Supply') {
            $campaign_name = 'DSS';
        } elseif (in_array($campaign, ['Finance ISB Team Kashif', 'Finance Team ISB Ahsan'])) {
            $campaign_name = 'Finance';
        } elseif (in_array($campaign, ['Operations Management', 'OPS Management Team Yousaf', 'OPS MGMT Team Abbas', 'OPS MGMT Team Ali Hamayun', 'OPS MGMT Team Massawar', 'OPS MGMT Team Shagy', 'OPS MGMT Team Waqas', 'Support Management Team Yousaf'])) {
            $campaign_name = 'Operations Management';
        } elseif (in_array($campaign, ['Travel Best Bets', 'Printerpix'])) {
            $campaign_name = 'PCI';
        } else {
            $campaign_name = 'CEO Secretariat';
        }
        return $campaign_name;
    }

    public function projects()
    {
        $response = Http::get('https://crm.touchstone-communications.com/api/touchstone-projects')->body();
        $response = json_decode($response);
        if ($response->success == 200) {
            $projects = $response->data;
            if (count($projects) > 0) {
                foreach ($projects as $qms_project) {
                    if ($qms_project->id > 0) {
                        $project = Project::where('crm_id', $qms_project->id)->first();
                        if (!$project) {
                            $project = new Project();
                        }
                        $project->crm_id = $qms_project->id;
                        $project->name = $qms_project->name;
                        $project->project_code = $qms_project->project_code;
                        $project->save();
                    }
                }
            }
        }
    }
    public function designations()
    {
        $response = Http::get('https://crm.touchstone-communications.com/api/get-designations')->body();
        $response = json_decode($response);
        if ($response->success == 200) {
            $designations = $response->data;
            if (count($designations) > 0) {
                foreach ($designations as $qms_designation) {
                    if ($qms_designation->id > 0) {
                        $designation = Designation::where('crm_id', $qms_designation->id)->first();
                        if (!$designation) {
                            $designation = new Designation();
                        }
                        $designation->crm_id = $qms_designation->id;
                        $designation->name = $qms_designation->name;
                        $designation->save();
                    }
                }
            }
        }
    }
    public function users()
    {
        $this->makeSuperAdmin();
        $response = Http::get('https://crm.touchstone-communications.com/api/touchstone-employees')->body();
        $response = json_decode($response);
        if ($response->success == 200) {
            $users = $response->data;
            if (count($users) > 0) {
                foreach ($users as $qms_user) {
                    if ($qms_user->id > 0) {
                        $password = '';
                        $user = User::where('hrms_id', $qms_user->hrms_id)->first();
                        if (!$user) {
                            $user = new User();
                        }
                        $password = '_Touch@@' . $qms_user->hrms_id . '_';
                        $fullName = @$qms_user->first_name . ' ' . @$qms_user->middle_name . ' ' . @$qms_user->last_name;
                        $stripped = preg_replace('!\s+!', ' ', $fullName);
                        $name = str_replace('-', '', $stripped);
                        $user->hrms_id = $qms_user->hrms_id;
                        $user->reporting_to = $qms_user->reporting_to;
                        $user->designation_id = $this->assignDesignationId($qms_user->designation);
                        $user->email = $qms_user->email;
                        $user->password = $password;
                        $user->password_text = trim($password);
                        $user->name = $this->remove_extra_spaces($name);
                        $user->campaign_id = $this->assignCampaignId($qms_user->campaign);
                        $user->status = $this->assignStatus($qms_user->status);
                        $user->campaign_name = $qms_user->campaign;
                        $user->designation = $qms_user->designation;
                        $user->save();
                        $directors = ['Assistant Director', 'Director Operations'];
                        $managers = ['Assistant Manager', 'Assistant Manager Operations', 'Manager', 'Manager Operations', 'Project Manager', 'Senior Manager'];
                        $team_leads = ['Team Lead Ops', 'Team lead', 'Trainee Team Lead'];
                        $associates = ['CSR', 'Snr CSR'];
                        $evaluators = ['QAS'];
                        $admin = ['Chief Executive Officer', 'Head OB Sales'];
                        $executive = ['Executive', 'Finance Executive'];
                        if (in_array($qms_user->designation, $directors)) {
                            $user->assignRole('Director');
                        } elseif (in_array($qms_user->designation, $managers)) {
                            $user->assignRole('Manager');
                        } elseif (in_array($qms_user->designation, $team_leads)) {
                            $user->assignRole('Team Lead');
                        } elseif (in_array($qms_user->designation, $associates)) {
                            $user->assignRole('Associate');
                        } elseif (in_array($qms_user->designation, $evaluators)) {
                            $user->assignRole('Evaluator');
                        } elseif (in_array($qms_user->designation, $admin)) {
                            $user->assignRole('Admin');
                        } elseif (in_array($qms_user->designation, $executive)) {
                            $user->assignRole('Executive');
                        }
                    }
                }
            }
        }
    }

    public function assignCampaignId($campaign)
    {
        $campaign_id = '';
        if (in_array($campaign, ['Mortgage', 'Mortgage x', 'Mortgage Vertical', 'Debt', 'Debt MGMT Team Zameer'])) {
            $campaign_id = 2;
        } elseif (in_array($campaign, ['Solar', 'Solar X', 'Solar MGMT Team Iram', 'Solar SM MGMT Team Farhan'])) {
            $campaign_id = 12;
        } elseif ($campaign == 'Home Warranty') {
            $campaign_id = 8;
        } elseif ($campaign == 'QA vocie Team Humayun') {
            $campaign_id = 11;
        } elseif (in_array($campaign, ['Guidance', 'Guidance Financial'])) {
            $campaign_id = 7;
        } elseif (in_array($campaign, ['Eddy MGMT Team Iram', 'Education Dynamics', 'Education First'])) {
            $campaign_id = 4;
        } elseif ($campaign == 'Discount School Supply') {
            $campaign_id = 3;
        } elseif (in_array($campaign, ['Finance ISB Team Kashif', 'Finance Team ISB Ahsan'])) {
            $campaign_id = 6;
        } elseif (in_array($campaign, ['Operations Management', 'OPS Management Team Yousaf', 'OPS MGMT Team Abbas', 'OPS MGMT Team Ali Hamayun', 'OPS MGMT Team Massawar', 'OPS MGMT Team Shagy', 'OPS MGMT Team Waqas', 'Support Management Team Yousaf'])) {
            $campaign_id = 9;
        } elseif (in_array($campaign, ['Travel Best Bets', 'Printerpix'])) {
            $campaign_id = 10;
        } elseif ($campaign == 'CEO Secretariat') {
            $campaign_id = 1;
        } else {
            $campaign_id = 0;
        }
        return $campaign_id;
    }
    public function assignStatus($status)
    {
        $userStatus = '';
        if ($status == 'Confirmed' || $status == 'Probation' || $status == 'Temporary' || $status == 'Trainee') {
            $userStatus = 'active';
        } else {
            $userStatus = 'disable';
        }
        return $userStatus;
    }

    public function assignDesignationId($designation)
    {
        $designation_id = '';
        if ($designation == 'Assistant Director') {
            $designation_id = '2';
        } elseif ($designation == 'Assistant Manager') {
            $designation_id = '3';
        } elseif ($designation == 'Assistant Manager Operations') {
            $designation_id = '10';
        } elseif ($designation == 'Manager') {
            $designation_id = '24';
        } elseif ($designation == 'Manager Operations') {
            $designation_id = '25';
        } elseif ($designation == 'Project Manager') {
            $designation_id = '29';
        } elseif ($designation == 'Senior Manager') {
            $designation_id = '38';
        } elseif ($designation == 'Team Lead Ops') {
            $designation_id = '40';
        } elseif ($designation == 'Trainee Team Lead') {
            $designation_id = '64';
        } elseif ($designation == 'CSR') {
            $designation_id = '9';
        } elseif ($designation == 'Snr CSR') {
            $designation_id = '33';
        } elseif ($designation == 'QAS') {
            $designation_id = '30';
        } elseif ($designation == 'Chief Executive Officer') {
            $designation_id = '47';
        } elseif ($designation == 'Head OB Sales') {
            $designation_id = '56';
        } elseif ($designation == 'Executive') {
            $designation_id = '12';
        } elseif ($designation == 'Finance Executive') {
            $designation_id = '14';
        } else {
            $designation_id = '0';
        }
        return $designation_id;
    }
    public function makeSuperAdmin()
    {
        $user = User::where('email', 'admin@touchstone.com.pk')->first();

        if (!$user) {
            $user = new User();
            $user->hrms_id = 123456;
            $user->name = 'Adminstrator';
            $user->email = 'admin@touchstone.com.pk';
            $user->password = 'Touchstone@786';
            $user->password_text = 'Touchstone@786';
            $user->status = 'active';
            $user->save();
            $user->assignRole('Super Admin');
        }
    }
    public function remove_extra_spaces($full_name) {
        // Remove leading and trailing spaces.
        $full_name = trim($full_name);
      
        // Replace multiple spaces with a single space.
        $full_name = preg_replace('/\s+/', ' ', $full_name);
      
        // Return the cleaned full name.
        return $full_name;
      }
}
