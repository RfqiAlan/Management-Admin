<x-app-layout title="Pengaturan WhatsApp">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengaturan Notifikasi WhatsApp
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-xl p-6 space-y-4">

                @if(session('success'))
                    <div class="mb-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg px-4 py-2">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.settings.whatsapp.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Fonnte API Token
                        </label>
                        <input type="text" name="wa_token"
                               value="{{ old('wa_token', $wa_token) }}"
                               class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('wa_token') border-rose-400 @enderror"
                               required>
                        @error('wa_token')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Ambil token dari dashboard Fonnte, lalu tempel di sini.
                        </p>
                    </div>

                    <hr class="my-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Template keluhan baru
                            </label>
                            <textarea name="tmpl_new" rows="3"
                                      class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('tmpl_new', $tmpl_new) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">
                                Placeholder: {nama}, {id}, {judul}, {status}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Template status diproses
                            </label>
                            <textarea name="tmpl_processed" rows="3"
                                      class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('tmpl_processed', $tmpl_processed) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Template status selesai
                            </label>
                            <textarea name="tmpl_done" rows="3"
                                      class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('tmpl_done', $tmpl_done) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Template status ditolak
                            </label>
                            <textarea name="tmpl_rejected" rows="3"
                                      class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('tmpl_rejected', $tmpl_rejected) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
