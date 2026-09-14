@extends('layouts.app')

@section('title', 'Tanya BAKUMDA AI')

@section('content')
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .msg-enter {
            animation: fadeInUp 0.25s ease-out;
        }
        @keyframes bounceDot {
            0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
            40% { transform: scale(1); opacity: 1; }
        }
        .typing-dot {
            animation: bounceDot 1.2s infinite ease-in-out;
        }
        .typing-dot:nth-child(2) { animation-delay: 0.15s; }
        .typing-dot:nth-child(3) { animation-delay: 0.3s; }
    </style>

    <!-- Wrapper Utama: tinggi dikunci via JS berdasarkan tinggi header & bottom-nav yang sebenarnya -->
    <div id="ai-chat-wrapper" class="flex flex-col w-full bg-white text-slate-800 overflow-hidden relative">

        <!-- Area Chat: Satu-satunya area yang bisa di-scroll secara independen -->
        <div id="chat-container" class="flex-1 overflow-y-auto px-4 sm:px-6 py-6 space-y-8 max-w-3xl w-full mx-auto scroll-smooth">

            <!-- Tampilan Awal (Welcome Screen) ala Gemini -->
            <div id="welcome-section" class="h-full flex flex-col items-center justify-center text-center space-y-8 my-auto">
                <h1 class="text-3xl sm:text-5xl font-medium tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-indigo-500 to-rose-500">
                    Halo, {{ Auth::user()->name }}
                </h1>
                <p class="text-slate-400 text-sm sm:text-base -mt-4">Ada yang bisa BAKUMDA AI bantu hari ini?</p>

                <!-- Input Khusus Tampilan Awal -->
                <div class="w-full max-w-2xl">
                    <form id="geminiFormInitial"
                        class="relative bg-slate-50 border border-slate-200 rounded-[28px] px-2 py-2 shadow-sm hover:shadow-md focus-within:border-slate-300 focus-within:shadow-md transition-all">
                        @csrf
                        <div class="flex items-center px-3 py-1.5">
                            <button type="button" class="text-slate-400 hover:text-slate-600 mr-3 transition shrink-0">
                                <i class="fa-solid fa-plus text-sm"></i>
                            </button>
                            <input type="text" id="prompt-initial" name="prompt"
                                placeholder="Tanyakan sesuatu"
                                class="w-full bg-transparent border-none text-sm sm:text-base focus:outline-none text-slate-900 placeholder-slate-400"
                                required autocomplete="off">
                            <button type="submit" id="btnSubmitInitial"
                                class="bg-slate-900 hover:bg-slate-700 active:scale-95 text-white w-9 h-9 rounded-full flex items-center justify-center transition shrink-0 ml-2 disabled:opacity-40 disabled:cursor-not-allowed">
                                <i class="fa-solid fa-arrow-up text-xs"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Suggestion Chips ala Gemini -->
                    <div class="flex flex-wrap justify-center gap-2 mt-4">
                        <button type="button"
                            class="suggestion-chip px-4 py-2 rounded-full border border-slate-200 text-xs sm:text-sm text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition">
                            Jelaskan prosedur bantuan hukum
                        </button>
                        <button type="button"
                            class="suggestion-chip px-4 py-2 rounded-full border border-slate-200 text-xs sm:text-sm text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition">
                            Syarat menjadi anggota BAKUMDA
                        </button>
                        <button type="button"
                            class="suggestion-chip px-4 py-2 rounded-full border border-slate-200 text-xs sm:text-sm text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition">
                            Cara mendaftar pelatihan
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Input Permanen: Duduk menempel rapat di bagian paling bawah kontainer (di atas menu navbar) -->
        <div id="persistent-input-container" class="hidden shrink-0 bg-white px-4 py-3 z-20">
            <div class="max-w-3xl mx-auto">
                <form id="geminiForm"
                    class="relative bg-slate-50 border border-slate-200 rounded-[28px] px-2 py-2 shadow-sm hover:shadow-md focus-within:border-slate-300 focus-within:shadow-md transition-all">
                    @csrf
                    <div class="flex items-center px-3 py-1.5">
                        <button type="button" class="text-slate-400 hover:text-slate-600 mr-3 transition shrink-0">
                            <i class="fa-solid fa-plus text-sm"></i>
                        </button>

                        <input type="text" id="prompt" name="prompt"
                            placeholder="Tanyakan sesuatu"
                            class="w-full bg-transparent border-none text-sm sm:text-base focus:outline-none text-slate-900 placeholder-slate-400"
                            required autocomplete="off">

                        <button type="submit" id="btnSubmit"
                            class="bg-slate-900 hover:bg-slate-700 active:scale-95 text-white w-9 h-9 rounded-full flex items-center justify-center transition shrink-0 ml-2 disabled:opacity-40 disabled:cursor-not-allowed">
                            <i class="fa-solid fa-arrow-up text-xs"></i>
                        </button>
                    </div>
                </form>
                <p class="text-center text-[10px] text-slate-400 mt-2">BAKUMDA AI dapat membuat kesalahan. Periksa kembali info penting.</p>
            </div>
        </div>

    </div>

    <script>
    (() => {
        // ============================================================
        // Kunci tinggi #ai-chat-wrapper berdasarkan tinggi ASLI header
        // & bottom-nav (bukan angka rem yang ditebak), dan nolkan
        // padding-bottom <main> khusus halaman ini supaya wrapper pas
        // persis tanpa memicu scroll dokumen. Hanya berjalan di mobile
        // (#mobile-bottom-nav ada & terlihat); di desktop, container
        // sudah scroll sendiri (h-screen overflow-y-auto).
        // ============================================================
        function isElementVisible(el) {
            return !!el && el.offsetParent !== null;
        }

        function lockChatHeight() {
            const wrapper = document.getElementById('ai-chat-wrapper');
            const header = document.getElementById('mobile-header');
            const bottomNav = document.getElementById('mobile-bottom-nav');
            const mobileMain = document.querySelector('#view-android-container > main');

            if (!wrapper) return;

            if (!isElementVisible(bottomNav)) {
                wrapper.style.height = '';
                wrapper.style.maxHeight = '';
                if (mobileMain) mobileMain.style.paddingBottom = '';
                return;
            }

            const viewportHeight = window.visualViewport
                ? window.visualViewport.height
                : window.innerHeight;

            const headerHeight = header ? header.offsetHeight : 0;
            const navHeight = bottomNav ? bottomNav.offsetHeight : 0;

            const availableHeight = viewportHeight - headerHeight - navHeight;

            wrapper.style.height = availableHeight + 'px';
            wrapper.style.maxHeight = availableHeight + 'px';

            if (mobileMain) mobileMain.style.paddingBottom = '0px';
        }

        lockChatHeight();
        window.addEventListener('resize', lockChatHeight);
        window.addEventListener('orientationchange', lockChatHeight);
        if (window.visualViewport) {
            window.visualViewport.addEventListener('resize', lockChatHeight);
        }

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

            // 🌟 Bubble user: pill abu-abu rata kanan, tanpa avatar (gaya Gemini)
            const userBubble = `
                <div class="msg-enter flex justify-end w-full">
                    <div class="bg-slate-100 text-slate-900 px-4 py-3 rounded-3xl rounded-br-lg max-w-lg text-sm sm:text-base leading-relaxed whitespace-pre-line">
                        ${escapeHtml(userText)}
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

            // 🌟 Loading: ikon spark gradient + tiga dot mantul, tanpa bubble/border (gaya Gemini)
            const aiLoadingId = 'ai-loading-' + Date.now();
            const aiLoadingBubble = `
                <div id="${aiLoadingId}" class="msg-enter flex items-start gap-3 w-full">
                    <div class="bg-gradient-to-tr from-blue-600 via-indigo-500 to-rose-500 rounded-full h-7 w-7 flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fa-solid fa-sparkle text-white text-[10px]"></i>
                    </div>
                    <div class="flex items-center gap-1.5 py-2">
                        <span class="typing-dot w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        <span class="typing-dot w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        <span class="typing-dot w-1.5 h-1.5 rounded-full bg-slate-400"></span>
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
                    // 🌟 Respons AI: tanpa bubble, teks mengalir penuh dengan ikon spark kecil (gaya Gemini)
                    const aiResponseBubble = `
                        <div class="msg-enter flex items-start gap-3 w-full">
                            <div class="bg-gradient-to-tr from-blue-600 via-indigo-500 to-rose-500 rounded-full h-7 w-7 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-sparkle text-white text-[10px]"></i>
                            </div>
                            <div class="text-slate-800 text-sm sm:text-base leading-relaxed whitespace-pre-line pt-0.5">
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
                setTimeout(lockChatHeight, 60);
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

        // 🌟 Suggestion chips: klik untuk langsung mengirim pertanyaan
        document.querySelectorAll('.suggestion-chip').forEach((chip) => {
            chip.addEventListener('click', () => {
                handleFormSubmit(chip.textContent.trim());
            });
        });

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