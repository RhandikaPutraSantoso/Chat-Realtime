<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
            <span class="text-sm text-gray-500">Jam: {{ now()->format('d M Y, H:i') }}</span>
        </div>
    </x-slot>
    <br>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

            {{-- Welcome Card --}}
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                <h3 class="text-xl font-semibold mb-2 text-gray-800">👋 Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-600">
                    Anda berhasil masuk ke <span class="font-medium text-blue-600">CentaChat</span>. Gunakan panel di atas untuk mulai chatting, mengelola percakapan, dan menjelajahi fitur lainnya.
                </p>
            </div>
            <br>
            {{-- Quick Action Cards --}}
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['title' => 'Mulai Chat Baru', 'desc' => 'Buka obrolan dengan pengguna lain secara realtime.'],
                    ['title' => 'Pesan Terakhir', 'desc' => 'Lihat percakapan terbaru Anda.'],
                    ['title' => 'Pengaturan', 'desc' => 'Kelola akun, preferensi, dan tampilan.']
                ] as $item)
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-300 transform hover:-translate-y-1 cursor-pointer">
                        <h4 class="text-lg font-semibold mb-2 text-gray-900">{{ $item['title'] }}</h4>
                        <p class="text-gray-600 text-sm">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
            <br>

            {{-- Chat Statistics --}}

            {{-- Testimonials Swiper --}}
            <div>
                <h2 class="text-center text-gray-800 text-xl font-semibold mb-4">Don't just take our word for it</h2>
                <p class="text-center text-gray-500 mb-8">Lihat apa kata pengguna tentang <strong>CentaChat</strong></p>

                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">

                        {{-- Slide 1 --}}
                        <div class="swiper-slide">
                            <div class="bg-gray-900 text-black p-6 rounded-lg shadow-lg max-w-3xl mx-auto text-center">
                                <p class="text-lg leading-relaxed mb-4">"CentaChat is the best Omegle alternative I've tried! A fantastic way to meet new people."</p>
                                <p class="font-bold">Stranger #1</p>
                                <p class="text-sm text-gray-400">Beta Tester</p>
                            </div>
                        </div>

                        {{-- Slide 2 --}}
                        <div class="swiper-slide">
                            <div class="bg-gray-900 text-black p-6 rounded-lg shadow-lg max-w-3xl mx-auto text-center">
                                <p class="text-lg leading-relaxed mb-4">"I recently felt lonely and struggled to make friends, but CentaChat changed that."</p>
                                <p class="font-bold">Stranger #2</p>
                            </div>
                        </div>

                        {{-- Slide 3 --}}
                        <div class="swiper-slide">
                            <div class="bg-gray-900 text-black p-6 rounded-lg shadow-lg max-w-3xl mx-auto text-center">
                                <p class="text-lg leading-relaxed mb-4">"Skeptical at first, but now I use this more than Omegle. It’s safe, moderated, and fun!"</p>
                                <p class="font-bold">Stranger #3</p>
                            </div>
                        </div>

                    </div>
                    <div class="swiper-pagination mt-6"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Swiper CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{-- Swiper Init --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper(".mySwiper", {
                loop: true,
                spaceBetween: 20,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        });
    </script>
</x-app-layout>
