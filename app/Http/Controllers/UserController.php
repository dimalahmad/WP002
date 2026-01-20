<?php

namespace App\Http\Controllers;

use App\Models\WorkPermit;
use App\Models\Vendor;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Dashboard User / List Work Permit Saya
     */
    public function index()
    {
        // Simulasi User Login (Vendor ID 1)
        // Nanti diganti Auth::user()->vendor_id
        $vendorId = 1;

        // Index menampilkan yang sedang berjalan (draft, waiting, scheduled)
        // Atau tampilkan semua tapi bedakan tab?
        // Untuk sekarang tampilkan semua exclude yang 'finished/rejected' di index utama agar index fokus ke yang aktif/pending?
        // Aturan user umum: Tampilkan semua pengajuan di index, History khusus yang sudah selesai/expired.

        $myWps = WorkPermit::with(['vendor'])
            ->where('vendor_id', $vendorId)
            ->latest()
            ->get();

        return view('user.work-permit', compact('myWps'));
    }

    /**
     * History Work Permit (Archive)
     */
    public function history()
    {
        $vendorId = 1; // Simulasi

        // Ambil WP yang statusnya sudah final atau aktif lama
        $historyWps = WorkPermit::with(['vendor', 'employees'])
            ->where('vendor_id', $vendorId)
            ->whereIn('status', ['active', 'expired', 'rejected', 'finished'])
            ->latest()
            ->get();

        return view('user.work_permit_history', compact('historyWps'));
    }

    /**
     * Form Pengajuan Work Permit Baru
     */
    public function create()
    {
        // Ambil data Vendor untuk auto-fill (Simulasi)
        $vendor = Vendor::find(1);

        return view('user.work_permit_create', compact('vendor'));
    }

    /**
     * Simpan Pengajuan WP
     */
    public function store(Request $request)
    {
        $request->validate([
            'work_type' => 'required',
            'work_description' => 'required',
            'location' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Generate Doc No Dummy (WP-YYYY-00X)
        $count = WorkPermit::count() + 1;
        $docNo = 'WP-' . date('Y') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $wp = WorkPermit::create([
            'doc_no' => $docNo,
            'vendor_id' => 1, // Simulasi
            'work_type' => $request->work_type,
            'status' => 'waiting_corsec', // Awal submit masuk ke Corsec (atau HSE langsung jika skip corsec)
            'work_description' => $request->work_description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // TODO: Simpan File/Dokumen pendukung jika ada

        return redirect()->route('user.work-permit.index')->with('success', 'Work Permit berhasil diajukan! Menunggu Verifikasi.');
    }

    /**
     * Detail WP User
     */
    public function show($id)
    {
        $wp = WorkPermit::with(['employees', 'vendor'])->findOrFail($id);

        // Proteksi: Pastikan WP ini milik Vendor yang sedang login
        if ($wp->vendor_id != 1) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.work_permit_detail', compact('wp'));
    }
}
