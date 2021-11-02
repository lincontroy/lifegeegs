@extends('layouts.frontend.app')

@section('slider')
<!-- breadcrumb area start -->
<div class="slider-breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="breadcrumb-title">
                    <h4>{{ __('Blog Details') }}</h4>
                </div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Blog Details') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area start -->
</div>
@endsection

@section('content')
<!-- blog area start -->
<div class="blog-main-area mt-100 mb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-details-area">
                    <div class="blog-details-img">
                        <img class="img-fluid" src="{{ asset( $blogDetails->thum_image->value ?? 'no-img.png')}}" alt="">
                    </div>
                    <div class="blog-name">
                        <h2>{{ $blogDetails->title }}</h2>
                    </div>
                    <div class="blog-des">
                        <p>{{ content($blogDetails->description->value ?? '') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-card">
                    <div class="blog-card-header">
                        <h4>{{ __('Search') }}</h4>
                    </div>
                    <div class="blog-card-body">
                        <form action="{{ url('/blog') }}" type="get">
                            <div class="search-input d-flex align-items-center justify-content-between">
                                <input type="text" placeholder="{{ __('Search') }}" name="text_search">
                                <button type="submit">{{ __('Search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="blog-card">
                    <div class="blog-card-header">
                        <h4>{{ __('Recent Posts') }}</h4>
                    </div>
                    <div class="blog-card-body">
                        @forelse ($latest_blogs as $latest_blog)
                        <div class="single-card-blog d-flex align-items-center">
                            <div class="card-blog-img">
                                <a href="{{ url('/blog',$latest_blog->slug) }}"><img src="{{ asset( $latest_blog->thum_image->value ?? 'no-img.png')}}" alt=""></a>
                            </div>
                            <div class="card-blog-name">
                                <a href="{{ url('/blog',$latest_blog->slug) }}"><h6>{{ $latest_blog->title }}</h6></a>
                            </div>
                        </div>
                        @empty
                        <h4>{{ __('no record') }}</h4>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- blog area end -->
@endsection