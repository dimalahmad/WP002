<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkPermit;
use App\Models\Vendor;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Models\RiskWork;
use App\Models\SafetyEquipment;

class HseController extends Controller
{
    // =========================================================================
    // WORK PERMIT MANAGEMENT
    // =========================================================================

    public function index()
    {
        // Ambil WP yang statusnya 'Waiting HSE' untuk tab Review
        // Dan 'Scheduled' untuk tab Jadwal Induction
        $waitingWps = WorkPermit::with('vendor')
            ->where('status', WorkPermit::STATUS_WAITING_HSE)
            ->get();

        $scheduledWps = WorkPermit::with('vendor')
            ->where('status', WorkPermit::STATUS_SCHEDULED)
            ->get();

        return view('hse.work-permit-hse', compact('waitingWps', 'scheduledWps'));
    }

    public function history()
    {
        // History: Active, Expired, Rejected, Finished
        $historyWps = WorkPermit::with('vendor')
            ->whereIn('status', [
                WorkPermit::STATUS_ACTIVE,
                WorkPermit::STATUS_EXPIRED,
                WorkPermit::STATUS_REJECTED,
                WorkPermit::STATUS_FINISHED
            ])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('hse.work_permit_history', compact('historyWps'));
    }

    public function detail($id)
    {
        // Detil WP, beserta relasi Employees
        $wp = WorkPermit::with(['vendor', 'employees'])->findOrFail($id);

        return view('hse.work_permit_detail', compact('wp'));
    }

    // =========================================================================
    // ACTIONS: APPROVE, REJECT, SCHEDULE
    // =========================================================================

    public function scheduleInduction(Request $request, $id)
    {
        $request->validate([
            'induction_schedule' => 'required|date'
        ]);

        $wp = WorkPermit::findOrFail($id);

        // Update Status & Jadwal
        $wp->update([
            'status' => WorkPermit::STATUS_SCHEDULED,
            'induction_schedule' => $request->induction_schedule
        ]);

        return redirect()->route('hse.work-permit-hse')->with('success', 'Safety Induction berhasil dijadwalkan.');
    }

