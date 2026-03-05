<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeRequest;
use App\Models\Resume;
use Illuminate\Http\RedirectResponse;

class ResumeController extends Controller
{
    public function store(StoreResumeRequest $request): RedirectResponse
    {
        $file = $request->file('resume');

        $path = $file->store('resumes/'.$request->user()->id, 'public');

        Resume::query()->create([
            'user_id' => $request->user()->id,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
        ]);

        return back()->with('success', 'Resume uploaded successfully.');
    }
}
