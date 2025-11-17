<?php

// app/Http/Controllers/Admin/ComplaintController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Services\WhatsAppService;
use App\Models\Setting;
use App\Models\ComplaintResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function __construct(protected WhatsAppService $wa)
    {
    }

    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'category']);

        // filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // filter tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // filter mahasiswa (nama/email)
        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->whereHas('user', function ($q) use ($kw) {
                $q->where('name', 'like', "%{$kw}%")
                  ->orWhere('email', 'like', "%{$kw}%");
            });
        }

        $complaints = $query->latest()->paginate(20);

        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'category', 'responses.admin']);

        return view('admin.complaints.show', compact('complaint'));
    }

    public function respond(Request $request, Complaint $complaint, WhatsAppService $whatsApp)
{
    $data = $request->validate([
        'status'     => 'required|in:pending,diproses,selesai,ditolak',
        'note'       => 'required|string',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ]);

    // simpan response admin
    $response = $complaint->responses()->create([
        'admin_id'  => auth()->id(),
        'note'      => $data['note'],
        'attachment'=> $request->hasFile('attachment')
                            ? $request->file('attachment')->store('complaint_responses', 'public')
                            : null,
    ]);

    // update status keluhan
    $complaint->update([
        'status' => $data['status'],
    ]);

    // ====== KIRIM WA KE MAHASISWA ======
    $user  = $complaint->user;
    $phone = $user->phone;

    // pilih template berdasarkan status baru
    $keyTemplate = match ($complaint->status) {
        'diproses' => 'wa_template_processed',
        'selesai'  => 'wa_template_done',
        'ditolak'  => 'wa_template_rejected',
        default    => null,
    };

    if ($keyTemplate) {
        $template = Setting::getValue($keyTemplate, "Keluhan Anda sekarang berstatus {status}.");

        $message = strtr($template, [
            '{nama}'   => $user->name,
            '{id}'     => $complaint->id,
            '{judul}'  => $complaint->title,
            '{status}' => $complaint->status,
        ]);

        $whatsApp->send($phone, $message);
    }
    // ===================================

    return back()->with('success', 'Tindak lanjut dan status keluhan berhasil diperbarui.');
}
}
