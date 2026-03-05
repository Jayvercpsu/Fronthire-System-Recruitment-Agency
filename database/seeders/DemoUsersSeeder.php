<?php

namespace Database\Seeders;

use App\Models\EmployerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Seed demo non-admin user accounts.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'jobseeker.demo@fronthire.ca'],
            [
                'first_name' => 'John',
                'last_name' => 'Jobseeker',
                'role' => 'job_seeker',
                'phone' => '+1 (403) 701-1001',
                'email_verified_at' => now(),
                'password' => Hash::make('JobSeek@12345'),
            ]
        );

        $employer = User::query()->updateOrCreate(
            ['email' => 'employer.demo@fronthire.ca'],
            [
                'first_name' => 'Emma',
                'last_name' => 'Employer',
                'role' => 'employer',
                'phone' => '+1 (403) 701-1002',
                'email_verified_at' => now(),
                'password' => Hash::make('Employ@12345'),
            ]
        );

        EmployerProfile::query()->updateOrCreate(
            ['user_id' => $employer->id],
            [
                'company_name' => 'Demo Employer Inc.',
                'industry' => 'Staffing',
                'website' => 'https://example.com',
                'phone' => '+1 (403) 701-1002',
                'address' => 'Calgary, Alberta',
                'about' => 'Demo employer profile for dashboard testing.',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'jobseeker.two@fronthire.ca'],
            [
                'first_name' => 'Mia',
                'last_name' => 'Applicant',
                'role' => 'job_seeker',
                'phone' => '+1 (403) 701-2001',
                'email_verified_at' => now(),
                'password' => Hash::make('JobSeek2@12345'),
            ]
        );

        $secondEmployer = User::query()->updateOrCreate(
            ['email' => 'employer.two@fronthire.ca'],
            [
                'first_name' => 'Noah',
                'last_name' => 'Recruiter',
                'role' => 'employer',
                'phone' => '+1 (403) 701-2002',
                'email_verified_at' => now(),
                'password' => Hash::make('Employ2@12345'),
            ]
        );

        EmployerProfile::query()->updateOrCreate(
            ['user_id' => $secondEmployer->id],
            [
                'company_name' => 'NorthPeak Staffing Ltd.',
                'industry' => 'Recruitment',
                'website' => 'https://northpeak.example',
                'phone' => '+1 (403) 701-2002',
                'address' => 'Calgary, Alberta',
                'about' => 'Second demo employer account for testing workflows.',
            ]
        );
    }
}
