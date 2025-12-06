<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Complaint;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

// Controller untuk mengelola keluhan dari sisi mahasiswa
class ComplaintController extends Controller
{
    public function __construct(protected WhatsAppService $wa)
    {
    }

    // Tampilkan daftar keluhan milik mahasiswa
    public function index()
    {
        $complaints = Complaint::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('student.complaints.index', compact('complaints'));
    }

    // Form buat keluhan baru
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('student.complaints.create', compact('categories'));
    }

    // Simpan keluhan baru + kirim notifikasi WA
    public function store(Request $request, WhatsAppService $whatsApp)
    {
        $data = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'evidence_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $data['user_id'] = auth()->id();
        $data['status']  = 'pending';

        // Upload file bukti jika ada
        if ($request->hasFile('evidence_file')) {
            $data['evidence_file'] = $request->file('evidence_file')->store('complaints', 'public');
        }

        $complaint = Complaint::create($data);
        $complaint->load('category');

        $user = auth()->user();

        // Kirim WA konfirmasi ke mahasiswa
        $templateNew = Setting::getValue('wa_template_new',
            "Halo {nama}, keluhan Anda telah kami terima dengan ID #{id}.\n\nJudul: {judul}\nStatus: {status}\n\nTerima kasih telah melapor."
        );

        $messageToStudent = strtr($templateNew, [
            '{nama}'     => $user->name,
            '{id}'       => $complaint->id,
            '{judul}'    => $complaint->title,
            '{status}'   => ucfirst($complaint->status),
            '{kategori}' => $complaint->category->name ?? 'Umum',
        ]);

        $whatsApp->send($user->phone, $messageToStudent);

        return redirect()
            ->route('student.complaints.index')
            ->with('success', 'Keluhan berhasil dikirim.');
    }

    // Tampilkan detail keluhan beserta respons admin
    public function show(Complaint $complaint)
    {
        abort_unless($complaint->user_id === auth()->id(), 403);

        $complaint->load(['category', 'responses.admin']);

        return view('student.complaints.show', compact('complaint'));
    }

    // Berikan rating dan feedback untuk keluhan yang selesai
    public function rate(Request $request, Complaint $complaint)
    {
        abort_unless($complaint->user_id === auth()->id(), 403);

        if ($complaint->status !== 'selesai') {
            return back()->with('error', 'Anda hanya dapat memberi rating pada keluhan yang sudah selesai.');
        }

        $data = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $complaint->update($data);

        return back()->with('success', 'Terima kasih atas feedback Anda.');
    }
}
