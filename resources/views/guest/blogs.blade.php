@extends('guest.layouts.main')
<style>
    header .header-nav ul li a.blog-active::after {
        opacity: 100%;

    }
</style>
@section('content')
    <section class="blog-sec-01">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text text-center">
                        <h2>Blogs </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($blogs as $blog)
                    <div class="col-lg-6 col-md-12">
                        <div class="main-blog-box">
                            <a href="{{ route('blog-details',['id' => $blog->id]) }}">
                                <img src="{{ Storage::url($blog->image) }}" alt="" height="100" width="100">
                                <div class="content">
                                    <h4>{{ $blog->title }}</h4>
                                    <p title="{{ $blog->short_description }}">{{ \Illuminate\Support\Str::words($blog->short_description, 30, '...') }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                @if ($blogs->count() == 0)
                    <div class="col-md-12">
                        <div class="text text-center">
                            <h4>No Blog Found</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
