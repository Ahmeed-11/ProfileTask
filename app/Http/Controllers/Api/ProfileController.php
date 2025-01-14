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
        // Get last profile
        $profile = Profile::latest()->first();

        // profile found
        if ($profile) {
            return response()->json([
                'success' => true,
                'data' => $profile,
            ]);
        }

        // profile not found
        return response()->json([
            'success' => false,
            'message' => 'Profile not found.',
        ], 404);
    }


    public function update(Request $request)
    {

        $profile = Profile::latest()->first();

        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:255',
            'image' => 'nullable',
        ]);

        $filename = $profile->image ?? null;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($profile && $profile->image && Storage::exists('public/profile_images/' . $profile->image)) {
                Storage::delete('public/profile_images/' . $profile->image);
            }


            // Store New image
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
