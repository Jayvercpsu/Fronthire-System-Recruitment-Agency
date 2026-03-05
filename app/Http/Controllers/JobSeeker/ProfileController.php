<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobSeeker\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('dashboards.job-seeker.profile', [
            'user' => $user->load(['education', 'experiences', 'resumes']),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if (array_key_exists('skills', $data)) {
            $skills = collect(explode(',', (string) $data['skills']))
                ->map(fn (string $skill): string => trim($skill))
                ->filter()
                ->values()
                ->all();

            $data['skills'] = $skills;
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}

