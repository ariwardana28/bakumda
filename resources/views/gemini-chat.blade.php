@extends('layouts.app')

@section('title', 'Tanya BAKUMDA AI')

@section('content')
    <!-- CDN Marked JS untuk merender Markdown dari AI agar mirip Gemini -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <!-- Wrapper Utama: tinggi dikunci via JS berdasarkan tinggi header & bottom-nav yang sebenarnya.
         min-h-[75vh] adalah fallback CSS murni jika JS gagal menemukan elemen header/bottom-nav
         (misalnya id="mobile-header" / id="mobile-bottom-nav" belum ada di layout). -->
    <div id="ai-chat-wrapper" class="flex flex-col min-h-[75vh] w-full bg-white text-slate-800 overflow-hidden relative">

        <!-- Area Chat / Scrollable Area -->
        <div id="chat-container" class="flex-1 overflow-y-auto px-4 py-6 space-y-6 max-w-3xl w-full mx-auto scroll-smooth">
            
            <!-- Keadaan Awal (Gemini Style Welcome Screen) -->
            <div id="welcome-section" class="h-full flex flex-col justify-center space-y-8 my-auto py-4">
                
                <!-- Greeting Teks dengan Gradasi -->
                <div class="space-y-2">
                    <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight">
                        <span class="bg-gradient-to-r from-blue-600 via-indigo-500 to-amber-500 bg-clip-text text-transparent">
                            Halo, {{ Auth::user()->name }}
                        </span>
                    </h1>
                    <p class="text-2xl sm:text-3xl font-medium text-slate-300">
                       Ada yang bisa BAKUMDA AI bantu hari ini?
                    </p>
                </div>

                <!-- Form Input Awal -->
                <div class="w-full">
                    <form id="geminiFormInitial" class="relative bg-slate-100/80 hover:bg-slate-100 border border-slate-200/80 rounded-3xl p-3 focus-within:bg-white focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all duration-200 shadow-sm">
                        @csrf
                        <div class="flex flex-col space-y-3">
                            <input type="text" id="prompt-initial" name="prompt"
                                placeholder="Tanyakan permasalahan hukum atau umum..."
                                class="w-full bg-transparent border-none text-sm focus:outline-none text-slate-900 placeholder-slate-400 px-2 pt-1"
                                autocomplete="off" required>
                            
                            <div class="flex items-center justify-between pt-2">
                                <div class="flex items-center space-x-2">
                                    <button type="button" class="p-2 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-200/60 transition" title="Lampirkan File">
                                        <i class="fa-solid fa-plus text-sm"></i>
                                    </button>
                                </div>
                                <button type="submit" id="btnSubmitInitial"
                                    class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white w-9 h-9 rounded-full flex items-center justify-center transition shadow-sm shrink-0">
                                    <i class="fa-solid fa-arrow-up text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Chips / Prompt Suggestions Gemini Style -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2">
                    <button type="button" onclick="useSuggestion('Buatkan draf Surat Kuasa khusus')" 
                        class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 rounded-2xl text-left transition group flex flex-col justify-between h-24">
                        <span class="text-xs font-medium text-slate-700 group-hover:text-blue-600 line-clamp-2">Buatkan draf Surat Kuasa khusus</span>
                        <i class="fa-regular fa-file-lines text-slate-400 text-xs self-end"></i>
                    </button>
                    <button type="button" onclick="useSuggestion('Bagaimana prosedur pendirian UMKM?')" 
                        class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 rounded-2xl text-left transition group flex flex-col justify-between h-24">
                        <span class="text-xs font-medium text-slate-700 group-hover:text-blue-600 line-clamp-2">Bagaimana prosedur pendirian UMKM?</span>
                        <i class="fa-solid fa-scale-balanced text-slate-400 text-xs self-end"></i>
                    </button>
                    <button type="button" onclick="useSuggestion('Penjelasan pasal wanprestasi dalam KUHPerdata')" 
                        class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 rounded-2xl text-left transition group flex flex-col justify-between h-24 col-span-2 sm:col-span-1">
                        <span class="text-xs font-medium text-slate-700 group-hover:text-blue-600 line-clamp-2">Penjelasan pasal wanprestasi dalam KUHPerdata</span>
                        <i class="fa-solid fa-book-bookmark text-slate-400 text-xs self-end"></i>
                    </button>
                </div>

            </div>

        </div>

        <!-- Input Permanen Bagian Bawah (Ditampilkan saat percakapan dimulai) -->
        <div id="persistent-input-container" class="hidden shrink-0 bg-white border-t border-slate-100 px-4 py-3 z-20">
            <div class="max-w-3xl mx-auto">
                <form id="geminiForm" class="relative bg-slate-100/80 hover:bg-slate-100 border border-slate-200/80 rounded-3xl p-2.5 focus-within:bg-white focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all duration-200">
                    @csrf
                    <div class="flex items-center px-2">
                        <button type="button" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-200/60 mr-1 transition">
                            <i class="fa-solid fa-plus text-sm"></i>
                        </button>
                        
                        <input type="text" id="prompt" name="prompt"
                            placeholder="Tanyakan sesuatu..."
                            class="w-full bg-transparent border-none text-sm focus:outline-none text-slate-900 placeholder-slate-400 px-2"
                            autocomplete="off" required>
                        
                        <button type="submit" id="btnSubmit"
                            class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white w-8 h-8 rounded-full flex items-center justify-center transition shadow-sm shrink-0 ml-1">
                            <i class="fa-solid fa-arrow-up text-xs"></i>
                        </button>
                    </div>
                </form>
                <p class="text-[10px] text-center text-slate-400 mt-1.5">
                    BAKUMDA AI dapat membuat kesalahan. Periksa kembali informasi penting.
                </p>
            </div>
        </div>

    </div>

    <script>
    (() => {
        // ============================================================
        // 🌟 TAMBAHAN: kunci tinggi #ai-chat-wrapper berdasarkan tinggi
        // ASLI header & bottom-nav (bukan angka rem yang ditebak), dan
        // nolkan padding-bottom <main> khusus halaman ini supaya
        // wrapper pas persis tanpa memicu scroll dokumen.
        // Hanya aktif di mobile (#mobile-bottom-nav ada & terlihat);
        // di desktop, container sudah scroll sendiri (h-screen
        // overflow-y-auto) jadi dibiarkan seperti biasa.
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

            // Nolkan pb-24 pada <main> khusus halaman ini -- wrapper
            // sudah dihitung pas, padding tambahan justru bikin total
            // tinggi kelebihan dan memicu scroll dokumen.
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

        // Fungsi klik prompt chip / suggestion
        window.useSuggestion = function(text) {
            const inputInitial = document.getElementById('prompt-initial');
            if (inputInitial) {
                inputInitial.value = text;
                document.getElementById('geminiFormInitial')?.dispatchEvent(new Event('submit'));
            }
        };

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

            // Bubble Pesan Pengguna (Gemini Style - Right Aligned Neutral Bubble)
            const userBubble = `
                <div class="flex items-start justify-end w-full mb-6">
                    <div class="bg-slate-100 text-slate-800 px-5 py-3.5 rounded-3xl max-w-lg text-sm leading-relaxed whitespace-pre-line">
                        ${escapeHtml(userText)}
                    </div>
                </div>
            `;
            chatContainer.insertAdjacentHTML('beforeend', userBubble);

            // Reset Form Input
            const promptInitial = document.getElementById('prompt-initial');
            const promptPersistent = document.getElementById('prompt');
            if (promptInitial) promptInitial.value = '';
            if (promptPersistent) promptPersistent.value = '';

            scrollToBottom();

            // Ubah State Tombol Loading
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

            // Indikator AI Loading (Sparkle / Star Icon khas Gemini)
            const aiLoadingId = 'ai-loading-' + Date.now();
            const aiLoadingBubble = `
                <div id="${aiLoadingId}" class="flex items-start space-x-3 w-full mb-6">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-500 via-indigo-500 to-amber-400 flex items-center justify-center shrink-0 shadow-sm animate-pulse">
                        <i class="fa-solid fa-sparkles text-white text-xs"></i>
                    </div>
                    <div class="flex items-center space-x-2 pt-1.5 text-slate-400 text-sm">
                        <i class="fa-solid fa-circle-notch fa-spin text-xs text-blue-500"></i>
                        <span>Sedang berpikir...</span>
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
                    // Konversi jawaban Markdown menjadi HTML rapi menggunakan marked.js
                    const parsedResponse = typeof marked !== 'undefined' ? marked.parse(data.response) : escapeHtml(data.response);

                    // Response Gemini Style
                    const aiResponseBubble = `
                        <div class="flex items-start space-x-3 w-full mb-6">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 via-indigo-600 to-amber-500 flex items-center justify-center shrink-0 shadow-sm">
                                <i class="fa-solid fa-sparkles text-white text-xs"></i>
                            </div>
                            <div class="prose prose-slate prose-sm max-w-none text-slate-800 leading-relaxed overflow-hidden pt-1">
                                ${parsedResponse}
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