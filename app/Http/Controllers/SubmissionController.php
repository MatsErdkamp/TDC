<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Challenge;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use RahulHaque\Filepond\Facades\Filepond;


class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'media' => 'required|file|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Get the current date in UTC
        $currentDate = Carbon::now()->toDateString();

        // Find the challenge for the current date
        $challenge = Challenge::where('date', $currentDate)->first();

        if (!$challenge) {
            return Inertia::render('Error', ['message' => 'No challenge found for the current date']);
        }

        // Handle the file upload
        if ($request->hasFile('media')) {
            // Store the file and get the path
            $fileInfo = Filepond::field($request->media)->moveTo('media');


            // Get the authenticated user
            $user = Auth::user();

            // Create a new submission object
            $submission = new Submission();
            $submission->user_id = $user->id;
            $submission->challenge_id = $challenge->id;
            $submission->media = $fileInfo['location'];
            $submission->save();

            return redirect('/')->with('message', 'Submission created successfully');
        }

        return Inertia::render('Error', ['message' => 'File upload failed']);
    }
}
