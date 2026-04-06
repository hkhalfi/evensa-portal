<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\EvEnsa\Events\Event;
use App\Models\EvEnsa\Referentials\Instance;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredEvents = Event::query()
            ->where('status', 'published')
            ->where('is_published', true)
            ->latest('published_at')
            ->take(6)
            ->get();

        $instances = Instance::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->take(6)
            ->get();

        return view('public.home', [
            'featuredEvents' => $featuredEvents,
            'instances' => $instances,
        ]);
    }
}
