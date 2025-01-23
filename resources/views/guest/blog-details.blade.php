@extends('guest.layouts.main')
<style>
    header .header-nav ul li a.about-active::after {
        opacity: 100%;

    }
</style>
@section('content')
    <section class="blog-sec-01 blog-sec-details">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text text-center">
                        <h2>{{ $Blog->title }}</h2>
                    </div>
                    <div class="main-blog-details-img">
                        <img src="{{ Storage::url($Blog->image) }}" alt="">
                    </div>
                    <div class="main-blog-detail-box">
                        <div class="text">
                            <p title="{{ $Blog->short_description }}">{{ $Blog->short_description }}</p>
                        </div>
                    </div>
                    <div class="two-boxes-align">
                        <div class="box">
                            <div class="text">
                                <p title="{{ strip_tags($Blog->long_description) }}">{{ strip_tags($Blog->long_description) }}</p>
                            </div>
                        </div>
                        {{-- <div class="box">
                            <div class="main-img-blog-single">
                                <img src="{{ asset('./assets/images/blog-detail-main-img.png') }}" alt="">
                            </div>
                        </div> --}}
                    </div>
                    {{-- <div class="text">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                            of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                            but also the leap into electronic typesetting, remaining essentially unchanged. It was
                            popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                            and more recently with desktop publishing software like Aldus PageMaker including versions of
                            Lorem Ipsum.</p>

                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="contact-us-sec-02">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="text">
                        <h3>Contact Us</h3>
                        <h2>Have <span>Questions?</span> <br> Get in Touch!</h2>
                        <form action="">
                            <input type="text" placeholder="Full Name *">
                            <input type="email" placeholder="Email Address *">
                            <input type="text" placeholder="Subject *">
                            <textarea placeholder="Message *"></textarea>
                            <button>Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <section class="blog-sec-01">
        <div class="container">
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
            </div>
        </div>
    </section>
@endsection
