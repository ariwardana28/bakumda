@extends('layouts.app')

@section('title', 'Tanya BAKUMDA AI')

@section('content')
    <!-- Wrapper Utama: Mengunci tinggi persis di atas bottom navbar tanpa scrollbar luar -->
    <div class="flex flex-col h-[calc(100vh-4rem-4rem)] max-h-[calc(100vh-4rem-4rem)] w-full bg-white text-slate-800 overflow-hidden relative">

        <!-- Area Chat: Satu-satunya area yang bisa di-scroll secara independen -->
        <div id="chat-container" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6 max-w-3xl w-full mx-auto scroll-smooth">
            
            <!-- Tampilan Awal (Welcome Screen) -->
            <div id="welcome-section" class="h-full flex flex-col items-center justify-center text-center space-y-8 my-auto">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    Halo {{ Auth::user()->name }}, hal apa yang menjadi pokok permasalahan Anda?
                </h1>
                
                <!-- Input Khusus Tampilan Awal -->
                <div class="w-full max-w-xl">
                    <form id="geminiFormInitial" class="relative bg-slate-50 border border-slate-200 rounded-3xl p-3 shadow-xl shadow-slate-200/50 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all">
                        @csrf
                        <div class="flex items-center px-3 py-1">
                            <button type="button" class="text-slate-400 hover:text-slate-700 mr-3 transition">
                                <i class="fa-solid fa-plus text-sm"></i>
                            </button>
                            <input type="text" id="prompt-initial" name="prompt"
                                placeholder="Minta BAKUMDA AI..."
                                class="w-full bg-transparent border-none text-sm focus:outline-none text-slate-900 placeholder-slate-400"
                                required>
                            <button type="submit" id="btnSubmitInitial"
                                class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white w-9 h-9 rounded-full flex items-center justify-center transition shadow-md shrink-0 ml-2">
                                <i class="fa-solid fa-arrow-up text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Input Permanen: Duduk menempel rapat di bagian paling bawah kontainer (di atas menu navbar) -->
        <div id="persistent-input-container" class="hidden shrink-0 bg-white border-t border-slate-100 px-4 py-3 z-20">
            <div class="max-w-3xl mx-auto">
                <form id="geminiForm" class="relative bg-slate-50 border border-slate-200 rounded-3xl p-3 shadow-md focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all">
                    @csrf
                    <div class="flex items-center px-3 py-1">
                        <button type="button" class="text-slate-400 hover:text-slate-700 mr-3 transition">
                            <i class="fa-solid fa-plus text-sm"></i>
                        </button>
                        
                        <input type="text" id="prompt" name="prompt"
                            placeholder="Minta BAKUMDA AI..."
                            class="w-full bg-transparent border-none text-sm focus:outline-none text-slate-900 placeholder-slate-400"
                            required>
                        
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
    (() => {
        function scrollToBottom() {
            const chatContainer = document.getElementById('chat-container');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        }

        async function handleFormSubmit(userText) {
            if (!userText) return;

            const chatContainer = document.getElementById('chat-container');
            const welcomeSection = document.getElementById('welcome-section');
            const persistentInput = document.getElementById('persistent-input-container');

            if (welcomeSection) {
                welcomeSection.remove();
            }
            if (persistentInput) {
                persistentInput.classList.remove('hidden');
            }

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

            const promptInitial = document.getElementById('prompt-initial');
            const promptPersistent = document.getElementById('prompt');
            if (promptInitial) promptInitial.value = '';
            if (promptPersistent) promptPersistent.value = '';

            scrollToBottom();

            const btnInitial = document.getElementById('btnSubmitInitial');
            const btnPersistent = document.getElementById('btnSubmit');
            if (btnInitial) {
                btnInitial.disabled = true;
                btnInitial.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i>';
            }
            if (btnPersistent) {
                btnPersistent.disabled = true;
                btnPersistent.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i>';
            }

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
            scrollToBottom();

            const formData = new FormData();
            formData.append('prompt', userText);

            try {
                const response = await fetch("{{ route('gemini.ask') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("application/json")) {
                    throw new Error("Server mengembalikan respons non-JSON.");
                }

                const data = await response.json();

                document.getElementById(aiLoadingId)?.remove();

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
                alert('Gagal menghubungi server: ' + err.message);
                console.error(err);
            } finally {
                if (btnInitial) {
                    btnInitial.disabled = false;
                    btnInitial.innerHTML = '<i class="fa-solid fa-arrow-up text-xs"></i>';
                }
                if (btnPersistent) {
                    btnPersistent.disabled = false;
                    btnPersistent.innerHTML = '<i class="fa-solid fa-arrow-up text-xs"></i>';
                }
                setTimeout(scrollToBottom, 50);
            }
        }

        const initialForm = document.getElementById('geminiFormInitial');
        if (initialForm) {
            initialForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const userText = document.getElementById('prompt-initial')?.value.trim();
                await handleFormSubmit(userText);
            });
        }

        const persistentForm = document.getElementById('geminiForm');
        if (persistentForm) {
            persistentForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const userText = document.getElementById('prompt')?.value.trim();
                await handleFormSubmit(userText);
            });
        }

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
    })();
    </script>
@endsection