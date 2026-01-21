<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('user.master-os');
});

// Grup User
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/master-os', function () {
        return view('master.os'); // Menggunakan view yang sudah ada
    })->name('master-os');

    Route::get('/master-os/create', function () {
        return view('master.os_create');
    })->name('master-os.create');

    Route::get('/master-os/edit', function () {
        return view('master.os_edit');
    })->name('master-os.edit');

    Route::get('/master-os/history', function () {
        return view('master.os_history');
    })->name('master-os.history');

    Route::get('/master-vendor/create', function () {
        return view('user.master_vendor_create');
    })->name('master-vendor.create');

    Route::get('/master-vendor/edit', function () {
        return view('user.master_vendor_edit');
    })->name('master-vendor.edit');

    Route::get('/master-vendor/history', function () {
        return view('user.master_vendor_history');
    })->name('master-vendor.history');

    Route::get('/blacklist-os/history', function () {
        return view('user.blacklist_os_history');
    })->name('blacklist-os.history');

    Route::get('/master-vendor', function () {
        return view('user.master-vendor');
    })->name('master-vendor');

    Route::get('/work-permit/create', function () {
        return view('user.work_permit_create');
    })->name('work-permit.create');

    Route::get('/work-permit/detail/{id?}', function ($id = null) {
        return view('user.work_permit_detail', ['id' => $id]);
    })->name('work-permit.detail');

    Route::get('/work-permit/history', function () {
        return view('user.work_permit_history');
    })->name('work-permit.history');

    Route::get('/work-permit', function () {
        return view('user.work-permit');
    })->name('work-permit');

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
    Route::get('/master-apd', function () {
        return view('hse.master-apd');
    })->name('master-apd');


    Route::get('/master-pengaman', function () {
        return view('hse.master-pengaman');
    })->name('master-pengaman');

    Route::get('/master-data-si', function () {
        return view('hse.master_data_si');
    })->name('master-data-si');

    Route::get('/master-blacklist', function () {
        return view('hse.master-blacklist');
    })->name('master-blacklist');

    Route::get('/blacklist-os/detail', function () {
        return view('hse.blacklist_os_detail');
    })->name('blacklist-os.detail');

    Route::get('/blacklist-vendor/detail', function () {
        return view('hse.blacklist_vendor_detail');
    })->name('blacklist-vendor.detail');

    Route::get('/master-ikb', function () {
        return view('hse.master-ikb');
    })->name('master-ikb');

    Route::get('/master-ikb/create', function () {
        return view('hse.master_ikb_create');
    })->name('master-ikb.create');

    Route::get('/master-ikb/edit', function () {
        return view('hse.master_ikb_edit');
    })->name('master-ikb.edit');

    Route::get('/work-permit-hse', function () {
        return view('hse.work-permit-hse');
    })->name('work-permit-hse');

    Route::get('/work-permit-history', function () {
        return view('hse.work_permit_history');
    })->name('work_permit_history');

    Route::get('/work-permit/detail/{id?}', function ($id = null) {
        return view('hse.work_permit_detail', ['id' => $id]);
    })->name('work_permit.detail');
    Route::get('/safety-induction', function () {
        return view('hse.safety_induction');
    })->name('safety-induction');
});
