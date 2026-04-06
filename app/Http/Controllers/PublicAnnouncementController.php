<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Contracts\View\View;

class PublicAnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::query()
            ->where('status', 'published')
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(12);

        return view('public.announcements.index', [
            'announcements' => $announcements,
        ]);
    }
}
