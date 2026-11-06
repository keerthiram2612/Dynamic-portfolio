<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::first() ?? new Profile(['available' => true]);

        return view('admin.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:80'],
            'role'         => ['required', 'string', 'max:80'],
            'tagline'      => ['required', 'string', 'max:200'],
            'stack'        => ['nullable', 'string'],
            'email'        => ['required', 'email'],
            'about'        => ['nullable', 'string'],
            'photo'        => ['nullable', 'image', 'max:2048'],
            'github_url'   => ['nullable', 'url'],
            'linkedin_url' => ['nullable', 'url'],
        ]);

        $data['available'] = $request->boolean('available');

        // "PHP, Laravel, React" becomes ["PHP", "Laravel", "React"]
        $data['stack'] = collect(explode(',', $data['stack'] ?? ''))
            ->map(fn ($s) => trim($s))
            ->filter()
            ->values()
            ->all();

        $profile = Profile::first() ?? new Profile();

        if ($request->hasFile('photo')) {
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $data['photo'] = $request->file('photo')->store('profile', 'public');
        } else {
            unset($data['photo']); // keep the existing photo
        }

        $profile->fill($data)->save();

        return back()->with('success', 'Profile saved.');
    }

        public function show()
    {
        return response()->json(Profile::firstOrFail());
    }

}