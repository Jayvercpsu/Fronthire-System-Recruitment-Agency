<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobSeeker\StoreEducationRequest;
use App\Http\Requests\JobSeeker\UpdateEducationRequest;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;

class EducationController extends Controller
{
    public function store(StoreEducationRequest $request): RedirectResponse
    {
        $request->user()->education()->create($request->validated());

        return back()->with('success', 'Education entry added.');
    }

    public function update(UpdateEducationRequest $request, Education $education): RedirectResponse
    {
        $this->authorize('update', $education);
        $education->update($request->validated());

        return back()->with('success', 'Education entry updated.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $this->authorize('delete', $education);
        $education->delete();

        return back()->with('success', 'Education entry removed.');
    }
}

