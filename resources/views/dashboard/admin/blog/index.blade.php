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
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align">
                <h5>Blogs</h5>
                <a href="{{ route('admin.blog.create') }}" class="t-btn">Add Blog </a>
            </div>
        </div>
        <div class="main-table-box main-table-box-list">
            <table id="blogTable" class="display">
            </table>
        </div>
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            showTable();
        });

        function showTable() {
            $.ajax({
                url: "{{ route('admin.blog.show.all') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('#blogTable').DataTable({
                        destroy: true, // Use this to reset the table before reinitializing
                        data: response, // The data returned by the server
                        columns: [{
                                data: 'id',
                                title: 'ID'
                            },
                            {
                                data: 'image',
                                title: 'Image',
                                render: function(data, type, row) {
                                    if (data) {
                                        return `<img src="{{ Storage::url('${data}') }}" alt="${row.title}" width="50" height="50">`;
                                    } else {
                                        return `<img src="/assets/images/default.png" alt="${row.title}" width="50" height="50">`;
                                    }
                                }
                            },
                            {
                                data: 'title',
                                title: 'Title'
                            },
                            {
                                data: 'slug',
                                title: 'Slug'
                            },
                            {
                                data: 'meta_tag',
                                title: 'Meta Description'
                            },
                            {
                                data: 'page_title',
                                title: 'Page Title'
                            },
                            {
                                data: 'id',
                                title: 'Actions',
                                render: function(data, type, row) {
                                    return `
                                    <div class="action-box">
                                        <ul>
                                            <li>
                                                <button onclick="deleteBlog(${data})">
                                                    <img src="/assets/images/delete.png" alt="Delete">
                                                </button>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.blog.edit', ['id' => ':id']) }}" onclick="editService(${data})">
                                                    <img src="/assets/images/pencil.png" alt="Edit">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>`.replace(':id', data); // Replace placeholder with actual data
                                }

                            }
                        ],
                        dom: 'Bfrtip', // Add the Buttons extension
                        buttons: [{
                                extend: 'excelHtml5',
                                text: 'Export Excel',
                                title: 'Blog List',
                                className: 't-btn',
                            },
                            {
                                extend: 'pdfHtml5',
                                text: 'Export PDF',
                                title: 'Blog List'
                            }
                        ]
                    });
                }
            });
        }

        function deleteBlog(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.blog.destroy', '') }}/" + id,
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        $('#blogTable').DataTable({
                            destroy: true
                        });
                        showTable();
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Staff deleted successfully.',
                                'success'
                            );
                        } else {

                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred while trying to delete the staff.');
                        console.error('Error:', error);
                    }
                });
            }
        });
    }
    </script>
