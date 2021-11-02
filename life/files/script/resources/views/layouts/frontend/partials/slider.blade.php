<div class="slider-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="slider-content">
                    <h2>{{ $heroSectionData->title ?? null }}</h2>
                    <p>{{ $heroSectionData->des ?? null }}</p>
                    <div class="slider-btn">
                        <a href="{{ $heroSectionData->start_url ?? '#' }}">{{ $heroSectionData->start_text ?? null }}</a>
                        <a href="{{ $heroSectionData->contact_url ?? '#' }}">{{ $heroSectionData->contact_text ?? null }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="slider-right f-right">
                    <img class="img-fluid" src="{{ asset($heroSectionData->image ?? 'frontend/assets/img/slider/1.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
</div>