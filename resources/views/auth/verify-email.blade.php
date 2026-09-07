<x-guest-layout>
    <div class="space-y-4 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
            <i class="fa-solid fa-envelope-open-text text-2xl"></i>
        </div>
        <div>
            <h1 class="text-xl font-black text-slate-900">Verifikasi Email Anda</h1>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                Kami telah mengirim tautan verifikasi ke alamat email Anda. Buka Gmail, klik tautan tersebut, lalu akun Anda dapat digunakan.
            </p>
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-xl bg-green-50 p-3 text-center text-sm font-medium text-green-700">
            Tautan verifikasi baru telah dikirim ke email Anda.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="flex items-center gap-2">
                <x-primary-button>
                    Kirim Ulang Email
                </x-primary-button>
                <a href="https://mail.google.com" target="_blank" rel="noopener" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Buka Gmail
                </a>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
