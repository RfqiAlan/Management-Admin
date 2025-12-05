<x-admin-layout title="Pengaturan WhatsApp" header="Pengaturan WhatsApp">
    <!-- Page Header -->
    <div class="mb-6" data-aos="fade-down">
        <h1 class="text-2xl font-bold text-gray-800">Notifikasi WhatsApp</h1>
        <p class="text-gray-500">Konfigurasi integrasi WhatsApp untuk notifikasi otomatis</p>
    </div>

    <div class="max-w-4xl">
        <div class="glass-card rounded-2xl p-8" data-aos="fade-up">
            <!-- Header -->
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center shadow-lg">
                    <i class="fab fa-whatsapp text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Fonnte API</h2>
                    <p class="text-sm text-gray-500">Integrasi dengan layanan WhatsApp Gateway</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.whatsapp.update') }}" method="POST" class="space-y-8">
                @csrf

                <!-- API Configuration Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- API Token -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-key mr-1 text-green-500"></i>
                            Fonnte API Token
                        </label>
                        <input type="text" name="wa_token" value="{{ old('wa_token', $wa_token) }}"
                               placeholder="Masukkan API Token dari Fonnte"
                               class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all @error('wa_token') border-red-400 @enderror"
                               required>
                        @error('wa_token')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Dapatkan token dari <a href="https://fonnte.com" target="_blank" class="text-green-600 hover:underline">Fonnte.com</a>
                        </p>
                    </div>

                    <!-- Admin Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone mr-1 text-indigo-500"></i>
                            Nomor WhatsApp Admin
                        </label>
                        <input type="text" name="admin_phone" value="{{ old('admin_phone', $admin_phone) }}"
                               placeholder="08xxxxxxxxxx"
                               class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                        <p class="mt-2 text-sm text-gray-500">
                            <i class="fas fa-bell mr-1"></i>
                            Akan menerima notifikasi saat ada laporan baru
                        </p>
                    </div>
                </div>

                <!-- Admin Notification Template -->
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        <i class="fas fa-bell text-indigo-500 mr-2"></i>
                        Notifikasi ke Admin
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Pesan yang dikirim ke admin ketika ada keluhan baru. Placeholder tambahan: 
                        <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">{email}</code>
                        <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">{phone}</code>
                        <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">{kategori}</code>
                        <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">{deskripsi}</code>
                    </p>

                    <div class="p-4 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl border border-indigo-100">
                        <label class="block text-sm font-semibold text-indigo-800 mb-2">
                            <i class="fas fa-bell mr-1"></i>
                            Template Notifikasi Admin (Laporan Baru)
                        </label>
                        <textarea name="tmpl_admin_notif" rows="4"
                                  placeholder="📢 *LAPORAN BARU*&#10;&#10;ID: #{id}&#10;Dari: {nama}&#10;Kategori: {kategori}&#10;Judul: {judul}&#10;&#10;Segera cek dan tindak lanjuti."
                                  class="block w-full px-4 py-3 rounded-xl border-2 border-indigo-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all resize-none text-sm">{{ old('tmpl_admin_notif', $tmpl_admin_notif) }}</textarea>
                    </div>
                </div>

                <!-- Student Templates Section -->
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        <i class="fas fa-user-graduate text-green-500 mr-2"></i>
                        Notifikasi ke Mahasiswa
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Pesan yang dikirim ke mahasiswa. Placeholder: 
                        <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">{nama}</code>
                        <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">{id}</code>
                        <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">{judul}</code>
                        <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">{status}</code>
                        <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">{kategori}</code>
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Complaint Template -->
                        <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
                            <label class="block text-sm font-semibold text-blue-800 mb-2">
                                <i class="fas fa-plus-circle mr-1"></i>
                                Konfirmasi Keluhan Diterima
                            </label>
                            <textarea name="tmpl_new" rows="4"
                                      placeholder="Halo {nama}, keluhan Anda telah kami terima dengan ID #{id}.&#10;&#10;Judul: {judul}&#10;Status: {status}&#10;&#10;Terima kasih."
                                      class="block w-full px-4 py-3 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all resize-none text-sm">{{ old('tmpl_new', $tmpl_new) }}</textarea>
                        </div>

                        <!-- Processed Template -->
                        <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl border border-amber-100">
                            <label class="block text-sm font-semibold text-amber-800 mb-2">
                                <i class="fas fa-spinner mr-1"></i>
                                Status Diproses
                            </label>
                            <textarea name="tmpl_processed" rows="4"
                                      placeholder="Halo {nama}, keluhan #{id} sedang dalam proses penanganan.&#10;&#10;Judul: {judul}&#10;Status: {status}"
                                      class="block w-full px-4 py-3 rounded-xl border-2 border-amber-200 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 transition-all resize-none text-sm">{{ old('tmpl_processed', $tmpl_processed) }}</textarea>
                        </div>

                        <!-- Done Template -->
                        <div class="p-4 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl border border-emerald-100">
                            <label class="block text-sm font-semibold text-emerald-800 mb-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                Status Selesai
                            </label>
                            <textarea name="tmpl_done" rows="4"
                                      placeholder="Halo {nama}, keluhan #{id} telah SELESAI ditangani.&#10;&#10;Judul: {judul}&#10;&#10;Terima kasih atas laporannya!"
                                      class="block w-full px-4 py-3 rounded-xl border-2 border-emerald-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition-all resize-none text-sm">{{ old('tmpl_done', $tmpl_done) }}</textarea>
                        </div>

                        <!-- Rejected Template -->
                        <div class="p-4 bg-gradient-to-br from-rose-50 to-pink-50 rounded-xl border border-rose-100">
                            <label class="block text-sm font-semibold text-rose-800 mb-2">
                                <i class="fas fa-times-circle mr-1"></i>
                                Status Ditolak
                            </label>
                            <textarea name="tmpl_rejected" rows="4"
                                      placeholder="Halo {nama}, mohon maaf keluhan #{id} tidak dapat kami proses.&#10;&#10;Judul: {judul}&#10;&#10;Silakan hubungi admin untuk info lebih lanjut."
                                      class="block w-full px-4 py-3 rounded-xl border-2 border-rose-200 focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 transition-all resize-none text-sm">{{ old('tmpl_rejected', $tmpl_rejected) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit" 
                            class="px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
