@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.blog-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.blog-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.blog-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }
</style>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align">
                <h5>{{ isset($blog) ? 'Edit Blog' : 'Create Blog' }}</h5>
                <a href="{{ route('admin.blog') }}" class="t-btn">Back</a>
            </div>
            <form action="{{ isset($blog) ? route('admin.blog.update', $blog->id) : route('admin.blog.store') }}"
                method="POST" enctype="multipart/form-data">
                <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control w-100" id="title" name="title"
                                    value="{{ old('title', isset($blog) ? $blog->title : '') }}"  >
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slug">Slug:</label>
                                <input type="text" class="form-control w-100" id="slug" name="slug"
                                    value="{{ isset($blog) ? $blog->slug : '' }}">
                                <small class="form-text text-danger">Slug will be generated automatically.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="short_description">Short Description:</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="3" required>{{ isset($blog) ? $blog->short_description : '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Long Description:</label>
                        <textarea class="form-control" id="editor" name="long_description" rows="5">{{ isset($blog) ? print $blog->long_description : '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*"
                            {{ isset($blog) ? '' : '' }}>
                    </div>
                    @if (isset($blog) && $blog->image)
                        <div class="my-3">
                            <label for="">Current Image</label>
                            <img src="{{ Storage::url($blog->image) }}" width="100" height="100">
                        </div>
                    @endif
                    <div class="form-group">
                        <label>Page Title</label>
                        <input class="form-control w-50" name="page_title" required
                            value="{{ isset($blog) ? $blog->page_title : '' }}">
                        <small class="form-text text-danger">This title belongs to the browser's tab</small>
                    </div>

                    <div class="form-group">
                        <label>Meta Description</label>
                        <input class="form-control w-50" name="meta_tag" value="{{ isset($blog) ? $blog->meta_tag : '' }}">
                        <small class="form-text text-danger">Please write complete meta tag</small>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
        </div>
    </div>
@endsection


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {

            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });


        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w-]+/g, '')
                .replace(/--+/g, '-');
        }

        $('#title').on('input', function() {
            var titleValue = $(this).val();
            var slugValue = slugify(titleValue);
            $('#slug').val(slugValue);
        });

        // Debugging
        console.log('Slugify script loaded');
    });
</script>
