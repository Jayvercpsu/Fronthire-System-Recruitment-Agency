<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->prepareQueueJobsTable();
        $this->extendUsersTable();
        $this->extendResumesTable();
        $this->createEmployerProfilesTable();
        $this->createRecruitmentJobsTable();
        $this->createApplicationsTable();
        $this->createEducationTable();
        $this->createExperiencesTable();
        $this->createConversationsTable();
        $this->createConversationParticipantsTable();
        $this->createMessagesTable();
        $this->createAuditLogsTable();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversation_participants');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('education');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('employer_profiles');

        if (Schema::hasTable('resumes')) {
            Schema::table('resumes', function (Blueprint $table): void {
                if (Schema::hasColumn('resumes', 'file_size')) {
                    $table->dropColumn('file_size');
                }
                if (Schema::hasColumn('resumes', 'mime_type')) {
                    $table->dropColumn('mime_type');
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table): void {
                if (Schema::hasColumn('users', 'is_active')) {
                    $table->dropColumn('is_active');
                }
                if (Schema::hasColumn('users', 'headline')) {
                    $table->dropColumn('headline');
                }
                if (Schema::hasColumn('users', 'bio')) {
                    $table->dropColumn('bio');
                }
                if (Schema::hasColumn('users', 'skills')) {
                    $table->dropColumn('skills');
                }
                if (Schema::hasColumn('users', 'location')) {
                    $table->dropColumn('location');
                }
            });
        }

        if (Schema::hasTable('queue_jobs') && ! Schema::hasTable('jobs')) {
            Schema::rename('queue_jobs', 'jobs');
        }
    }

    private function prepareQueueJobsTable(): void
    {
        if (! Schema::hasTable('jobs') || ! Schema::hasColumn('jobs', 'queue')) {
            return;
        }

        if (Schema::hasTable('queue_jobs')) {
            return;
        }

        Schema::rename('jobs', 'queue_jobs');
    }

    private function extendUsersTable(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }

            if (! Schema::hasColumn('users', 'headline')) {
                $table->string('headline')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('headline');
            }

            if (! Schema::hasColumn('users', 'skills')) {
                $table->json('skills')->nullable()->after('bio');
            }

            if (! Schema::hasColumn('users', 'location')) {
                $table->string('location')->nullable()->after('skills');
            }
        });
    }

    private function extendResumesTable(): void
    {
        if (! Schema::hasTable('resumes')) {
            return;
        }

        Schema::table('resumes', function (Blueprint $table): void {
            if (! Schema::hasColumn('resumes', 'file_size')) {
                $table->unsignedInteger('file_size')->nullable()->after('original_name');
            }

            if (! Schema::hasColumn('resumes', 'mime_type')) {
                $table->string('mime_type', 120)->nullable()->after('file_size');
            }
        });
    }

    private function createEmployerProfilesTable(): void
    {
        if (Schema::hasTable('employer_profiles')) {
            return;
        }

        Schema::create('employer_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('company_name');
            $table->string('industry')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    private function createRecruitmentJobsTable(): void
    {
        if (Schema::hasTable('jobs')) {
            return;
        }

        Schema::create('jobs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employer_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('location');
            $table->enum('job_type', ['full_time', 'part_time', 'contract', 'temporary', 'internship'])->default('full_time');
            $table->enum('work_setup', ['onsite', 'hybrid', 'remote'])->default('onsite');
            $table->unsignedInteger('salary_min')->nullable();
            $table->unsignedInteger('salary_max')->nullable();
            $table->string('currency', 3)->default('CAD');
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->index(['employer_id', 'status']);
            $table->index(['status', 'job_type', 'work_setup']);
            $table->index(['location', 'status']);
        });
    }

    private function createApplicationsTable(): void
    {
        if (Schema::hasTable('applications')) {
            return;
        }

        Schema::create('applications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_seeker_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['submitted', 'under_review', 'shortlisted', 'interview', 'offer', 'hired', 'rejected', 'withdrawn'])->default('submitted');
            $table->text('cover_letter')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();

            $table->unique(['job_id', 'job_seeker_id']);
            $table->index(['job_id', 'status']);
            $table->index(['job_seeker_id', 'status']);
        });
    }

    private function createEducationTable(): void
    {
        if (Schema::hasTable('education')) {
            return;
        }

        Schema::create('education', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('school');
            $table->string('degree');
            $table->string('field_of_study')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    private function createExperiencesTable(): void
    {
        if (Schema::hasTable('experiences')) {
            return;
        }

        Schema::create('experiences', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('company');
            $table->string('position');
            $table->string('employment_type')->nullable();
            $table->string('location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    private function createConversationsTable(): void
    {
        if (Schema::hasTable('conversations')) {
            return;
        }

        Schema::create('conversations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('application_id')->nullable()->unique()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    private function createConversationParticipantsTable(): void
    {
        if (Schema::hasTable('conversation_participants')) {
            return;
        }

        Schema::create('conversation_participants', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('last_read_at')->nullable();
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id']);
        });
    }

    private function createMessagesTable(): void
    {
        if (Schema::hasTable('messages')) {
            return;
        }

        Schema::create('messages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['conversation_id', 'created_at']);
        });
    }

    private function createAuditLogsTable(): void
    {
        if (Schema::hasTable('audit_logs')) {
            return;
        }

        Schema::create('audit_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('auditable_type');
            $table->unsignedBigInteger('auditable_id');
            $table->string('event');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['auditable_type', 'auditable_id']);
            $table->index('event');
        });
    }
};

