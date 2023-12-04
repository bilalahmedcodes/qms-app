@extends('layouts.app')
@section('title', 'All Users List')
@section('content')
    <div class="search-area">
        <div class="d-flex justify-content-end mb-3">
                <div class="button-area">
                    <button type="button" id="btn-search" class="btn btn-primary"><i class="fas fa-filter"></i> Search</button>
                </div>
        </div>
        <form action="{{ route('users.index') }}" method="get" autocomplete="off" id="search"
            @if (isset($_GET['search'])) style="display: block;" @endif>
            <input type="hidden" name="search" value="1">
            @php
                $name = '';
                $email = '';
                $status = '';
                $campaign_id = -1;
                
                if (isset($_GET['search'])) {
                    if (!empty($_GET['name'])) {
                        $name = $_GET['name'];
                    }
                    if (!empty($_GET['email'])) {
                        $email = $_GET['email'];
                    }
                    if (!empty($_GET['status'])) {
                        $status = $_GET['status'];
                    }
                    if (!empty($_GET['campaign_id'])) {
                        $campaign_id = $_GET['campaign_id'];
                    }
                }
            @endphp
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Name"
                                            value="{{ $name }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" placeholder="Email"
                                            value="{{ $email }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control select2" style="width: 100%">
                                            <option value="">Select</option>
                                            <option value="active" @if ($status == 'active') selected @endif>Active
                                            </option>
                                            <option value="disable" @if ($status == 'disable') selected @endif>
                                                Disabled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Campaign</label>
                                        <select name="campaign_id" class="form-control select2" style="width: 100%">
                                            <option value="">Select</option>
                                            @foreach ($campaigns as $campaign)
                                                <option value="{{ $campaign->id }}"
                                                    @if ($campaign->id == $campaign_id) selected @endif>
                                                    {{ $campaign->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Search</button>
                            <a href="{{ route('users.index') }}" class="m-2">Clear Search</a>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>HRMS ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Reporting To</th>
                                    <th>Campaign</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($users) > 0)
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $key }}</td>
                                            <td>{{ $user->hrms_id ?? 0 }}</td>
                                            <td>{{ $user->name ?? '-' }}</td>
                                            <td>{{ $user->email ?? '-' }}</td>
                                            <td>{{ $user->supervisor->name ?? '-' }}</td>
                                            <td>{{ $user->campaign->name ?? ($user->campaign_name ?? '') }}</td>
                                            <td>{{ $user->roles[0]->name ?? 'N/A' }}</td>
                                            <td>
                                                @if ($user->status == 'active')
                                                    <span class="badge badge-soft-success font-size-12">Active</span>
                                                @else
                                                    <span class="badge badge-soft-danger font-size-12">Disable</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-responsive">
                                                    <table style="border: hidden">
                                                        <tr>
                                                            <td><a href="{{ route('users.edit', $user) }}"
                                                                    class="btn btn-primary btn-sm"><i
                                                                        class="fas fa-edit"></i></a></td>
                                                            <td>
                                                                <form action="{{ route('users.destroy', $user) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                                            class="fas fa-trash"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">No record found!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($users->total() > 20)
                        {{ $users->appends(request()->input())->links('vendor.pagination.default') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#btn-search").click(function() {
            $("#search").toggle();
        });
    </script>
@endsection
