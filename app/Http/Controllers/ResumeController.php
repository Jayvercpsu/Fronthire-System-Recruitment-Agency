<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeRequest;
use App\Models\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        return back()->with('success', 'Resume uploaded successfully.');
    }

    public function show(Resume $resume): BinaryFileResponse
    {
        $this->authorize('view', $resume);

        $disk = Storage::disk('public');
        abort_unless($disk->exists($resume->file_path), 404);

        $safeName = str_replace('"', '', $resume->original_name);

        return response()->file($disk->path($resume->file_path), [
            'Content-Type' => $resume->mime_type ?: 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="'.$safeName.'"',
        ]);
    }

    public function download(Resume $resume): BinaryFileResponse
    {
        $this->authorize('view', $resume);

        $disk = Storage::disk('public');
        abort_unless($disk->exists($resume->file_path), 404);

        return response()->download(
            $disk->path($resume->file_path),
            $resume->original_name,
            ['Content-Type' => $resume->mime_type ?: 'application/octet-stream']
        );
    }

    public function destroy(Resume $resume): RedirectResponse
    {
        $this->authorize('delete', $resume);

        Storage::disk('public')->delete($resume->file_path);
        $resume->delete();

        return back()->with('success', 'Resume deleted successfully.');
    }
}
