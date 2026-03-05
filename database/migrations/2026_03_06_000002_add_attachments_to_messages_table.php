<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('messages') && ! Schema::hasColumn('messages', 'attachment_path')) {
            Schema::table('messages', function (Blueprint $table): void {
                $table->string('attachment_path')->nullable()->after('body');
                $table->string('attachment_original_name')->nullable()->after('attachment_path');
                $table->unsignedInteger('attachment_file_size')->nullable()->after('attachment_original_name');
                $table->string('attachment_mime_type', 120)->nullable()->after('attachment_file_size');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('messages') && Schema::hasColumn('messages', 'attachment_path')) {
            Schema::table('messages', function (Blueprint $table): void {
                $table->dropColumn([
                    'attachment_path',
                    'attachment_original_name',
                    'attachment_file_size',
                    'attachment_mime_type',
                ]);
            });
        }
    }
};

