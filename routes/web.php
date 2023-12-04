<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Exports\ExportController;
use App\Http\Controllers\Imports\ImportController;
use App\Http\Controllers\Voice\VoiceReportController;
use App\Http\Controllers\Datapoints\DatapointController;
use App\Http\Controllers\Datapoints\CustomFieldController;
use App\Http\Controllers\Voice\GeneralVoiceAuditController;
use App\Http\Controllers\Voice\VoiceEvaluationReviewController;
use App\Http\Controllers\Datapoints\DatapointCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::resource('/general-voice-audits', GeneralVoiceAuditController::class);

    Route::prefix('voice-evaluations')->group(function () {
        Route::get('/', [VoiceEvaluationReviewController::class, 'index'])->name('voice-evaluations.index');
    });
    Route::prefix('exports')->group(function () {
        Route::get('/general-voice-audits', [ExportController::class, 'generalVoiceAudits'])->name('exports.general-voice-audits');
        Route::get('/general-evaluations', [ExportController::class, 'generalEvaluations'])->name('exports.general-evaluations');
    });
    Route::prefix('imports')->group(function () {
        Route::get('/audits', [ImportController::class, 'import'])->name('imports.audits');
    });
    Route::middleware('admin')->group(function () {
        // datapoint categories
        Route::resource('/datapoint-categories', DatapointCategoryController::class)->except('show');
        // datapoints
        Route::prefix('datapoints')
            ->get('/create/{datapoint_category}', [DataPointController::class, 'create'])
            ->name('datapoints.create');
        Route::resource('/datapoints', DatapointController::class)->except('index', 'create', 'show');
        // custom fields
        Route::prefix('custom-fields')
            ->get('/create/{datapoint_category}/{datapoint}', [CustomFieldController::class, 'create'])
            ->name('custom-fields.create');
        Route::resource('/custom-fields', CustomFieldController::class)->except('index', 'create', 'show');
        // users
        Route::resource('/users', UserController::class)->except('create', 'store', 'show');
    });
    Route::get('get-user-detail/{hrms_id}', [UserController::class, 'getDetail'])->name('user-detail');

    Route::get('/', [DashboardController::class, 'index'])->name('main');

    Route::prefix('reports')->group(function () {
        Route::get('/associates', [VoiceReportController::class, 'associates'])->name('reports.associates');
        Route::get('/team-leads', [VoiceReportController::class, 'team_leads'])->name('reports.team-leads');
        Route::get('/managers', [VoiceReportController::class, 'managers'])->name('reports.managers');
        Route::get('/evaluators', [VoiceReportController::class, 'evaluators'])->name('reports.evaluators');
        Route::get('/campaigns', [VoiceReportController::class, 'campaigns'])->name('reports.campaigns');
        Route::get('/timesheet', [VoiceReportController::class, 'timesheet'])->name('reports.timesheet');
    });
});
// unsecure routes

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});
