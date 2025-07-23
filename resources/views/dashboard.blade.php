<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">
                Dashboard
            </h2>
            <span class="text-sm text-gray-500">
                Terakhir login: {{ now()->format('d M Y, H:i') }}
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Card -->
            <div class="bg-white border border-gray-200 shadow rounded-2xl p-8 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        👋 Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-gray-700">
                        Anda berhasil masuk ke <span class="font-medium text-blue-600">CentaChat</span>.
                        Gunakan panel di samping untuk mulai chatting, mengelola percakapan, dan menjelajahi fitur lainnya.
                    </p>
                </div>
                <img src="https://iili.io/JYzt4vu.png" alt="Chat Illustration" class="w-28 h-28 hidden sm:block">
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Mulai Chat Baru -->
                <div class="bg-white border border-gray-200 p-6 rounded-xl shadow hover:shadow-md transition">
                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Mulai Chat Baru</h4>
                    <p class="text-sm text-gray-600">Buka obrolan dengan pengguna lain secara realtime.</p>
                </div>

                <!-- Pesan Terakhir -->
                <div class="bg-white border border-gray-200 p-6 rounded-xl shadow hover:shadow-md transition">
                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Pesan Terakhir</h4>
                    <p class="text-sm text-gray-600">Lihat percakapan terbaru Anda.</p>
                </div>

                <!-- Pengaturan -->
                <div class="bg-white border border-gray-200 p-6 rounded-xl shadow hover:shadow-md transition">
                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Pengaturan</h4>
                    <p class="text-sm text-gray-600">Kelola akun, preferensi, dan tampilan.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
