<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('jobs') && ! Schema::hasColumn('jobs', 'required_skills')) {
            Schema::table('jobs', function (Blueprint $table): void {
                $table->json('required_skills')->nullable()->after('requirements');
            });
        }

        if (Schema::hasTable('applications') && ! Schema::hasColumn('applications', 'resume_id')) {
            Schema::table('applications', function (Blueprint $table): void {
                $table->foreignId('resume_id')
                    ->nullable()
                    ->after('job_seeker_id')
                    ->constrained('resumes')
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table): void {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('applications') && Schema::hasColumn('applications', 'resume_id')) {
            Schema::table('applications', function (Blueprint $table): void {
                $table->dropConstrainedForeignId('resume_id');
            });
        }

        if (Schema::hasTable('jobs') && Schema::hasColumn('jobs', 'required_skills')) {
            Schema::table('jobs', function (Blueprint $table): void {
                $table->dropColumn('required_skills');
            });
        }

        Schema::dropIfExists('notifications');
    }
};

