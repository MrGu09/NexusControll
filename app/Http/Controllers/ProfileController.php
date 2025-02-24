<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit(): View
    {
        $users = \App\Models\User::all(); // Get all users
        return view('profile.edit', ['user' => Auth::user(), 'users' => $users]);
    }


    /**
     * Update profile information (name, email, profile picture).
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Update name and email
        $user->name = $request->name;
        $user->email = $request->email;

        // Handle profile picture update
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'password' => ['required', 'current-password'], // Ensure admin confirms with password
    ]);

    $admin = Auth::user();
    $user = \App\Models\User::findOrFail($request->user_id);

    // Prevent self-deletion
    if ($admin->id === $user->id) {
        return redirect()->back()->with('error', 'You cannot delete your own account.');
    }

    // Delete the user
    $user->delete();

    return redirect()->back()->with('success', 'User account deleted successfully.');
}

}
