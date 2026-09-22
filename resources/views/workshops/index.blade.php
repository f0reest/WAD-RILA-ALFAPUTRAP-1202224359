<x-app-layout>
    <div class="space-y-6 animate-fade-in">
        <!-- Header Halaman -->
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-bold tracking-wider text-orange-600 uppercase">Module Management</span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight mt-1">
                    Workshop Operations
                </h1>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Konten Modul -->
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-xl font-bold text-slate-900">Daftar Workshop & Antrean Aktif</h3>
            <p class="text-sm text-slate-600">
                Kelola status kendaraan masuk, proses inspeksi, perbaikan, hingga kendaraan siap diambil secara real-time di sini.
            </p>

            <!-- Contoh Tabel Kosong / Data Placeholder -->
            <div class="border border-dashed border-slate-300 rounded-2xl p-8 text-center text-slate-400 text-sm">
                Belum ada data workshop aktif yang terdaftar.
            </div>
        </div>
    </div>
</x-app-layout>