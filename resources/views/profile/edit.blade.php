<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Profile Settings</h1>
            <p class="mt-1 text-sm text-slate-600">Update your personal details and account security settings.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @include('profile.partials.update-password-form')
        </section>
    </div>
</x-app-layout>
