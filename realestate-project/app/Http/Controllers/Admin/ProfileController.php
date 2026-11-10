<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:80'],
            'role'         => ['required', 'string', 'max:80'],
            'tagline'      => ['required', 'string', 'max:200'],
            'stack'        => ['nullable', 'string'],
            'email'        => ['required', 'email'],
            'about'        => ['nullable', 'string'],
            'photo'        => ['nullable', 'image', 'max:2048'],
            'github_url'   => ['nullable', 'url'],
            'linkedin_url' => ['nullable', 'url'],
        ];
    }

    // "PHP, Laravel, React" becomes ["PHP", "Laravel", "React"]
    private function prepare(Request $request, array $data, ?Profile $profile = null): array
    {
        $data['available'] = $request->boolean('available');

        $data['stack'] = collect(explode(',', $data['stack'] ?? ''))
            ->map(fn ($s) => trim($s))
            ->filter()
            ->values()
            ->all();

        if ($request->hasFile('photo')) {
            if ($profile && $profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $data['photo'] = $request->file('photo')->store('profile', 'public');
        } else {
            unset($data['photo']); // keep the existing photo
        }

        return $data;
    }

    public function index()
    {
        $profiles = Profile::latest()->get();
        return view('admin.profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.profiles.form', [
            'profile' => new Profile(['available' => true]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->prepare($request, $request->validate($this->rules()));

        Profile::create($data);

        return redirect()->route('admin.profiles.index')->with('success', 'Profile created.');
    }

    public function edit(Profile $profile)
    {
        return view('admin.profiles.form', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $data = $this->prepare($request, $request->validate($this->rules()), $profile);

        $profile->update($data);

        return redirect()->route('admin.profiles.index')->with('success', 'Profile updated.');
    }

    public function destroy(Profile $profile)
    {
        if ($profile->photo) {
            Storage::disk('public')->delete($profile->photo);
        }
        $profile->delete();

        return redirect()->route('admin.profiles.index')->with('success', 'Profile deleted.');
    }

    // Public JSON endpoint (unchanged)
    public function show()
    {
        return response()->json(Profile::firstOrFail());
    }
}