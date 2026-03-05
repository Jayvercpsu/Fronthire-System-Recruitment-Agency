<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserStatusRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()
            ->whereIn('role', ['employer', 'job_seeker'])
            ->latest();

        if ($request->filled('role') && in_array($request->string('role')->toString(), ['employer', 'job_seeker'], true)) {
            $query->where('role', $request->string('role')->toString());
        }

        if ($request->filled('status')) {
            $status = $request->string('status')->toString();
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($searchQuery) use ($search): void {
                $searchQuery->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return view('admin.users.index', [
            'users' => $query->paginate(15)->withQueryString(),
        ]);
    }

    public function show(User $user): View
    {
        abort_if($user->isAdmin(), 404);

        return view('admin.users.show', [
            'user' => $user->load(['employerProfile', 'resumes', 'education', 'experiences']),
            'jobs' => $user->isEmployer()
                ? $user->postedJobs()->withCount('applications')->latest()->paginate(10, ['*'], 'jobs_page')
                : null,
            'applications' => $user->isJobSeeker()
                ? $user->applications()->with(['job:id,title'])->latest()->paginate(10, ['*'], 'applications_page')
                : null,
        ]);
    }

    public function updateStatus(UpdateUserStatusRequest $request, User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403, 'Admin users cannot be deactivated here.');

        $status = (bool) $request->boolean('is_active');

        if ($request->user()->id === $user->id && ! $status) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->is_active = $status;
        $user->save();

        return back()->with('success', 'User status updated.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403, 'Admin users cannot be deleted.');

        if ($request->user()->id === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}

