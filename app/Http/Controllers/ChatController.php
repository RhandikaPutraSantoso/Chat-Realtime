<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    // Tampilkan halaman chat dan semua user
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.index', compact('users'));
    }

    // Kirim pesan teks atau file
    public function send(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta'); // Set timezone ke Jakarta

        // Validasi input
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'nullable|string|max:1000',
            'file'        => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,mp4,mp3,pdf,doc,docx,xls,xlsx',
        ]);

        // Pastikan ada pesan atau file yang dikirim
        if (!$request->filled('message') && !$request->hasFile('file')) {
            return response()->json(['error' => 'Pesan atau file harus diisi.'], 422);
        }

        $filePath = null;

        // Jika ada file, simpan ke storage
        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('chat_files', $filename, 'public'); // Simpan file ke storage/public/chat_files
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan file: ' . $e->getMessage());
                return response()->json(['error' => 'Gagal menyimpan file.'], 500);
            }
        }

        // Simpan pesan ke database
        try {
            $message = Message::create([
                'sender_id'   => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message'     => $request->message ?? '',
                'file_path'   => $filePath,
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan pesan ke database: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan pesan.'], 500);
        }

        // Kirim data pesan ke server Socket.IO eksternal
        try {
            Http::post('http://localhost:3000/message', [
                'message'     => $request->message,
                'sender_id'   => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'file_path'   => $filePath ? asset('storage/' . $filePath) : null,
                'created_at'  => $message->created_at->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim ke Socket Server: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengirim pesan ke server Socket.IO.'], 500);
        }

        return response()->json(['message' => $message]);
    }

    // Ambil semua pesan antara 2 user
    public function fetchMessages($receiverId)
    {
        $messages = Message::where(function ($query) use ($receiverId) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($query) use ($receiverId) {
                $query->where('sender_id', $receiverId)
                      ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // Hapus pesan (hanya oleh pengirim)
    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Hapus file jika ada
        if ($message->file_path && Storage::disk('public')->exists($message->file_path)) {
            Storage::disk('public')->delete($message->file_path);
        }

        $message->delete();
        return response()->json(['success' => true]);
    }
}
