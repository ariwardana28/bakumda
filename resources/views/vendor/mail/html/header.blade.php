@props(['url'])
<tr>
    <td class="header" style="background-color: #0f172a; padding: 36px 0 24px; text-align: center;">
        <a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
            {{-- Perbesar tinggi dan tambahkan max-width agar logo lebih jelas --}}
            <img src="http://bakumda.or.id/log.png" class="logo" alt="BAKUMDA Logo"
                style="height:75px; width:auto; max-width:260px; object-fit:contain; display:block; margin:0 auto;">
            
            {{-- Ubah warna teks menjadi lebih terang (#94a3b8) agar kontras dan terbaca --}}
            <div style="margin-top:10px; font-size:11px; color:#94a3b8; letter-spacing:2.5px; text-transform:uppercase; font-weight:700;">
                Bantuan Hukum Daerah
            </div>
        </a>
    </td>
</tr>