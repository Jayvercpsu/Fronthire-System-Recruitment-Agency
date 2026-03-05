<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobSeeker\StoreExperienceRequest;
use App\Http\Requests\JobSeeker\UpdateExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;

class ExperienceController extends Controller
{
    public function store(StoreExperienceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_current'] = (bool) ($data['is_current'] ?? false);

        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        $request->user()->experiences()->create($data);

        return back()->with('success', 'Experience entry added.');
    }

    public function update(UpdateExperienceRequest $request, Experience $experience): RedirectResponse
    {
        $this->authorize('update', $experience);

        $data = $request->validated();
        $data['is_current'] = (bool) ($data['is_current'] ?? false);

        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        $experience->update($data);

        return back()->with('success', 'Experience entry updated.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $this->authorize('delete', $experience);
        $experience->delete();

        return back()->with('success', 'Experience entry removed.');
    }
}

