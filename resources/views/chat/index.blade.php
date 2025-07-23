<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    body {
        font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
    }
    aside {
        background: #202c33;
        border-right: 1px solid #222d32;
        min-width: 270px;
    }
    .sidebar-header, .p-4.border-b {
        background: #075e54 !important;
        color: #fff !important;
        font-size: 1.2rem;
        font-weight: 600;
        border-bottom: 1px solid #222d32;
        letter-spacing: 1px;
    }
    #user-list button {
        background: transparent;
        border: none;
        width: 100%;
        text-align: left;
        padding: 0.7rem 1rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        transition: background 0.2s;
        cursor: pointer;
        color: #fff;
    }
    #user-list button:hover, #user-list button.bg-blue-100 {
        background: #2a3942;
    }
    #user-list .avatar {
        width: 40px;
        height: 40px;
        background: #bdbdbd;
        border-radius: 50%;
    }
    #messages {
        background: url('{{ asset('layouts/assets/images/pattern-09.png') }}') ; /* url('https://iili.io/FhGQITl.md.png') */
        
        background-color: #222d32;
        padding: 1.5rem 1rem;
        overflow-y: auto;
        flex: 1;
    }
    .message-container {
        display: flex;
        align-items: flex-end;
        margin-bottom: 0.5rem;
    }
    .message-container.me {
        justify-content: flex-end;
    }
    .message-container.them {
        justify-content: flex-start;
    }
    .message-bubble {
        word-wrap: break-word;
        max-width: 400px;
        padding: 0.7rem 1.1rem 1.5rem 1.1rem;
        border-radius: 0.9rem;
        font-size: 1rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.12);
        position: relative;
        margin-bottom: 2px;
        display: inline-block;
    }
    .message-container.me .message-bubble {
        background: #075e54;
        color: #fff;
        border-bottom-right-radius: 0.2rem;
        border-bottom-left-radius: 0.9rem;
    }
    .message-container.them .message-bubble {
        background: #262d31;
        color: #fff;
        border-bottom-left-radius: 0.2rem;
        border-bottom-right-radius: 0.9rem;
    }
    .message-bubble p {
        margin: 0;
        white-space: pre-wrap;
    }
    .message-time {
        font-size: 0.7rem;
        color: #bdbdbd;
        position: absolute;
        right: 14px;
        bottom: 7px;
        margin: 0;
    }
    .message-action {
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s;
        margin: 0 0.5rem;
    }
    .message-container.me:hover .message-action {
        opacity: 1;
        visibility: visible;
    }
    .message-action button {
        background: #fff;
        border-radius: 9999px;
        padding: 0.3rem 0.4rem;
        font-size: 0.85rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.15);
        border: none;
        cursor: pointer;
    }
    #chatForm {
        background: #1f272a;
        padding: 1rem;
        border-top: 1px solid #333;
        display: flex;
        gap: 0.5rem;
    }
    #chatForm input[type="text"] {
        border-radius: 2rem;
        border: 1px solid #444;
        background: #262d31;
        color: #fff;
        padding: 0.7rem 1rem;
        font-size: 1rem;
        flex: 1;
    }
    #chatForm button {
        background: #075e54;
        color: #fff;
        border: none;
        border-radius: 2rem;
        padding: 0.7rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.07);
        transition: background 0.2s;
    }
    #chatForm button:hover {
        background: #128c7e;
    }

    #user-list button.has-unread::after {
    content: '';
    background: red;
    width: 8px;
    height: 8px;
    border-radius: 999px;
    margin-left: auto;
    margin-right: 10px;
    display: inline-block;
    }

</style>

<div class="h-screen flex bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-[24%] min-w-[250px] border-r flex flex-col" style="width: 27%;">
            <div class="p-4 border-b font-semibold text-xl">Chats</div>
            <div class="px-4 py-2">
                <input type="text" placeholder="Cari atau mulai chat baru"
                    class="w-full px-4 py-2 rounded-full border border-gray-700 text-sm bg-[#262d31] text-white focus:ring-2 focus:ring-blue-500" />
            </div>
            <div id="user-list" class="flex-1 overflow-y-auto space-y-1 px-2">
                @foreach($users as $user)
                    <button onclick="selectUser({{ $user->id }}, '{{ $user->name }}')"
                        id="user-{{ $user->id }}"
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

            <!-- Input -->
            <form id="chatForm" enctype="multipart/form-data" class="flex items-center gap-3 border-t px-4 py-3">
                <input type="file" name="file" id="file" hidden accept="image/*" onchange="previewImage(event)">
                <button type="button" onclick="document.getElementById('file').click()"
                    class="bg-gray-700 text-white px-3 py-2 rounded-full hover:bg-gray-600">
                    📎
                </button>
                <input type="text" id="message" name="message" placeholder="Tulis pesan..."
                    class="flex-1 px-5 py-2 rounded-full border border-gray-700 bg-[#262d31] text-white focus:ring-2 focus:ring-green-500" />
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-full shadow">
                    Kirim
                </button>
            </form>

            <div id="preview-container" class="px-4 pt-2 hidden">
                <img id="preview-image" src="" class="w-32 rounded-lg border border-gray-700">
            </div>
        </main>
    </div>

    <!-- Socket.IO -->

</x-app-layout>
