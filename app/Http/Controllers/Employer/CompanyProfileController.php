<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\UpdateEmployerProfileRequest;
use App\Models\EmployerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $profile = EmployerProfile::query()->firstOrCreate(
            ['user_id' => $request->user()->id],
            ['company_name' => $request->user()->full_name.' Company']
        );

        return view('dashboards.employer.company-profile', [
            'profile' => $profile,
        ]);
    }

    public function update(UpdateEmployerProfileRequest $request): RedirectResponse
    {
        $profile = EmployerProfile::query()->firstOrCreate(
            ['user_id' => $request->user()->id],
            ['company_name' => $request->user()->full_name.' Company']
        );

        $data = $request->safe()->except('logo');

        if ($request->hasFile('logo')) {
            if ($profile->logo_path) {
                Storage::disk('public')->delete($profile->logo_path);
            }

            $data['logo_path'] = $request->file('logo')->store("company-logos/{$request->user()->id}", 'public');
        }

        $profile->fill($data);
        $profile->save();

        return back()->with('success', 'Company profile updated.');
    }
}

