<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Company Profile</h1>
            <p class="mt-1 text-sm text-slate-600">Keep your employer brand and contact details updated.</p>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form method="POST" action="{{ route('employer.company-profile.update') }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
            @csrf
            @method('PATCH')

            <div class="sm:col-span-2">
                <label class="form-label" for="company_name">Company Name</label>
                <input id="company_name" name="company_name" class="form-input" value="{{ old('company_name', $profile->company_name) }}" required>
                @error('company_name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="industry">Industry</label>
                <input id="industry" name="industry" class="form-input" value="{{ old('industry', $profile->industry) }}">
                @error('industry') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="website">Website</label>
                <input id="website" name="website" class="form-input" value="{{ old('website', $profile->website) }}">
                @error('website') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="phone">Phone</label>
                <input id="phone" name="phone" class="form-input" value="{{ old('phone', $profile->phone) }}">
                @error('phone') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="address">Address</label>
                <input id="address" name="address" class="form-input" value="{{ old('address', $profile->address) }}">
                @error('address') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label class="form-label" for="about">Company Description</label>
                <textarea id="about" name="about" rows="4" class="form-input">{{ old('about', $profile->about) }}</textarea>
                @error('about') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label class="form-label" for="logo">Company Logo (Optional)</label>
                <input id="logo" name="logo" type="file" class="form-input file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-emerald-700">
                @error('logo') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            @if ($profile->logo_url)
                <div class="sm:col-span-2">
                    <p class="mb-2 text-sm font-semibold text-slate-700">Current Logo</p>
                    <img src="{{ $profile->logo_url }}" alt="Company Logo" class="h-16 w-auto rounded-xl border border-slate-200 bg-slate-50 p-2">
                </div>
            @endif

            <div class="sm:col-span-2">
                <button class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Save Company Profile</button>
            </div>
        </form>
    </section>
</x-app-layout>

