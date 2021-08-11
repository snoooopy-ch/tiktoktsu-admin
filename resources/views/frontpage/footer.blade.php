<div class="card-content mt-3">
    <h4 class="card-title font-weight-bold">急上昇</h4>
    <h6 class="">{{ $start }}~{{ $end }}の間、フォロワー数が急上昇したTikTokerです。</h6>
    <div class="card-body pr-0 pl-0" style="margin-left: 5px; margin-right: 5px;">
        <div
            class="swiper-responsive-breakpoints swiper-container swiper-container-initialized swiper-container-horizontal">
            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                @foreach ($surgers as $index => $item)
                    <div class="swiper-slide swiper-slide-active" style="width: 171.8px; margin-right: 50px;">
                        <a href="{{ route('tiktok.user', ['id' => $item->id]) }}">
                            <img class="img-fluid" src="{{ $item->avatar }}" alt="banner">
                            <span class="d-block text-dark">{{ $item->uniqueId }}</span>
                            <span class="d-block font-size-xsmall text-dark">
                                <i class="feather icon-users"></i>
                                +{{ number_format($item->follercount_grow) }}
                            </span>
                            <span class="d-block font-size-xsmall text-dark">
                                <i class="feather icon-trending-up"></i>
                                {{ number_format($item->rate_up, 3) }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false">
            </div>
            <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide"
                aria-disabled="false"></div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>
</div>

<div class="card-content mt-3">
    <h4 class="card-title font-weight-bold">新着登録したTikToker</h4>
    <h6 class="">最近TikTok通に登録されたTikTokerの一覧</h6>
    <div class="card-body pr-0 pl-0" style="margin-left: 5px; margin-right: 5px;">
        <div
            class="swiper-responsive-breakpoints swiper-container swiper-container-initialized swiper-container-horizontal">

            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                @foreach ($laster as $index => $item)
                    <div class="swiper-slide swiper-slide-active" style="width: 171.8px; margin-right: 50px;">
                        <a href="{{ route('tiktok.user', ['id' => $item->id]) }}">
                            <img class="img-fluid" src="{{ $item->avatar }}" alt="banner">
                            <span class="d-block text-dark">{{ $item->uniqueId }}</span>
                            <span class="d-block font-size-xsmall text-dark">
                                <i class="feather icon-users"></i>
                                {{ number_format($item->follercount) }}
                            </span>
                            <span class="d-block font-size-xsmall text-dark">
                                <i class="feather icon-heart"></i>
                                {{ number_format($item->heart) }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false">
            </div>
            <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide"
                aria-disabled="false"></div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>
</div>
