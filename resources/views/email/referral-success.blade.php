   @component('mail::message')
   # Selamat, Klaim Referral Anda Disetujui!

   Halo **{{ $notifiable->name }}**,

   Kabar baik! Permintaan pencairan atau klaim reward referral Anda sebesar **Rp {{ number_format($referralPayment->amount, 0, ',', '.') }}** telah berhasil disetujui oleh tim BAKUMDA.

   {{-- @component('mail::button', ['url' => route('user-referral.index')])
   Lihat Riwayat Referral
   @endcomponent --}}

   Terima kasih telah berpartisipasi aktif memperluas jaringan bersama kami.

   Salam hangat,<br>
   **Tim BAKUMDA**
   @endcomponent