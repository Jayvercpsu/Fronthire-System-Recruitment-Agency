<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function employers(): View
    {
        return view('pages.employers');
    }

    public function jobSeekers(Request $request): View
    {
        $latestResume = null;

        if ($request->user() && $request->user()->role === 'job_seeker') {
            $latestResume = $request->user()->resumes()->latest()->first();
        }

        return view('pages.job-seekers', [
            'latestResume' => $latestResume,
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }
}
