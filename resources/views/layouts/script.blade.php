    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>

    <script>
        const socket = io('http://localhost:3000');
        const myId = {{ Auth::id() }};
        let receiverId = null;

        const messagesBox = document.getElementById('messages');
        const messageInput = document.getElementById('message');
        const chatWithTitle = document.getElementById('chatWith');

        socket.on('connect', () => {
            console.log('✅ Connected to Socket.IO as', myId);
            socket.emit('join', myId);
        });

        function selectUser(id, name) {
            receiverId = id;
            chatWithTitle.textContent = name;

            // Hapus highlight semua
            document.querySelectorAll('#user-list button').forEach(btn =>
                btn.classList.remove('bg-blue-100')
            );
            // Highlight user yang dipilih
            document.getElementById('user-' + id).classList.add('bg-blue-100');
            // Reset tanda unread
            document.getElementById(`user-${id}`).classList.remove('has-unread');

            // Gabung room socket bersama lawan chat
            socket.emit('join_room', { userId1: myId, userId2: id });

            fetchMessages(id);
        }

        function fetchMessages(userId) {
            fetch(`/chat/messages/${userId}`)
                .then(res => res.json())
                .then(data => {
                    messagesBox.innerHTML = '';
                    data.forEach(msg => appendMessage(msg));
                    scrollToBottom();
                });
        }

        document.getElementById('chatForm').addEventListener('submit', function (e) {
            e.preventDefault();
            if (!receiverId) return;

            const msgText = messageInput.value.trim();
            const fileInput = document.getElementById('file');

            if (!msgText && !fileInput.files[0]) return;

            // Kirim pesan lewat API (sesuaikan endpoint dan headers jika perlu)
            const formData = new FormData();
            formData.append('sender_id', myId);
            formData.append('receiver_id', receiverId);
            formData.append('message', msgText);

            if (fileInput.files[0]) {
                formData.append('file', fileInput.files[0]);
            }

            fetch('/chat/send', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                if (data.message) {
                    scrollToBottom();

                    // Clear input dan preview
                    messageInput.value = '';
                    fileInput.value = '';
                    document.getElementById('preview-container').style.display = 'none';
                }
            });
        });

        function appendMessage(msg, isMe = null) {
    if (isMe === null) isMe = msg.sender_id == myId;

    const time = new Date(msg.created_at || Date.now()).toLocaleTimeString([], {
        hour: '2-digit', minute: '2-digit'
    });

    const wrapper = document.createElement('div');
    wrapper.className = `message-container ${isMe ? 'me' : 'them'}`;

    let content = '';

    if (msg.file_path) {
        const ext = msg.file_path.split('.').pop().toLowerCase();

        // Tampilkan sebagai gambar jika ekstensi termasuk dalam daftar
        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (imageExtensions.includes(ext)) {
            const isFullUrl = msg.file_path.startsWith('http://') || msg.file_path.startsWith('https://');
            const imageSrc = isFullUrl ? msg.file_path : `/storage/${msg.file_path}`;

            content += `<img src="${imageSrc}" class="w-48 rounded-lg mb-2 shadow-md border">`;

        } else {
            
            const isFullUrl = msg.file_path.startsWith('http://') || msg.file_path.startsWith('https://');
            const fileUrl = isFullUrl ? msg.file_path : `/storage/${msg.file_path}`;
            const filename = msg.file_path.split('/').pop();

            content += `
                <a href="${fileUrl}" target="_blank" class="block text-blue-500 underline mb-2">
                    📎 ${filename}
                </a>
            `;

        }
    }

    if (msg.message) {
        content += `<p>${msg.message}</p>`;
    }

    wrapper.innerHTML = `
        <div class="message-bubble">${content}
            <span class="message-time">${time}</span>
        </div>
        ${isMe ? `<div class="message-action"><button onclick="deleteMessage(${msg.id}, this)">🗑️</button></div>` : ''}
    `;

    messagesBox.appendChild(wrapper);
}


                socket.on('new_message', (msg) => {
            const isCurrentChat = (msg.sender_id == receiverId && msg.receiver_id == myId) ||
                                (msg.sender_id == myId && msg.receiver_id == receiverId);

            if (isCurrentChat) {
                // Tunggu beberapa ratus milidetik agar file tersimpan di server
                appendMessage(msg);
                scrollToBottom();
                
            } else {
                const btn = document.getElementById(`user-${msg.sender_id}`);
                if (btn && !btn.classList.contains('bg-blue-100')) {
                    btn.classList.add('has-unread');
                }
            }
        });


        function deleteMessage(id, el) {
            if (!confirm("Hapus pesan ini?")) return;

            fetch(`/chat/message/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(res => res.json())
              .then(data => {
                  if (data.success) {
                      el.closest('.message-container').remove();
                  }
              });
        }

        function scrollToBottom() {
            messagesBox.scrollTo({ top: messagesBox.scrollHeight, behavior: 'smooth' });
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview-container').style.display = 'block';
                    document.getElementById('preview-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>