<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Vendor;

class MasterController extends Controller
{
    /**
     * Master Data OS (Employee) Index
     */
    public function employeeIndex()
    {
        // Ambil semua pegawai OS
        // Asumsi 'vendor_id' bisa digunakan untuk filter jika perlu, tapi ini master global (admin/user)
        $employees = Employee::orderBy('name', 'asc')->get();

        return view('master.os', compact('employees'));
    }

    /**
     * Master Data OS Create Form
     */
    public function employeeCreate()
    {
        return view('master.os_create');
    }

    /**
     * Link to Employee Edit (Placeholder for now)
     */
    public function employeeEdit($id)
    {
        // Nanti implementasi edit dinamis
        return view('master.os_edit');
    }

    /**
     * Link to Employee History (Placeholder for now)
     */
    public function employeeHistory($id)
    {
        // Nanti implementasi history dinamis
        return view('master.os_history');
    }

    // =========================================================================

    /**
     * Master Data Vendor Index
     */
    public function vendorIndex()
    {
        // Ambil semua vendor
        $vendors = Vendor::orderBy('name', 'asc')->get();

        return view('user.master-vendor', compact('vendors'));
    }

    /**
     * Vendor Create Form
     */
    public function vendorCreate()
    {
        return view('user.master_vendor_create');
    }
}
