@extends('layouts.app')

@section('title', 'Tanya BAKUMDA AI')

@section('content')

    <!-- Wrapper utama halaman dengan latar belakang putih bersih -->
    <div class="flex flex-col h-[calc(100vh-9rem)] bg-white text-slate-800 overflow-hidden relative">

        <!-- Area Konten Utama / Chat Container (Tempat riwayat chat muncul) -->
        <div id="chat-container" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6 max-w-3xl w-full mx-auto scroll-smooth transition-all duration-300">
            
            <!-- Keadaan Awal (Centered Welcome yang akan disembunyikan saat chat dimulai) -->
            <div id="welcome-section" class="h-full flex flex-col items-center justify-center text-center transition-all duration-300">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    Halo {{Auth::user()->name}}, hal apa yang menjadi pokok permasalahan Anda?
                </h1>
            </div>

        </div>

        <!-- Kotak Input Utama (Diposisikan tetap di bawah secara permanen) -->
        <div class="bg-white px-4 py-3 border-t border-slate-100 shrink-0">
            <div class="max-w-3xl mx-auto">
                <form id="geminiForm" class="relative bg-slate-50 border border-slate-200 rounded-3xl p-3 shadow-xl shadow-slate-200/50 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all">
                    @csrf
                    <div class="flex items-center px-3 py-1">
                        <!-- Tombol Plus -->
                        <button type="button" class="text-slate-400 hover:text-slate-700 mr-3 transition">
                            <i class="fa-solid fa-plus text-sm"></i>
                        </button>
                        
                        <!-- Input Field -->
                        <input type="text" id="prompt" name="prompt"
                            placeholder="Minta BAKUMDA AI..."
                            class="w-full bg-transparent border-none text-sm focus:outline-none text-slate-900 placeholder-slate-400"
                            required>
                        
                        <!-- Tombol Kirim / Aksi -->
                        <button type="submit" id="btnSubmit"
                            class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white w-9 h-9 rounded-full flex items-center justify-center transition shadow-md shrink-0 ml-2">
                            <i class="fa-solid fa-arrow-up text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('geminiForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btnSubmit');
            const inputField = document.getElementById('prompt');
            const chatContainer = document.getElementById('chat-container');
            const welcomeSection = document.getElementById('welcome-section');

            const userText = inputField.value.trim();
            if (!userText) return;

            // Jika ini pesan pertama, hilangkan teks sambutan di tengah
            if (welcomeSection) {
                welcomeSection.remove();
            }

            // 1. Tampilkan pesan User ke chat container
            const userBubble = `
                <div class="flex items-start justify-end space-x-3 space-x-reverse w-full mb-4">
                    <div class="bg-blue-600 text-white p-4 rounded-2xl rounded-tr-sm max-w-lg shadow-md text-sm leading-relaxed whitespace-pre-line">
                        ${escapeHtml(userText)}
                    </div>
                    <div class="bg-slate-200 text-slate-700 rounded-xl h-9 w-9 flex items-center justify-center font-bold shrink-0">
                        <i class="fa-solid fa-user text-xs"></i>
                    </div>
                </div>
            `;
            chatContainer.insertAdjacentHTML('beforeend', userBubble);

            // Kosongkan input & scroll ke bawah
            inputField.value = '';
            chatContainer.scrollTop = chatContainer.scrollHeight;

            // 2. Ubah tombol menjadi status loading
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i>';

            // Buat elemen placeholder untuk jawaban AI (loading state)
            const aiLoadingId = 'ai-loading-' + Date.now();
            const aiLoadingBubble = `
                <div id="${aiLoadingId}" class="flex items-start space-x-3 w-full mb-4">
                    <div class="bg-gradient-to-tr from-blue-600 to-indigo-800 text-white rounded-xl h-9 w-9 flex items-center justify-center font-bold shrink-0 shadow-md">
                        <i class="fa-solid fa-robot text-xs text-amber-300"></i>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 text-slate-500 p-4 rounded-2xl rounded-tl-sm shadow-sm text-sm flex items-center space-x-2">
                        <i class="fa-solid fa-spinner fa-spin text-xs"></i>
                        <span>BAKUMDA AI sedang menganalisis...</span>
                    </div>
                </div>
            `;
            chatContainer.insertAdjacentHTML('beforeend', aiLoadingBubble);
            chatContainer.scrollTop = chatContainer.scrollHeight;

            const formData = new FormData(e.target);
            formData.set('prompt', userText);

            try {
                const response = await fetch("{{ route('gemini.ask') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                // Hapus elemen loading AI
                document.getElementById(aiLoadingId).remove();

                if (data.success) {
                    const aiResponseBubble = `
                        <div class="flex items-start space-x-3 w-full mb-4">
                            <div class="bg-gradient-to-tr from-blue-600 to-indigo-800 text-white rounded-xl h-9 w-9 flex items-center justify-center font-bold shrink-0 shadow-md">
                                <i class="fa-solid fa-robot text-xs text-amber-300"></i>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 text-slate-800 p-4 rounded-2xl rounded-tl-sm max-w-xl shadow-sm text-sm leading-relaxed whitespace-pre-line">
                                ${escapeHtml(data.response)}
                            </div>
                        </div>
                    `;
                    chatContainer.insertAdjacentHTML('beforeend', aiResponseBubble);
                } else {
                    alert('Terjadi Kesalahan: ' + (data.error || 'Gagal memproses permintaan.'));
                }
            } catch (err) {
                document.getElementById(aiLoadingId)?.remove();
                alert('Kesalahan jaringan atau server bermasalah.');
            } finally {
                // Kembalikan tombol ke kondisi semula
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-arrow-up text-xs"></i>';
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        });

        // Helper function untuk keamanan teks HTML dasar
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }
    </script>
@endsection