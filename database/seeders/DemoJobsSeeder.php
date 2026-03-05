<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoJobsSeeder extends Seeder
{
    public function run(): void
    {
        $employer = User::query()
            ->where('role', 'employer')
            ->where('email', 'employer.demo@fronthire.ca')
            ->first();

        if (! $employer) {
            return;
        }

        $jobs = [
            [
                'title' => 'Warehouse Associate',
                'location' => 'Calgary, AB',
                'job_type' => 'full_time',
                'work_setup' => 'onsite',
                'salary_min' => 35000,
                'salary_max' => 42000,
                'currency' => 'CAD',
                'description' => 'Handle receiving, sorting, picking, packing, and stock counting. Maintain a safe and organized warehouse while meeting daily output targets.',
                'requirements' => '1+ year warehouse experience preferred. Can lift up to 23kg, use scanners, and follow safety protocols.',
                'required_skills' => ['inventory management', 'forklift operation', 'packing'],
            ],
            [
                'title' => 'Customer Support Specialist',
                'location' => 'Calgary, AB',
                'job_type' => 'full_time',
                'work_setup' => 'hybrid',
                'salary_min' => 42000,
                'salary_max' => 50000,
                'currency' => 'CAD',
                'description' => 'Support customers through email and phone, resolve account issues, and collaborate with internal teams to improve service quality.',
                'requirements' => 'Strong communication, CRM familiarity, and attention to detail.',
                'required_skills' => ['customer service', 'communication', 'crm'],
            ],
            [
                'title' => 'Data Entry Clerk',
                'location' => 'Calgary, AB',
                'job_type' => 'part_time',
                'work_setup' => 'remote',
                'salary_min' => 22000,
                'salary_max' => 29000,
                'currency' => 'CAD',
                'description' => 'Enter and validate client records, maintain data accuracy, and prepare basic reports for operations and payroll teams.',
                'requirements' => 'Fast and accurate typing, strong Excel skills, and confidentiality handling.',
                'required_skills' => ['excel', 'data entry', 'attention to detail'],
            ],
            [
                'title' => 'HR Recruitment Assistant',
                'location' => 'Calgary, AB',
                'job_type' => 'contract',
                'work_setup' => 'hybrid',
                'salary_min' => 45000,
                'salary_max' => 56000,
                'currency' => 'CAD',
                'description' => 'Coordinate interviews, screen candidate profiles, and maintain recruitment pipelines for high-volume staffing campaigns.',
                'requirements' => 'Experience in recruitment coordination and strong scheduling skills.',
                'required_skills' => ['recruitment', 'interview coordination', 'communication'],
            ],
            [
                'title' => 'Forklift Operator',
                'location' => 'Airdrie, AB',
                'job_type' => 'full_time',
                'work_setup' => 'onsite',
                'salary_min' => 40000,
                'salary_max' => 48000,
                'currency' => 'CAD',
                'description' => 'Operate sit-down and stand-up forklifts, move goods safely, and complete loading documentation during shifts.',
                'requirements' => 'Valid forklift certification and warehouse safety awareness.',
                'required_skills' => ['forklift operation', 'safety compliance', 'loading'],
            ],
            [
                'title' => 'Administrative Assistant',
                'location' => 'Calgary, AB',
                'job_type' => 'temporary',
                'work_setup' => 'onsite',
                'salary_min' => 36000,
                'salary_max' => 43000,
                'currency' => 'CAD',
                'description' => 'Manage office documents, schedule meetings, coordinate with departments, and provide front-desk support.',
                'requirements' => 'Excellent organization and document management skills.',
                'required_skills' => ['scheduling', 'document management', 'microsoft office'],
            ],
            [
                'title' => 'Junior Web Support Intern',
                'location' => 'Calgary, AB',
                'job_type' => 'internship',
                'work_setup' => 'remote',
                'salary_min' => 18000,
                'salary_max' => 22000,
                'currency' => 'CAD',
                'description' => 'Assist with website content updates, QA checks, and basic front-end fixes under supervision of senior developers.',
                'requirements' => 'Basic HTML/CSS knowledge and eagerness to learn.',
                'required_skills' => ['html', 'css', 'troubleshooting'],
            ],
        ];

        foreach ($jobs as $payload) {
            Job::query()->updateOrCreate(
                [
                    'employer_id' => $employer->id,
                    'title' => $payload['title'],
                ],
                [
                    ...$payload,
                    'status' => Job::STATUS_PUBLISHED,
                    'published_at' => now()->subDays(rand(1, 20)),
                    'closed_at' => null,
                ]
            );
        }
    }
}

