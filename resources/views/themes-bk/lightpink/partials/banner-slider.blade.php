<section class="hero-slider hero-style container">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="slide-inner slide-bg-image" data-background="{{asset('public')}}/assets/images/bg-for-all.jpg">
                    <div class="container">
                        <div data-swiper-parallax="300" class="slide-title">
                            <h2>{{@translate("Establish the right partnership according to Islamic principles")}}</h2>
                        </div>
                        @include($theme.'partials.slider-box-text')
                        <div class="clearfix"></div>
                        {{-- <div data-swiper-parallax="500" class="slide-btns">
                            <a href="#" class="theme-btn-s2">Register now</a>
                            <a href="#" class="theme-btn-s3"><i class="fas fa-chevron-circle-right"></i> Get Info</a>
                        </div> --}}
                    </div>
                </div>
                <!-- end slide-inner -->
            </div>
            <!-- end swiper-slide -->

            <div class="swiper-slide">
                <div class="slide-inner slide-bg-image" data-background="{{asset('public')}}/assets/images/bg-for-all.jpg">
                    <div class="container">
                        <div data-swiper-parallax="300" class="slide-title">
                            <h2>@translate("Socially responsible Investing")</h2>
                        </div>
                        @include($theme.'partials.slider-box-text')
                        <div class="clearfix"></div>
                        
                    </div>
                </div>
                <!-- end slide-inner -->
            </div>
            <div class="swiper-slide">
                <div class="slide-inner slide-bg-image" data-background="{{asset('public')}}/assets/images/bg-for-all.jpg">
                    <div class="container">
                        <div data-swiper-parallax="300" class="slide-title">
                            <h2>{{@translate("Here's where the right investor meets the right founder")}}</h2>
                        </div>
                        @include($theme.'partials.slider-box-text')
                        <div class="clearfix"></div>
                        
                    </div>
                </div>
                <!-- end slide-inner -->
            </div>
            <!-- end swiper-slide -->
        </div>
        <!-- end swiper-wrapper -->

        <!-- swipper controls -->
        {{-- <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div> --}}
    </div>
</section>