    public function validateInduction(Request $request, $id)
    {
        // Validasi Upload Bukti & Tanda Tangan
        // (Untuk prototype ini kita simpan path dummy/base64 saja)

        $wp = WorkPermit::findOrFail($id);

        // Simpan Bukti (Mockup)
        // Di real app: $path = $request->file('evidence')->store(...);

        $wp->update([
            'status' => WorkPermit::STATUS_ACTIVE,
            'induction_evidence_path' => 'evidence_dummy.pdf', // Mockup
            'hse_validation_signature' => 'SIGNED_BY_HSE_ADMIN', // Mockup
        ]);

        // Opsional: Update status individu pegawai jika perlu
        // DB::table('work_permit_employees')->where('work_permit_id', $id)->update(['induction_status' => 'passed']);

        return redirect()->route('hse.work_permit_history')->with('success', 'Work Permit Resmi AKTIF.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['reject_reason' => 'required']);

        $wp = WorkPermit::findOrFail($id);
        $wp->update([
            'status' => WorkPermit::STATUS_REJECTED,
            'rejection_note' => $request->reject_reason
        ]);

        return redirect()->route('hse.work-permit-hse')->with('error', 'Work Permit Ditolak.');
    }

    // =========================================================================
    // BLACKLIST MANAGEMENT
    // =========================================================================

    public function blacklistIndex()
    {
        // Ambil data blacklist dinamis
        $blacklistedOS = Employee::where('is_blacklisted', true)->get();
        $blacklistedVendors = Vendor::where('status', 'blacklisted')->get();

        // Data untuk Autocomplete (Ambil data yang BELUM blacklist)
        // Batasi 100 agar tidak berat di view (atau pakai AJAX next phase)
        $osAutocomplete = Employee::where('is_blacklisted', false)
            ->take(200)
            ->get()
            ->map(fn($e) => $e->name . ' - ' . $e->nik);

        $vendorAutocomplete = Vendor::where('status', '!=', 'blacklisted')
            ->pluck('name');

        return view('hse.master-blacklist', compact('blacklistedOS', 'blacklistedVendors', 'osAutocomplete', 'vendorAutocomplete'));
    }

    // =========================================================================
    // MASTER IKB & SAFETY EQUIPMENT
    // =========================================================================

    public function ikbIndex()
    {
        $ikbs = RiskWork::all();
        return view('hse.master-ikb', compact('ikbs'));
    }

    public function apdIndex()
    {
        $apds = SafetyEquipment::where('type', 'apd')->get();
        return view('hse.master-apd', compact('apds'));
    }

    public function pengamanIndex()
    {
        $pengamans = SafetyEquipment::where('type', 'safety_device')->get();
        return view('hse.master-pengaman', compact('pengamans'));
    }

    // --- IKB Management ---

    public function ikbCreate()
    {
        $apds = SafetyEquipment::where('type', 'apd')->get();
        $safeties = SafetyEquipment::where('type', 'safety_device')->get();
        return view('hse.master_ikb_create', compact('apds', 'safeties'));
    }

    public function ikbEdit($id)
    {
        $ikb = RiskWork::findOrFail($id);
        $apds = SafetyEquipment::where('type', 'apd')->get();
        $safeties = SafetyEquipment::where('type', 'safety_device')->get();
        return view('hse.master_ikb_edit', compact('ikb', 'apds', 'safeties'));
    }

    public function storeIKB(Request $request)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255|unique:risk_works,name',
        ], [
            'nama_pekerjaan.required' => 'Nama pekerjaan tidak boleh kosong.',
            'nama_pekerjaan.unique' => 'Nama pekerjaan ini sudah terdaftar.',
            'nama_pekerjaan.max' => 'Nama pekerjaan maksimal 255 karakter.',
        ]);

        RiskWork::create([
            'name' => $request->nama_pekerjaan,
            'recommended_apd' => $request->apd ?? [],
            'recommended_safety' => $request->pengaman ?? [],
        ]);

        return redirect()->route('hse.master-ikb')->with('success', 'Jenis Pekerjaan Berbahaya berhasil ditambahkan.');
    }

    public function updateIKB(Request $request, $id)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255|unique:risk_works,name,' . $id,
        ], [
            'nama_pekerjaan.required' => 'Nama pekerjaan tidak boleh kosong.',
            'nama_pekerjaan.unique' => 'Nama pekerjaan ini sudah terdaftar.',
            'nama_pekerjaan.max' => 'Nama pekerjaan maksimal 255 karakter.',
        ]);

        $ikb = RiskWork::findOrFail($id);
        $ikb->update([
            'name' => $request->nama_pekerjaan,
            'recommended_apd' => $request->apd ?? [],
            'recommended_safety' => $request->pengaman ?? [],
        ]);

        return redirect()->route('hse.master-ikb')->with('success', 'Jenis Pekerjaan Berbahaya berhasil diperbarui.');
    }

    // --- Safety Equipment (APD & Pengaman) Management ---

    public function storeSafetyEquipment(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Unik berdasarkan name + type
                function ($attribute, $value, $fail) use ($request) {
                    if (SafetyEquipment::where('name', $value)->where('type', $request->type)->exists()) {
                        $fail('Data ' . $value . ' sudah ada di database.');
                    }
                },
            ],
            'type' => 'required|in:apd,safety_device'
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'name.max' => 'Nama maksimal 255 karakter.',
        ]);

        SafetyEquipment::create([
            'name' => $request->name,
            'type' => $request->type
        ]);

        return back()->with('success', 'Data baru berhasil ditambahkan.');
    }

    public function updateSafetyEquipment(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Unik update ignore ID
                function ($attribute, $value, $fail) use ($request, $id) {
                    if (
                        SafetyEquipment::where('name', $value)
                            ->where('type', $request->type)
                            ->where('id', '!=', $id)
                            ->exists()
                    ) {
                        $fail('Data ' . $value . ' sudah ada di database.');
                    }
                },
            ],
            'type' => 'required|in:apd,safety_device'
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'name.max' => 'Nama maksimal 255 karakter.',
        ]);

        $item = SafetyEquipment::findOrFail($id);
        $item->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    // Helper Cleaner (Called once)
    public function cleanDuplicates()
    {
        // Clean SafetyEquipment
        $se = SafetyEquipment::all();
        $uniqueSe = $se->unique(function ($item) {
            return $item->type . '-' . strtolower(trim($item->name));
        });
        $duplicatesSe = $se->diff($uniqueSe);
        SafetyEquipment::destroy($duplicatesSe->pluck('id'));

        // Clean RiskWork
        $rw = RiskWork::all();
        $uniqueRw = $rw->unique(function ($item) {
            return strtolower(trim($item->name));
        });
        $duplicatesRw = $rw->diff($uniqueRw);
        RiskWork::destroy($duplicatesRw->pluck('id'));

        return "Duplicates removed: " . $duplicatesSe->count() . " APD/Safeties and " . $duplicatesRw->count() . " IKBs.";
    }
}
