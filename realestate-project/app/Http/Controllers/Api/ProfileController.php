<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function show()
    {
        $p = Profile::first();

        if (! $p) {
            return response()->json(['message' => 'Profile not set'], 404);
        }

        return [
            'name'         => $p->name,
            'role'         => $p->role,
            'tagline'      => $p->tagline,
            'stack'        => $p->stack ?? [],
            'available'    => $p->available,
            'email'        => $p->email,
            'about'        => $p->about,
            'photo'        => $p->photo ? asset('storage/'.$p->photo) : null,
            'github_url'   => $p->github_url,
            'linkedin_url' => $p->linkedin_url,
        ];
    }
}