@extends('layouts.frontend.app')

@section('slider')
    @include('layouts.frontend.partials.slider')
@endsection

@section('content')
@if(count($sections) > 0)
<!-- features area start -->
<section>
    <div class="features-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="features-header-section text-center">
                    <h4>{{ __('Our Valuable Features') }}</h4>
                    <p>{{ __('features_des') }}</p>
                </div>
            </div>
            <div class="row">
                @foreach ($sections as $value)
                @php $jsonSection = json_decode($value->termMeta->value ) @endphp
                <div class="col-lg-4">
                    <div class="single-service text-center">
                        <div class="service-img">
                            <img src="{{ asset($jsonSection->image ?? '') }}" alt="">
                        </div>
                        <div class="service-title">
                            <h4>{{ $value->title }}</h4>
                        </div>
                        <div class="service-des">
                            <p>{{ $jsonSection->des }}</p>
                        </div>
                        <div class="service-btn">
                            <a href="{{ url('/service',$value->slug) }}">{{ __('Read More') }}</a>
                        </div>
                    </div>
                </div>
               
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
<!-- features area end -->
@if(!empty($quickStart))
<!-- about area start -->
<section>
    @php 
    $jsonQuick = json_decode($quickStart->quickStart->value ?? ''); 
    @endphp
    <div class="about-area pt-100 pb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-title">
                        <h3>{{ $quickStart->title }}</h3>
                    </div>
                    <div class="about-des">
                        <p>{{ $jsonQuick->des ?? null }}</p>
                    </div>
                    <div class="about-menu">
                        <nav>
                            <ul>
                                @foreach ($jsonQuick->list ?? [] as $key => $val)
                                <li><span class="iconify" data-icon="akar-icons:check" data-inline="false"></span>{{ $val }}</li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                    <div class="about-link">
                        <a href="{{ $jsonQuick->button_link }}"><span class="iconify" data-icon="akar-icons:circle-check" data-inline="false"></span>{{ $jsonQuick->button_name }}</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-img">
                        <img class="img-fluid" src="{{ asset($jsonQuick->image ?? '')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about area end -->
@endif
<!-- customer-experience area start  -->
<section>
    <div class="customer-experience-area pb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-img">
                        <img class="img-fluid" src="{{ asset($getawaySection->image ?? '')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="customer-experience-content">
                        <h3>{{ $getawaySection->first_title ?? '' }}</h3>
                        <p>{{ $getawaySection->first_des ?? '' }}</p>
                    </div>
                    <div class="customer-experience-content">
                        <h3>{{ $getawaySection->second_title ?? '' }}</h3>
                        <p>{{ $getawaySection->second_des ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- customer-experience area end  -->
@if(count($plans) > 0)
<!-- pricing area start -->
<div class="pricing-area mb-100 pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="pricing-header-area text-center">
                    <div class="pricing-header">
                        <h2>{{ __('Pricing Tables') }}</h2>
                        <p>{{ __('pricing_des') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            @foreach($plans as $plan)
            <div class="col-lg-3">
                <div class="single-pricing {{ $plan->is_featured ? 'active' : '' }}">
                    <div class="pricing-type">
                        <h6>{{ $plan->name }}</h6>
                    </div>
                    <div class="pricing-price">
                        <sub>{{ App\Models\Option::where('key','currency_symbol')->first()->value }} {{ $plan->price }} /
                            @if ($plan->duration == 7)
                            {{ __('Per Week') }}
                        @elseif($plan->duration == 30)
                            {{ __('Per Month') }}
                        @elseif($plan->duration == 365)
                            {{ __('Per Year') }}
                        @else
                            {{ $plan->duration }} {{ __('Days') }}
                        @endif
                        </sub>
                    </div>
                    <div class="pricing-list">
                        <ul>
                            <li><span class="iconify" data-icon="akar-icons:check" data-inline="false"></span>{{ $plan->storage_limit }} {{ __('MB Storage limit') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:check" data-inline="false"></span>{{ $plan->monthly_req }} {{ __('Monthly Request') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:check" data-inline="false"></span>{{ $plan->daily_req }} {{ __('Daily Request') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->captcha=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Google Captcha') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->menual_req=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Menual Request') }}</li>
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->fraud_check=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Fraud Check') }}</li>
                            
                            
                            <li><span class="iconify" data-icon="akar-icons:{{ $plan->mail_activity=='1' ? 'check' : 'cross' }}" data-inline="false"></span>{{ __('Mail Activity') }}</li>
                        </ul>
                    </div>
                    <div class="pricing-btn">
                        <a href="{{ route('plan.check', $plan->id) }}">{{ __('Get Started') }}</a>
                    </div>
                </div>
            </div>         
            @endforeach
        </div>
    </div>
</div>
<!-- pricing area end -->
@endif
<!-- blog area start -->
@if(($blogs->count() >0))
<section>
    <div class="blog-area mt-100 mb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="pricing-header-area text-center">
                        <div class="pricing-header">
                            <h2>{{ __('Latest News') }}</h2>
                            <p>{{ __('news_des') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                @foreach($blogs as  $blog)
                <div class="col-lg-4">
                    <div class="single-news">
                        <div class="news-img">
                            <a href="{{ url('/blog',$blog->slug) }}"> <img class="img-fluid" src="{{ asset( $blog->thum_image->value ?? '')}}" alt=""></a>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span>
                                    <span class="iconify" data-icon="uil:calender" data-inline="false"></span>{{ $blog->created_at->isoFormat('LL') }}
                                </span>
                                <span>
                                    <span class="iconify" data-icon="bx:bxs-user" data-inline="false"></span> {{ __('By') }} {{ $blog->user->name }}</a>
                                </span>
                            </div>
                            <div class="news-title">
                                <a href="{{ url('/blog',$blog->slug) }}"><h3>{{ $blog->title }}</h3></a>
                            </div>
                            <div class="news-short-des">
                                <p>{{ Str::limit($blog->excerpt->value,150) }}</p>
                            </div>
                            <div class="news-btn">
                                <a href="{{ url('/blog',$blog->slug) }}">{{ __('Read More') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
<!-- blog area end -->
@endsection

