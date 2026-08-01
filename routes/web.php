<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::prefix('address')->group(function () {
    Route::get('regions', [AddressController::class, 'getRegions']);
    Route::get('provinces/{regionId}', [AddressController::class, 'getProvinces']);
    Route::get('cities/{provinceId}', [AddressController::class, 'getCities']);
    Route::get('barangays/{cityId}', [AddressController::class, 'getBarangays']);
});

Route::get('/reload-captcha', [CaptchaController::class, 'reloadCaptcha'])->name('reload-captcha');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    Route::get('/users/export-selected', [UserController::class, 'exportSelected'])->name('users.export-selected');
    Route::get('/users/export-all', [UserController::class, 'exportAll'])->name('users.export.all');
    Route::resource('users', UserController::class);
    // Explicit Role Assignment Route Hook
    Route::put('users/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
    Route::patch('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.status');

    Route::resource('roles', RoleController::class);
    Route::get('role-permissions/{id}/edit', [RolePermissionController::class, 'edit'])->name('role-permissions.edit');
    Route::put('role-permissions/{id}', [RolePermissionController::class, 'update'])->name('role-permissions.update');
    Route::resource('permissions', PermissionController::class);

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('master-data', [MasterDataController::class, 'index'])->name('master-data.index');

    // School Context Sync Rest Paths
    Route::post('master-data/school', [MasterDataController::class, 'storeSchool']);
    Route::get('master-data/school/{id}', [MasterDataController::class, 'showSchool']);
    Route::put('master-data/school/{id}', [MasterDataController::class, 'updateSchool']);
    Route::delete('master-data/school/{id}', [MasterDataController::class, 'destroySchool']);

    // District Context Sync Rest Paths
    Route::post('master-data/district', [MasterDataController::class, 'storeDistrict']);
    Route::get('master-data/district/{id}', [MasterDataController::class, 'showDistrict']);
    Route::put('master-data/district/{id}', [MasterDataController::class, 'updateDistrict']);
    Route::delete('master-data/district/{id}', [MasterDataController::class, 'destroyDistrict']);

    // Office Context Sync Rest Paths
    Route::post('master-data/office', [MasterDataController::class, 'storeOffice']);
    Route::get('master-data/office/{id}', [MasterDataController::class, 'showOffice']);
    Route::put('master-data/office/{id}', [MasterDataController::class, 'updateOffice']);
    Route::delete('master-data/office/{id}', [MasterDataController::class, 'destroyOffice']);

    Route::get('master-data/schools/export/excel', [MasterDataController::class, 'exportExcel'])->name('export.schools.excel');
    Route::get('master-data/schools/export/pdf', [MasterDataController::class, 'exportPdf'])->name('export.schools.pdf');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    Route::post('notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    })->name('notifications.clear');

    Route::resource('announcements', AnnouncementController::class)->only(['index', 'store', 'destroy']);
    Route::patch('announcements/{id}/toggle', [AnnouncementController::class, 'toggleStatus'])->name('announcements.toggle');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'password'])
        ->name('profile.password');
});
Route::get('/settings/image/{key}', [SettingController::class, 'showImage'])->name('image.show');

require __DIR__ . '/auth.php';
require __DIR__ . '/dts.php';
require __DIR__ . '/icts.php';
