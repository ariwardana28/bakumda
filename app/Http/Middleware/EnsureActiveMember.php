<?php

namespace App\Http\Middleware;

use App\Models\Anggota;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveMember
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $anggota = Anggota::with(['card.latestStatus', 'card.latestBerlaku'])
            ->where('user_id', $user->id)
            ->first();

        if (! $anggota || ! $anggota->isActive()) {
            return redirect()
                ->route('user-anggota.index')
                ->with('error', 'Fitur ini hanya untuk anggota BAKUMDA dengan status aktif.');
        }

        return $next($request);
    }
}