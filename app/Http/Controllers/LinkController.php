<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request; // Pastikan Request di-import

class LinkController extends Controller
{
    public function handleRedirect(Request $request, $slug)
    {
        $link = Link::where('slug', $slug)->firstOrFail();

        // Daftar User Agent robot/crawler yang kita kenali
        $botUserAgents = [
            'facebookexternalhit',
            'Facebot',
            'Twitterbot',
            'Pinterest',
            'LinkedInBot',
            'WhatsApp',
            'TelegramBot',
        ];

        // Gabungkan daftar menjadi satu pola regex
        $botPattern = '/' . implode('|', $botUserAgents) . '/i';

        // Cek apakah User Agent pengunjung cocok dengan pola bot
        if (preg_match($botPattern, $request->userAgent())) {
            // JIKA PENGUNJUNG ADALAH BOT:
            // Tampilkan halaman dengan meta tags, tanpa redirect.
            return view('link-redirect', compact('link'));
        }

        // JIKA PENGUNJUNG ADALAH MANUSIA:
        // Tambah jumlah klik dan langsung redirect ke tujuan.
        $link->increment('clicks');
        return redirect()->away($link->target_url);
    }
}