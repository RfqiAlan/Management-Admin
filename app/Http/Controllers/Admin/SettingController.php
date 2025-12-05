<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function editWhatsApp()
    {
        return view('admin.settings.whatsapp', [
            'wa_token'            => Setting::getValue('wa_token'),
            'admin_phone'         => Setting::getValue('admin_phone'),
            'tmpl_new'            => Setting::getValue('wa_template_new'),
            'tmpl_admin_notif'    => Setting::getValue('wa_template_admin_notif'),
            'tmpl_processed'      => Setting::getValue('wa_template_processed'),
            'tmpl_done'           => Setting::getValue('wa_template_done'),
            'tmpl_rejected'       => Setting::getValue('wa_template_rejected'),
        ]);
    }

    public function updateWhatsApp(Request $request)
    {
        $data = $request->validate([
            'wa_token'         => 'required|string',
            'admin_phone'      => 'nullable|string',
            'tmpl_new'         => 'nullable|string',
            'tmpl_admin_notif' => 'nullable|string',
            'tmpl_processed'   => 'nullable|string',
            'tmpl_done'        => 'nullable|string',
            'tmpl_rejected'    => 'nullable|string',
        ]);

        Setting::setValue('wa_token', $data['wa_token']);
        Setting::setValue('admin_phone', $data['admin_phone'] ?? '');
        Setting::setValue('wa_template_new', $data['tmpl_new'] ?? '');
        Setting::setValue('wa_template_admin_notif', $data['tmpl_admin_notif'] ?? '');
        Setting::setValue('wa_template_processed', $data['tmpl_processed'] ?? '');
        Setting::setValue('wa_template_done', $data['tmpl_done'] ?? '');
        Setting::setValue('wa_template_rejected', $data['tmpl_rejected'] ?? '');

        return back()->with('success', 'Pengaturan WhatsApp berhasil disimpan.');
    }
}
