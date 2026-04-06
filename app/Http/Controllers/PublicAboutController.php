<?php

namespace App\Http\Controllers;

use App\Models\CommissionMember;
use Illuminate\Contracts\View\View;

class PublicAboutController extends Controller
{
    public function __invoke(): View
    {
        $members = CommissionMember::query()
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        return view('public.about', [
            'members' => $members,
        ]);
    }
}
