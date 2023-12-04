<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="{{ asset('assets/images/Logo-Icon-Png.png') }}" alt=""
                    class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">

                <a href="{{ route('dashboard') }}"
                    class="text-dark fw-medium font-size-16">{{ Auth::user()->name ?? 'Default' }}</a>
                <p class="text-body mt-1 mb-0 font-size-13">{{ Auth::user()->roles[0]->name ?? '' }}</p>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class=" waves-effect">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if (in_array(Auth::user()->roles[0]->name, ['Super Admin', 'Admin']) ||
                        (in_array(Auth::user()->roles[0]->name, ['Team Lead', 'Evaluator']) && Auth::user()->campaign_id == 11) ||
                        Auth::user()->hrms_id == 695957 ||
                        (in_array(Auth::user()->roles[0]->name, ['Director']) && Auth::user()->campaign_id == 6))
                    <li>
                        <a href="{{ route('general-voice-audits.index') }}" class=" waves-effect">
                            <i class="bx bx-task"></i>
                            <span>General Audits</span>
                        </a>
                    </li>
                @endif
                {{-- This is for OPs --}}
                @if (in_array(Auth::user()->roles[0]->name, ['Director', 'Manager', 'Team Lead']) &&
                        (Auth::user()->campaign_id != 6 && Auth::user()->campaign_id != 11) &&
                        Auth::user()->hrms_id != 695957)
                    <li>
                        <a href="{{ route('voice-evaluations.index') }}" class=" waves-effect">
                            <i class="bx bx-task"></i>
                            <span>Voice Evaluations</span>
                        </a>
                    </li>
                @endif
                <li class="menu-title">Reports</li>
                @if (in_array(Auth::user()->roles[0]->name, ['Super Admin', 'Admin']) ||
                        in_array(Auth::user()->roles[0]->name, ['Director', 'Manager', 'Team Lead']) ||
                        Auth::user()->hrms_id == 695957 ||
                        (in_array(Auth::user()->roles[0]->name, ['Director']) && Auth::user()->campaign_id == 6))
                    <li>
                        <a href="{{ route('reports.associates') }}?search=1&associate_id=-1&type=associates&from_date={{ now()->startOfMonth()->format('Y-m-d') }}&to_date={{ now()->endOfMonth()->format('Y-m-d') }}"
                            class=" waves-effect">
                            <i class="fas fa-users"></i>
                            <span>Associates Report</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.team-leads') }}?search=1&team_lead_id=-1&type=teamLeads&from_date={{ now()->startOfMonth()->format('Y-m-d') }}&to_date={{ now()->endOfMonth()->format('Y-m-d') }}"
                            class=" waves-effect">
                            <i class="fas fa-restroom"></i>
                            <span>Team Leads Report</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.campaigns') }}?search=1&campaign_id=-1&type=campaigns&from_date={{ now()->startOfMonth()->format('Y-m-d') }}&to_date={{ now()->endOfMonth()->format('Y-m-d') }}"
                            class=" waves-effect">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Campaigns Report</span>
                        </a>
                    </li>
                @endif
                @if (in_array(Auth::user()->roles[0]->name, ['Super Admin', 'Admin']) ||
                        in_array(Auth::user()->roles[0]->name, ['Director', 'Manager']) ||
                        Auth::user()->hrms_id == 695957 ||
                        (in_array(Auth::user()->roles[0]->name, ['Director']) && Auth::user()->campaign_id == 6))
                    <li>
                        <a href="{{ route('reports.managers') }}?search=1&manager_id=-1&type=managers&from_date={{ now()->startOfMonth()->format('Y-m-d') }}&to_date={{ now()->endOfMonth()->format('Y-m-d') }}"
                            class=" waves-effect">
                            <i class="fas fa-user-tie"></i>
                            <span>Managers Report</span>
                        </a>
                    </li>
                @endif
                @if (in_array(Auth::user()->roles[0]->name, ['Super Admin', 'Admin']) ||
                        (in_array(Auth::user()->roles[0]->name, ['Team Lead', 'Evaluator']) && Auth::user()->campaign_id == 11) ||
                        Auth::user()->hrms_id == 695957 ||
                        (in_array(Auth::user()->roles[0]->name, ['Director']) && Auth::user()->campaign_id == 6))
                    <li>
                        <a href="{{ route('reports.evaluators') }}?search=1&user_id=-1&type=evaluators&from_date={{ now()->startOfMonth()->format('Y-m-d') }}&to_date={{ now()->endOfMonth()->format('Y-m-d') }}"
                            class=" waves-effect">
                            <i class="fas fa-user-check"></i>
                            <span>Evaluators Report</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('reports.timesheet') }}?search=1&user_id=-1&from_date={{ now()->startOfMonth()->format('Y-m-d') }}&to_date={{ now()->endOfMonth()->format('Y-m-d') }}"
                            class=" waves-effect">
                            <i class="fas fa-clock"></i>
                            <span>Time Sheet Report</span>
                        </a>
                    </li> --}}
                @endif
                @if (in_array(Auth::user()->roles[0]->name, ['Super Admin', 'Admin']))
                    {{-- Settings area --}}
                    <li class="menu-title">Settings</li>
                    <li>
                        <a href="{{ route('datapoint-categories.index') }}" class=" waves-effect">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Datapoints</span>
                        </a>
                    </li>
                @endif
                @if (in_array(Auth::user()->roles[0]->name, ['Super Admin']))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-users-cog"></i>
                            <span>Users</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('users.index') }}">Users</a></li>
                            {{-- <li><a href="maps-vector.html">Roles</a></li> --}}
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
