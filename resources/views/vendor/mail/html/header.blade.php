@props(['url'])
<tr>
    <td class="header" style="background-color: #0f172a; padding: 36px 0 24px; text-align: center;">
        <a href="{{ $url ?? 'https://bakumda.or.id' }}" style="display: inline-block; text-decoration: none;">
            {{-- Gunakan HTTPS dan pastikan link gambar aktif secara publik --}}
            <img src="https://bakumda.or.id/log.png" class="logo" alt="BAKUMDA Logo"
                style="height: 75px; width: auto; max-width: 260px; object-fit: contain; display: block; margin: 0 auto; border: 0;">
            
            <div style="margin-top: 10px; font-size: 11px; color: #94a3b8; letter-spacing: 2.5px; text-transform: uppercase; font-weight: 700;">
                Bantuan Hukum Daerah
            </div>
        </a>
    </td>
</tr>