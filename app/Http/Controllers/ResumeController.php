<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeRequest;
use App\Models\Resume;
use App\Services\MediaStorageService;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ResumeController extends Controller
{
    public function __construct(
        private readonly MediaStorageService $mediaStorage
    ) {}

    public function store(StoreResumeRequest $request): RedirectResponse
    {
        $file = $request->file('resume');

        $path = $this->mediaStorage->store($file, 'resumes/'.$request->user()->id);

        Resume::query()->create([
            'user_id' => $request->user()->id,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        return back()->with('success', 'Resume uploaded successfully.');
    }

    public function show(Resume $resume): Response
    {
        $this->authorize('view', $resume);

        if ($this->mediaStorage->isRemotePath($resume->file_path)) {
            return redirect()->away($resume->file_path);
        }

        $absolutePath = $this->mediaStorage->localAbsolutePath($resume->file_path);
        abort_unless($absolutePath !== null && file_exists($absolutePath), 404);

        $safeName = str_replace('"', '', $resume->original_name);

        return response()->file($absolutePath, [
            'Content-Type' => $resume->mime_type ?: 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="'.$safeName.'"',
        ]);
    }

    public function download(Resume $resume): Response
    {
        $this->authorize('view', $resume);

        if ($this->mediaStorage->isRemotePath($resume->file_path)) {
            $downloadUrl = $this->mediaStorage->cloudinaryDownloadUrl($resume->file_path) ?? $resume->file_path;

            return redirect()->away($downloadUrl);
        }

        $absolutePath = $this->mediaStorage->localAbsolutePath($resume->file_path);
        abort_unless($absolutePath !== null && file_exists($absolutePath), 404);

        return response()->download(
            $absolutePath,
            $resume->original_name,
            ['Content-Type' => $resume->mime_type ?: 'application/octet-stream']
        );
    }

    public function destroy(Resume $resume): RedirectResponse
    {
        $this->authorize('delete', $resume);

        $this->mediaStorage->delete($resume->file_path);
        $resume->delete();

        return back()->with('success', 'Resume deleted successfully.');
    }
}
