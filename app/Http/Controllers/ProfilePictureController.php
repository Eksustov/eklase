<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilePicture;

class ProfilePictureController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:2048', // 2MB max
        ]);

        $user = Auth::user();

        // Store the new file
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');

        // Update or create the record
        $user->profilePicture()->updateOrCreate(
            ['user_id' => $user->id],
            ['image' => $path]
        );

        return redirect()->back()->with('status', 'Profile picture updated!');
    }
}

