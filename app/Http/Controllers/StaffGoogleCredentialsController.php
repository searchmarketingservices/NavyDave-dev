<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StaffGoogleCredentialsController extends Controller
{
    public function showForm()
    {
        $staffId = Auth::id();
        $credentials = DB::table('staff_google_credentials')->where('staff_id', $staffId)->first();

        return view('dashboard.staff.google_credentials', compact('credentials'));
    }

    public function store(Request $request)
    {
        // Validate the file upload
        $request->validate([
            'credentials' => 'required|file|mimes:json',
        ]);

        // Determine the directory based on the user type
        $userType = 'staff'; // or 'admin' based on your logic
        $directory = "google/{$userType}";

        // Store the file in storage/app/google/staff or storage/app/google/admin
        $path = $request->file('credentials')->storeAs($directory, 'credentials.json');

        // Parse and extract the client ID and secret
        $credentials = json_decode(file_get_contents(Storage::path($path)), true);

        // Check if the credentials are in the expected format
        if (isset($credentials['installed'])) {
            $clientId = $credentials['installed']['client_id'];
            $clientSecret = $credentials['installed']['client_secret'];

            // Save the credentials to the database
            DB::table('staff_google_credentials')->updateOrInsert(
                ['staff_id' => Auth::id()],
                [
                    'google_client_id' => $clientId,
                    'google_client_secret' => $clientSecret,
                ]
            );


            // return redirect()->back()->with('success', 'Google credentials saved successfully.');
            return redirect('/staff-google-auth');
        }

        return redirect()->back()->with('error', 'Invalid credentials.json format.');
    }

}
