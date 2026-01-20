<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('user.master-os');
});

// Grup User
// Grup User
Route::prefix('user')->name('user.')->group(function () {
    // --- WORK PERMIT (Dynamic via UserController) ---
    Route::get('/work-permit', [App\Http\Controllers\UserController::class, 'index'])->name('work-permit.index');
    Route::get('/work-permit/create', [App\Http\Controllers\UserController::class, 'create'])->name('work-permit.create');
    Route::post('/work-permit', [App\Http\Controllers\UserController::class, 'store'])->name('work-permit.store');
    Route::get('/work-permit/history', [App\Http\Controllers\UserController::class, 'history'])->name('work-permit.history');
    Route::get('/work-permit/detail/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('work-permit.detail');

    // --- MASTER DATA (Closure / Placeholder) ---
    // --- MASTER DATA (Dynamic via MasterController) ---
    Route::get('/master-os', [App\Http\Controllers\MasterController::class, 'employeeIndex'])->name('master-os');
    Route::get('/master-os/create', [App\Http\Controllers\MasterController::class, 'employeeCreate'])->name('master-os.create');

    // Placeholder edit/history (tetap closure dulu atau redirect ke controller juga boleh)
    Route::get('/master-os/edit', function () {
        return view('master.os_edit');
    })->name('master-os.edit');

    Route::get('/master-os/history', function () {
        return view('master.os_history');
    })->name('master-os.history');

    // --- MASTER VENDOR ---
    Route::get('/master-vendor', [App\Http\Controllers\MasterController::class, 'vendorIndex'])->name('master-vendor');
    Route::get('/master-vendor/create', [App\Http\Controllers\MasterController::class, 'vendorCreate'])->name('master-vendor.create');

    Route::get('/master-vendor/edit', function () {
        return view('user.master_vendor_edit');
    })->name('master-vendor.edit');

    Route::get('/master-vendor/history', function () {
        return view('user.master_vendor_history');
    })->name('master-vendor.history');

    Route::get('/blacklist-os/history', function () {
        return view('user.blacklist_os_history');
    })->name('blacklist-os.history');

    // Route::get('/work-permit/history', ...) -> Bisa digabung ke index dengan filter status

    Route::get('/history', function () {
        return view('user.history');
    })->name('history');

    Route::get('/blacklist-os', function () {
        return view('user.blacklist-os');
    })->name('blacklist-os');

    Route::get('/blacklist-vendor/history', function () {
        return view('user.blacklist_vendor_history');
    })->name('blacklist-vendor.history');

    Route::get('/blacklist-vendor', function () {
        return view('user.blacklist-vendor');
    })->name('blacklist-vendor');
});

// Grup Corsec
Route::prefix('corsec')->name('corsec.')->group(function () {
    Route::get('/work-permit-masuk', function () {
        return view('corsec.work-permit-masuk');
    })->name('work-permit-masuk');

    Route::get('/work-permit-history', function () {
        return view('corsec.work_permit_history');
    })->name('work-permit-history');

    Route::get('/work-permit/detail/{id?}', function ($id = null) {
        return view('corsec.work_permit_detail', ['id' => $id]);
    })->name('work-permit.detail');
});

// Grup HSE
Route::prefix('hse')->name('hse.')->group(function () {

    // --- WORK PERMIT ROUTES DIHUBUNGKAN KE CONTROLLER ---
    Route::get('/work-permit-hse', [App\Http\Controllers\HseController::class, 'index'])->name('work-permit-hse');
    Route::get('/work-permit-history', [App\Http\Controllers\HseController::class, 'history'])->name('work_permit_history');
    Route::get('/work-permit/detail/{id}', [App\Http\Controllers\HseController::class, 'detail'])->name('work_permit.detail');

    // Actions
    Route::post('/work-permit/{id}/schedule', [App\Http\Controllers\HseController::class, 'scheduleInduction'])->name('work_permit.schedule');
    Route::post('/work-permit/{id}/validate', [App\Http\Controllers\HseController::class, 'validateInduction'])->name('work_permit.validate');
    Route::post('/work-permit/{id}/reject', [App\Http\Controllers\HseController::class, 'reject'])->name('work_permit.reject');

    // --- SISA MASTER DATA (Masih View Statis dulu) ---
    Route::get('/master-apd', [App\Http\Controllers\HseController::class, 'apdIndex'])->name('master-apd');
    Route::post('/master-apd', [App\Http\Controllers\HseController::class, 'storeSafetyEquipment'])->name('master-apd.store');
    Route::put('/master-apd/{id}', [App\Http\Controllers\HseController::class, 'updateSafetyEquipment'])->name('master-apd.update');

    Route::get('/master-pengaman', [App\Http\Controllers\HseController::class, 'pengamanIndex'])->name('master-pengaman');
    Route::post('/master-pengaman', [App\Http\Controllers\HseController::class, 'storeSafetyEquipment'])->name('master-pengaman.store');
    Route::put('/master-pengaman/{id}', [App\Http\Controllers\HseController::class, 'updateSafetyEquipment'])->name('master-pengaman.update');

    Route::get('/master-blacklist', [App\Http\Controllers\HseController::class, 'blacklistIndex'])->name('master-blacklist');

    Route::get('/blacklist-os/detail', function () {
        return view('hse.blacklist_os_detail');
    })->name('blacklist-os.detail');

    Route::get('/blacklist-vendor/detail', function () {
        return view('hse.blacklist_vendor_detail');
    })->name('blacklist-vendor.detail');



    Route::get('/master-ikb', [App\Http\Controllers\HseController::class, 'ikbIndex'])->name('master-ikb');
    Route::get('/master-ikb/create', [App\Http\Controllers\HseController::class, 'ikbCreate'])->name('master-ikb.create');
    Route::post('/master-ikb', [App\Http\Controllers\HseController::class, 'storeIKB'])->name('master-ikb.store');
    Route::get('/master-ikb/{id}/edit', [App\Http\Controllers\HseController::class, 'ikbEdit'])->name('master-ikb.edit');
    Route::put('/master-ikb/{id}', [App\Http\Controllers\HseController::class, 'updateIKB'])->name('master-ikb.update');
});
