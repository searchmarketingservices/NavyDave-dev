@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.staffGoogle-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
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

                <form action="{{ route('staff.google.credentials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group w-100">
                        <label for="credentials">Upload credentials.json</label>
                        <input type="file" name="credentials" id="credentials" class="form-control" required>
                    </div>

                    <div class="mt-3">
                        <p>To create your <code>credentials.json</code> file:</p>
                        <ol>
                            <li>Go to the <a href="https://console.developers.google.com/" target="_blank">Google Cloud
                                    Console</a>.</li>
                            <li>Create a new project or select an existing project.</li>
                            <li>Navigate to <strong>APIs & Services</strong> > <strong>Credentials</strong>.</li>
                            <li>Click on <strong>Create credentials</strong> and select <strong>OAuth client ID</strong>.
                            </li>
                            <li>Select <strong>Desktop app</strong> as the application type.</li>
                            <li>Click <strong>Create</strong>, then download the <code>credentials.json</code> file.</li>
                            <li>Upload the <code>credentials.json</code> file here.</li>
                        </ol>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Credentials</button>
                </form>
            </div>
        </div>
    </div>

@endsection
