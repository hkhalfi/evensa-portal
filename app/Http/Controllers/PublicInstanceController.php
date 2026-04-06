<?php

namespace App\Http\Controllers;

use App\Models\EvEnsa\Referentials\Instance;
use Illuminate\Contracts\View\View;

class PublicInstanceController extends Controller
{
    public function index(): View
    {
        $instances = Instance::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('public.instances.index', [
            'instances' => $instances,
        ]);
    }

    public function show(Instance $instance): View
    {
        abort_unless($instance->is_active, 404);

        return view('public.instances.show', [
            'instance' => $instance,
        ]);
    }
}
