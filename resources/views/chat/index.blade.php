<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

<link rel="stylesheet" href="{{ asset('layouts/assets/images/css/chat.css') }}">

<div class="h-screen flex bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-[24%] min-w-[250px] border-r flex flex-col" style="width: 27%;">
            <div class="p-4 border-b font-semibold text-xl">Chats</div>
            <div class="px-4 py-2">
                <input type="text" id="searchUser" placeholder="Cari atau mulai chat baru"
                class="w-full px-4 py-2 rounded-full border border-gray-700 text-sm bg-[#262d31] text-black focus:ring-2 focus:ring-blue-500" />
            </div>
            
            <div id="user-list" class="flex-1 overflow-y-auto space-y-1 px-2">
                @foreach($users as $user)
                    <button onclick="selectUser({{ $user->id }}, '{{ $user->name }}')"
                        id="user-{{ $user->id }}"
                        data-name="{{ strtolower($user->name)  }}"
                        class="w-full flex items-center px-4 py-2 rounded-xl text-left hover:bg-blue-100 transition">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0"></div>
                        <div class="ml-3 text-white font-medium truncate">
                            {{ $user->name }}
                        </div>
                    </button>
                @endforeach
            </div>
        </aside>

        <!-- Main Chat Area -->
        <main class="flex-1 grid grid-rows-[auto_1fr_auto] h-screen bg-gray-900">
            <!-- Header -->
            <div class="flex items-center p-4 border-b chat-header shadow">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-3"></div>
                <h2 id="chatWith" class="text-lg font-semibold text-white">Pilih pengguna</h2>
            </div>

            <!-- Messages -->
            <div id="messages" class="overflow-y-auto px-6 py-4 space-y-3 scrollTop"
                style="width: 100%; height: calc(100vh - 160px);">
                <!-- Dynamic messages -->
            </div>

            <!-- Preview Gambar & File -->
            <div id="preview-container" class="hidden w-full px-4 pt-2 bg-gray-800">
                <div class="preview-box relative p-4 flex flex-col items-center justify-center">
                    <button type="button" onclick="clearPreview()" class="close-btn absolute top-2 left-2">✕</button>

                    <!-- Preview Gambar -->
                    <img id="preview-image" class="max-w-xs rounded-lg shadow-lg mb-3" style="display: none;" />

                    <!-- Preview File (PDF/DOC/ZIP etc) -->
                    <div id="file-preview" class="hidden text-white flex flex-col items-center gap-2">
                        <img id="file-icon" src="/img/file-icon.png" alt="File Icon" class="w-14 h-14">
                        <div id="file-name" class="text-sm font-semibold truncate max-w-xs text-center"></div>
                        <div id="file-size" class="text-xs text-gray-300"></div>
                    </div>
                </div>
            </div>

            <!-- Form Chat -->
            <form id="chatForm" enctype="multipart/form-data" class="flex items-center gap-3 border-t px-4 py-3 bg-[#202c33]">
                <input type="file" name="file" id="file" hidden accept="image/*" onchange="previewImage(event)">
                
                <!-- Tombol upload -->
                <button type="button" onclick="document.getElementById('file').click()"
                    class="bg-gray-700 text-white p-2 rounded-full hover:bg-gray-600 transition">
                    📎
                </button>

                <!-- Input pesan -->
                <input type="text" id="message" name="message" placeholder="Tulis pesan..."
                    class="flex-1 px-5 py-2 rounded-full border border-gray-700 bg-[#262d31] text-white placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:outline-none" />

                <!-- Tombol kirim -->
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-full transition shadow">
                    Kirim
                </button>
            </form>


            
        </main>
    </div>

    
@include('layouts.script')
</x-app-layout>

