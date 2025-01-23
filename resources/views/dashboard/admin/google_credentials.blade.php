<!-- resources/views/admin/google_credentials.blade.php -->
@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.google-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.google-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.google-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }
</style>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="main-table-box main-table-box-list services-table">
                @if ($errors->count() > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <h2 class="mb-4">Upload Google Credentials</h2>

                <!-- Instructions for creating credentials.json -->
                <div class="alert alert-info">
                    <h4>Instructions to Create credentials.json</h4>
                    <ol>
                        <li>
                            Go to the <a href="https://console.developers.google.com/" target="_blank">Google Cloud
                                Console</a>.
                        </li>
                        <li>
                            Create a new project or select an existing project.
                        </li>
                        <li>
                            Enable the Google Calendar API:
                            <ul>
                                <li>In the left sidebar, click on <strong>APIs & Services</strong> >
                                    <strong>Library</strong>.</li>
                                <li>Search for <strong>Google Calendar API</strong> and enable it for your project.</li>
                            </ul>
                        </li>
                        <li>
                            Configure the OAuth consent screen:
                            <ul>
                                <li>In the left sidebar, click on <strong>APIs & Services</strong> > <strong>OAuth consent
                                        screen</strong>.</li>
                                <li>Choose the type of user (Internal or External) and fill out the required fields.</li>
                                <li>Click <strong>Save and Continue</strong> until you complete the process.</li>
                            </ul>
                        </li>
                        <li>
                            Create credentials:
                            <ul>
                                <li>In the left sidebar, click on <strong>APIs & Services</strong> >
                                    <strong>Credentials</strong>.</li>
                                <li>Click on <strong>Create Credentials</strong> and choose <strong>OAuth 2.0 Client
                                        IDs</strong>.</li>
                                <li>Select <strong>Web application</strong> as the Application type.</li>
                                <li>Add your authorized redirect URIs, for example:
                                    <ul>
                                        <li>For local testing: <code>http://localhost:8000/callback</code></li>
                                        <li>For production: <code>https://yourdomain.com/callback</code></li>
                                    </ul>
                                </li>
                                <li>Click <strong>Create</strong>.</li>
                            </ul>
                        </li>
                        <li>
                            Download the <strong>credentials.json</strong> file:
                            <ul>
                                <li>Click the download icon next to your newly created OAuth 2.0 Client ID.</li>
                            </ul>
                        </li>
                        <li>
                            Ensure that your <strong>credentials.json</strong> file contains the following structure:
                            <pre><code>{
    "web": {
        "client_id": "YOUR_CLIENT_ID",
        "project_id": "YOUR_PROJECT_ID",
        "auth_uri": "https://accounts.google.com/o/oauth2/auth",
        "token_uri": "https://oauth2.googleapis.com/token",
        "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
        "client_secret": "YOUR_CLIENT_SECRET",
        "redirect_uris": ["YOUR_REDIRECT_URI"]
    }
}</code></pre>
                        </li>
                    </ol>
                </div>

                <!-- Form to upload credentials.json -->




                <div class="form-box">
                    {{-- <form action="{{ route('admin.google-credentials.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="credentials">Upload Google credentials.json</label>
                            <input type="file" class="form-control" name="credentials" id="credentials" required>
                            <small class="form-text text-muted">Upload the credentials.json file from Google Cloud
                                Console.</small>
                        </div>
                        <button type="submit" class="btn">Save Credentials</button>
                    </form> --}}

                    <form method="POST" action="{{ url('admin/google-credentials') }}" enctype="multipart/form-data">
                        @csrf
        
                        <div class="form-group">
                            <label for="client_id">Google Client ID</label>
                            <input type="text" class="form-control" id="client_id" name="client_id" required>
                        </div>
            
                        <div class="form-group">
                            <label for="client_secret">Google Client Secret</label>
                            <input type="text" class="form-control" id="client_secret" name="client_secret" required>
                        </div>
            
                        {{-- <div class="form-group">
                            <label for="refresh_token">Google Refresh Token</label>
                            <input type="text" class="form-control" id="refresh_token" name="refresh_token" required>
                        </div> --}}
            
                        <button type="submit" class="btn btn-primary">Save Credentials</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
