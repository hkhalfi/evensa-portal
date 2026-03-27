<?php

namespace App\Http\Controllers;

use App\Models\EvEnsa\Events\Event;
use Illuminate\Contracts\View\View;

class PublicEventController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->with(['instance', 'eventType', 'category', 'venue'])
            ->where('is_published', true)
            ->orderBy('start_at')
            ->get();

        return view('public.events.index', [
            'events' => $events,
        ]);
    }

    public function show(Event $event): View
    {
        abort_unless($event->is_published, 404);

        $event->load(['instance', 'eventType', 'category', 'venue']);

        return view('public.events.show', [
            'event' => $event,
        ]);
    }

    public function home(): View
    {
        $upcomingEvents = Event::query()
            ->with(['instance', 'eventType', 'category', 'venue'])
            ->where('is_published', true)
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->limit(6)
            ->get();

        return view('public.home', [
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
