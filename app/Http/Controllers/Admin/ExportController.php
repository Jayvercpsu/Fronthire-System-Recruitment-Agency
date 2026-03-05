<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function users(): StreamedResponse
    {
        $headers = ['ID', 'Name', 'Email', 'Role', 'Active', 'Created At'];
        $rows = User::query()
            ->whereIn('role', ['employer', 'job_seeker'])
            ->orderBy('id')
            ->get()
            ->map(fn (User $user): array => [
                $user->id,
                $user->full_name,
                $user->email,
                $user->role,
                $user->is_active ? 'yes' : 'no',
                $user->created_at?->toDateTimeString(),
            ]);

        return $this->csvResponse('users_export.csv', $headers, $rows->all());
    }

    public function jobs(): StreamedResponse
    {
        $headers = ['ID', 'Employer', 'Title', 'Location', 'Job Type', 'Work Setup', 'Status', 'Created At'];
        $rows = Job::query()
            ->with('employer:id,first_name,last_name')
            ->orderBy('id')
            ->get()
            ->map(fn (Job $job): array => [
                $job->id,
                $job->employer?->full_name,
                $job->title,
                $job->location,
                $job->job_type,
                $job->work_setup,
                $job->status,
                $job->created_at?->toDateTimeString(),
            ]);

        return $this->csvResponse('jobs_export.csv', $headers, $rows->all());
    }

    public function applications(): StreamedResponse
    {
        $headers = ['ID', 'Job', 'Applicant', 'Status', 'Applied At'];
        $rows = Application::query()
            ->with(['job:id,title', 'jobSeeker:id,first_name,last_name'])
            ->orderBy('id')
            ->get()
            ->map(fn (Application $application): array => [
                $application->id,
                $application->job?->title,
                $application->jobSeeker?->full_name,
                $application->status,
                $application->created_at?->toDateTimeString(),
            ]);

        return $this->csvResponse('applications_export.csv', $headers, $rows->all());
    }

    private function csvResponse(string $filename, array $headers, array $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows): void {
            $stream = fopen('php://output', 'wb');
            fputcsv($stream, $headers);

            foreach ($rows as $row) {
                fputcsv($stream, $row);
            }

            fclose($stream);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}

