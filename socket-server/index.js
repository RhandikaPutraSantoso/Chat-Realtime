// server.js
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: '*', // Batasi di production
        methods: ['GET', 'POST']
    }
});

// Menyimpan userId dan socket.id
const connectedUsers = new Map();

// Fungsi generate roomId dari 2 userId (urut supaya konsisten)
function getRoomId(userId1, userId2) {
    return [userId1, userId2].sort().join('_');
}

// Socket.IO auth middleware (opsional)
io.use((socket, next) => {
    console.log(`[AUTH] Socket ${socket.id} mencoba terhubung.`);
    next();
});

// Saat client terhubung
io.on('connection', (socket) => {
    console.log(`[SOCKET] Terhubung: ${socket.id}`);

    // Saat user join dan kirim ID-nya
    socket.on('join', (userId) => {
        if (!userId) {
            socket.emit('error', 'User ID dibutuhkan');
            return;
        }
        connectedUsers.set(userId, socket.id);
        console.log(`[JOIN] User ${userId} dengan Socket ${socket.id} tersimpan.`);
        socket.emit('joined', 'Berhasil join');
    });

    // User join ke room chat private
    socket.on('join_room', ({ userId1, userId2 }) => {
        if (!userId1 || !userId2) {
            socket.emit('error', 'User ID untuk room dibutuhkan');
            return;
        }
        const roomId = getRoomId(userId1, userId2);
        socket.join(roomId);
        console.log(`[ROOM] Socket ${socket.id} bergabung ke room ${roomId}`);
        socket.emit('joined_room', roomId);
    });

    // Disconnect handler
    socket.on('disconnect', () => {
        for (let [userId, sId] of connectedUsers.entries()) {
            if (sId === socket.id) {
                connectedUsers.delete(userId);
                console.log(`[DISCONNECT] User ${userId} (${socket.id}) keluar.`);
                break;
            }
        }
    });

    socket.on('error', (err) => {
        console.error(`[SOCKET ERROR] ${socket.id}:`, err.message);
    });
});

// Middleware validasi request kirim pesan
app.use('/message', (req, res, next) => {
    const { sender_id, receiver_id } = req.body;
    if (!sender_id || !receiver_id || (!req.body.message && !req.body.file_path)) {
        return res.status(400).json({
            error: 'Wajib ada sender_id, receiver_id, dan salah satu dari message atau file_path.'
        });
    }
    next();
});

// Endpoint POST untuk kirim pesan ke room chat
app.post('/message', (req, res) => {
    const { sender_id, receiver_id, message, file_path } = req.body;

    const payload = {
        sender_id,
        receiver_id,
        message: message || null,
        file_path: file_path || null,
        created_at: new Date().toISOString()
    };

    const roomId = getRoomId(sender_id, receiver_id);

    io.to(roomId).emit('new_message', payload);
    console.log(`[BROADCAST ROOM] ke room ${roomId}:`, payload);

    return res.status(200).json({
        status: 'Pesan terkirim ke room chat.',
        message: payload
    });
});

// Jalankan server
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`✅ Socket.IO Server aktif di http://localhost:${PORT}`);
});

// Shutdown handler
['SIGTERM', 'SIGINT'].forEach(signal => {
    process.on(signal, () => {
        console.log(`📴 ${signal} diterima. Menutup server.`);
        server.close(() => {
            console.log('Server dimatikan.');
            process.exit(0);
        });
    });
});
