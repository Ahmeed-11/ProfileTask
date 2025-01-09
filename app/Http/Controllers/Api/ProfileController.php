<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{

    /**
     * Retrieve the profile details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $profile = Profile::latest()->first();

        if ($profile) {
            return response()->json([
                'success' => true,
                'data' => $profile,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Profile not found.',
        ], 404);
    }


    /**
     * Update or create the profile details.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profile = Profile::latest()->first();
        $filename = $profile->image ?? null;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($profile && $profile->image && Storage::exists('public/profile_images/' . $profile->image)) {
                Storage::delete('public/profile_images/' . $profile->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/profile_images', $filename);
        }

        if ($profile) {
            // if a profile exists, update its values
            $profile->update([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $filename,
            ]);
        } else {
            // if no profile exists, create new one
            $profile = Profile::create([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $filename,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $profile,
            'message' => 'Profile updated successfully.',
        ]);
    }
}
