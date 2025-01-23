@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.setting-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.setting-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.setting-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }
</style>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list">
            <div class="two-things-align">
                <h5>{{ isset($setting) ? 'Edit Settings' : 'Create Settings' }}</h5>
            </div>
            <form action="{{ isset($setting) ? route('admin.setting.update', $setting->id) : route('admin.setting.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($setting))
                    @method('POST')
                @endif
                <div class="row">
                    <!-- Logo -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logo">Logo <span class="text-danger">*</span></label>
                            <input type="file" class="w-100 form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                            @if(isset($setting->logo))
                                <img src="{{ asset('storage/'.$setting->logo) }}" alt="Current Logo" style="width:100px;height:100px;">
                            @endif
                            @error('logo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <!-- App Name -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="app_name">App Name <span class="text-danger">*</span></label>
                            <input type="text" class="w-100 form-control @error('app_name') is-invalid @enderror" id="app_name" name="app_name" value="{{ old('app_name', $setting->app_name ?? '') }}">
                            @error('app_name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="w-100 form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $setting->phone ?? '') }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Location -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="w-100 form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $setting->location ?? '') }}">
                            @error('location')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="w-100 form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $setting->email ?? '') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <!-- Copyright -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="copyright">Copyright <span class="text-danger">*</span></label>
                            <input type="text" class="w-100 form-control @error('copyright') is-invalid @enderror" id="copyright" name="copyright" value="{{ old('copyright', $setting->copyright ?? '') }}">
                            @error('copyright')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>



                <div class="row">
                    <!-- Twitter Link -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="twitter_link">Twitter Link</label>
                            <input type="text" class="w-100 form-control @error('twitter_link') is-invalid @enderror" id="twitter_link" name="twitter_link" value="{{ old('twitter_link', $setting->twitter_link ?? '') }}">
                            @error('twitter_link')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <!-- Instagram Link -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="instagram_link">Instagram Link</label>
                            <input type="text" class="w-100 form-control @error('instagram_link') is-invalid @enderror" id="instagram_link" name="instagram_link" value="{{ old('instagram_link', $setting->instagram_link ?? '') }}">
                            @error('instagram_link')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <!-- Facebook Link -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="facebook_link">Facebook Link</label>
                            <input type="text" class="w-100 form-control @error('facebook_link') is-invalid @enderror" id="facebook_link" name="facebook_link" value="{{ old('facebook_link', $setting->facebook_link ?? '') }}">
                            @error('facebook_link')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Footer Description -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="footer_description">Footer Description <span class="text-danger">*</span></label>
                            <input type="text" class="w-100 form-control @error('footer_description') is-invalid @enderror" id="footer_description" name="footer_description" value="{{ old('footer_description', $setting->footer_description ?? '') }}">
                            @error('footer_description')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">{{ isset($setting) ? 'Update' : 'Submit' }}</button>
            </form>
        </div>
    </div>
@endsection

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    // Ensure the document is ready before executing scripts
    $(document).ready(function() {
        console.log("Document ready!");
    });

    // Define the saveCategory function outside of the document ready function
    function saveCategory() {
        console.log("Saving category...");
        let categoryName = $('#new_category_name').val();
        if (categoryName.trim() === '') {
            alert('Category name cannot be empty.');
            return;
        }

        $.ajax({
            url: "{{ route('admin.categories.store') }}", // Update this with your actual route
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token for security
                name: categoryName
            },
            success: function(response) {
                if (response.success) {
                    // Close the modal
                    $('#addCategoryModal').modal('hide');
                    $('#addCategoryModal').hide();
                    $('.modal-backdrop').hide();
                    // Add the new category to the select dropdown
                    $('#category_id').append(
                        `<option value="${response.category.id}" selected>${response.category.name}</option>`
                    );
                    // Select the newly created category
                    $('#category_id').val(response.category.id);
                } else {
                    alert('Failed to create category.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    }
</script>
