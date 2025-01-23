@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.service-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.service-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.service-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }
</style>
@section('content')
    <div class="col-lg-10">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align">
                <h5>Edit Service</h5>
            </div>
            <form action="{{ route('admin.service.update', ['id' => $service->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @if (isset($service))
                    @method('POST')
                @endif

                <div class="row">
                    <!-- Image -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="w-100 form-control @error('image') is-invalid @enderror" id="image"
                                name="image">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if (isset($service) && $service->image)
                                <img src="{{ Storage::url($service->image) }}" class="mt-3 " alt="Service Image" width="100"
                                    height="100">
                            @endif
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Service Name <span class="text-danger">*</span></label>
                            <input type="text" class="w-100 form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $service->name ?? '') }}" placeholder="Add Name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Category -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">Category
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#addCategoryModal">
                                    <span class="fa fa-plus"></span> Add Category
                                </button>
                            </label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                name="category_id">
                                <option disabled selected>Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ isset($service) && $service->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Price <span class="text-danger">*</span></label>
                            <input type="number" class="w-100 form-control @error('price') is-invalid @enderror" id="price"
                                name="price" value="{{ old('price', $service->price ?? '') }}" placeholder="Add price">
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Duration -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration">Duration <span class="text-danger">*</span></label>
                            <input type="number" class="w-100 form-control @error('duration') is-invalid @enderror"
                                id="duration" name="duration" value="{{ old('duration', $service->duration ?? '') }}"
                                placeholder="Add duration">
                            @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Slots -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="slots">Slots <span class="text-danger">*</span></label>
                            <input type="number" class="w-100 form-control @error('slots') is-invalid @enderror"
                                id="slots" name="slots" value="{{ old('slots', $service->slots ?? '') }}"
                                placeholder="Add Slots">
                            @error('slots')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Type Duration -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type_duration">Duration Type</label>
                            <select class="form-control @error('type_duration') is-invalid @enderror" id="type_duration"
                                name="type_duration">
                                <option value="mins"
                                    {{ isset($service) && $service->type_duration == 'mins' ? 'selected' : '' }}>Minutes
                                </option>
                                <option value="hours"
                                    {{ isset($service) && $service->type_duration == 'hours' ? 'selected' : '' }}>Hours
                                </option>
                                <option value="days"
                                    {{ isset($service) && $service->type_duration == 'days' ? 'selected' : '' }}>Days
                                </option>
                            </select>
                            @error('type_duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Buffer Time Before -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="buffer_time_before">Buffer Time Before</label>
                            <input type="number" class="w-100 form-control @error('buffer_time_before') is-invalid @enderror"
                                id="buffer_time_before" name="buffer_time_before"
                                value="{{ old('buffer_time_before', $service->buffer_time_before ?? '') }}"
                                placeholder="Add buffer time before">
                            @error('buffer_time_before')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Type Buffer Time Before -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type_buffer_time_before">Buffer Time Before Type</label>
                            <select class="form-control @error('type_buffer_time_before') is-invalid @enderror"
                                id="type_buffer_time_before" name="type_buffer_time_before">
                                <option value="mins"
                                    {{ isset($service) && $service->type_buffer_time_before == 'mins' ? 'selected' : '' }}>
                                    Minutes</option>
                                <option value="hours"
                                    {{ isset($service) && $service->type_buffer_time_before == 'hours' ? 'selected' : '' }}>
                                    Hours</option>
                            </select>
                            @error('type_buffer_time_before')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Buffer Time After -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="buffer_time_after">Buffer Time After</label>
                            <input type="number" class="w-100 form-control @error('buffer_time_after') is-invalid @enderror"
                                id="buffer_time_after" name="buffer_time_after"
                                value="{{ old('buffer_time_after', $service->buffer_time_after ?? '') }}"
                                placeholder="Add buffer time after">
                            @error('buffer_time_after')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Type Buffer Time After -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type_buffer_time_after">Buffer Time After Type</label>
                            <select class="form-control @error('type_buffer_time_after') is-invalid @enderror"
                                id="type_buffer_time_after" name="type_buffer_time_after">
                                <option value="mins"
                                    {{ isset($service) && $service->type_buffer_time_after == 'mins' ? 'selected' : '' }}>
                                    Minutes</option>
                                <option value="hours"
                                    {{ isset($service) && $service->type_buffer_time_after == 'hours' ? 'selected' : '' }}>
                                    Hours</option>
                            </select>
                            @error('type_buffer_time_after')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Min Capacity -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="min_capacity">Minimum Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="w-100 form-control @error('min_capacity') is-invalid @enderror"
                                id="min_capacity" name="min_capacity"
                                value="{{ old('min_capacity', $service->min_capacity ?? '') }}"
                                placeholder="Add minimum capacity">
                            @error('min_capacity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Max Capacity -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="max_capacity">Maximum Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="w-100 form-control @error('max_capacity') is-invalid @enderror"
                                id="max_capacity" name="max_capacity"
                                value="{{ old('max_capacity', $service->max_capacity ?? '') }}"
                                placeholder="Add maximum capacity">
                            @error('max_capacity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Description -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" placeholder="Add description">{{ old('description', $service->description ?? '') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_category_name">Category Name</label>
                        <input type="text" class="form-control" id="new_category_name"
                            placeholder="Enter category name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveCategoryButton" onclick="saveCategory()">Save
                        Category</button>
                </div>
            </div>
        </div>
    </div>
@endsection
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
