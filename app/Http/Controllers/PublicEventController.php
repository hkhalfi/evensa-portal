<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\EvEnsa\Events\Event;
use App\Models\EvEnsa\Referentials\Instance;
use Illuminate\Contracts\View\View;

class PublicEventController extends Controller
{
    public function home(): View
    {
        $featuredEvents = Event::query()
            ->with(['instance', 'eventType', 'category', 'venue'])
            ->where('status', 'published')
            ->where('is_published', true)
            ->orderBy('start_at')
            ->take(6)
            ->get();

        $featuredInstances = Instance::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->take(6)
            ->get();

        $recentAnnouncements = Announcement::query()
            ->where('status', 'published')
            ->where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        $stats = [
            'active_instances' => Instance::query()
                ->where('is_active', true)
                ->count(),

            'published_events' => Event::query()
                ->where('status', 'published')
                ->where('is_published', true)
                ->count(),

            'upcoming_events' => Event::query()
                ->where('status', 'published')
                ->where('is_published', true)
                ->where('start_at', '>=', now())
                ->count(),

            'archived_events' => Event::query()
                ->where('status', 'archived')
                ->count(),
        ];

        return view('public.home', [
            'featuredEvents' => $featuredEvents,
            'featuredInstances' => $featuredInstances,
            'recentAnnouncements' => $recentAnnouncements,
            'stats' => $stats,
        ]);
    }

    public function index(): View
    {
        $events = Event::query()
            ->with(['instance', 'eventType', 'category', 'venue'])
            ->where('status', 'published')
            ->where('is_published', true)
            ->orderBy('start_at')
            ->paginate(12);

        return view('public.events.index', [
            'events' => $events,
        ]);
    }

    public function show(Event $event): View
    {
        abort_unless(
            $event->status === 'published' && $event->is_published,
            404
        );

        $event->load(['instance', 'eventType', 'category', 'venue', 'eventRequest']);

        return view('public.events.show', [
            'event' => $event,
        ]);
    }
}
