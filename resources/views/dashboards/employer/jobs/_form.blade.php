@csrf

<div class="grid gap-4 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="title" class="form-label">Job Title</label>
        <input id="title" name="title" class="form-input" value="{{ old('title', $job->title) }}" required>
        @error('title') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="location" class="form-label">Location</label>
        <input id="location" name="location" class="form-input" value="{{ old('location', $job->location) }}" required>
        @error('location') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-input" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $job->status ?: 'draft') === $status)>{{ str_replace('_', ' ', $status) }}</option>
            @endforeach
        </select>
        @error('status') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="job_type" class="form-label">Job Type</label>
        <select id="job_type" name="job_type" class="form-input" required>
            @foreach ($jobTypes as $jobType)
                <option value="{{ $jobType }}" @selected(old('job_type', $job->job_type ?: 'full_time') === $jobType)>{{ str_replace('_', ' ', $jobType) }}</option>
            @endforeach
        </select>
        @error('job_type') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="work_setup" class="form-label">Work Setup</label>
        <select id="work_setup" name="work_setup" class="form-input" required>
            @foreach ($workSetups as $workSetup)
                <option value="{{ $workSetup }}" @selected(old('work_setup', $job->work_setup ?: 'onsite') === $workSetup)>{{ str_replace('_', ' ', $workSetup) }}</option>
            @endforeach
        </select>
        @error('work_setup') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="salary_min" class="form-label">Salary Min</label>
        <input id="salary_min" name="salary_min" type="number" min="0" class="form-input" value="{{ old('salary_min', $job->salary_min) }}">
        @error('salary_min') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="salary_max" class="form-label">Salary Max</label>
        <input id="salary_max" name="salary_max" type="number" min="0" class="form-input" value="{{ old('salary_max', $job->salary_max) }}">
        @error('salary_max') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label for="description" class="form-label">Job Description</label>
        <textarea id="description" name="description" rows="6" class="form-input">{{ old('description', $job->description) }}</textarea>
        @error('description') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label for="requirements" class="form-label">Requirements (Optional)</label>
        <textarea id="requirements" name="requirements" rows="4" class="form-input">{{ old('requirements', $job->requirements) }}</textarea>
        @error('requirements') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label for="required_skills" class="form-label">Required Skills (comma separated)</label>
        <input
            id="required_skills"
            name="required_skills"
            class="form-input"
            value="{{ old('required_skills', collect($job->required_skills ?? [])->implode(', ')) }}"
            placeholder="e.g. forklift operation, inventory management, excel"
        >
        @error('required_skills') <p class="form-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 flex justify-end gap-2">
    <a href="{{ route('employer.jobs.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
    <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">{{ $submitLabel }}</button>
</div>
