@extends('layouts.app')
@section('title', 'Show General Audit')
@section('content')
    <div class="back-area mb-3">
        <a href="{{ route('general-voice-audits.index') }}" class="btn btn-secondary btn-sm"><i
                class="fas fa-arrow-left mr-2"></i> Go
            Back</a>
    </div>
    <div class="row">
        <div class="col-lg-3">
            @include('includes.general-audit-agent-details', [
                'general_voice_audit' => $general_voice_audit,
            ])
            <!-- end card -->
        </div>
        <div class="col-lg-9">
            @include('includes.general-audit-agent-datapoint-details', [
                'general_voice_audit' => $general_voice_audit,
                'categories' => $categories,
            ])
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
