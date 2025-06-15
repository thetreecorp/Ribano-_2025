

    @if(array_key_exists('home-slider', $contentDetails->toArray()))
    <section class="hero-slider hero-style container">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($contentDetails['home-slider']->take(5)->sortDesc() as $k => $data)
                    {{-- <div class="image_area">
                        <img src="{{getFile(config('location.content.path').@$data->content->contentMedia->description->image)}}"
                             alt="@lang('blog-image')">
                    </div> --}}
                    <div class="swiper-slide">
                        <div class="slide-inner slide-bg-image" data-background="{{getFile(config('location.content.path').@$data->content->contentMedia->description->image)}}">
                            <div class="container" >
                                <div data-swiper-parallax="300" class="slide-title">
                                    <h2>{{$data->description->title}}</h2>
                                </div>
                                @include($theme.'partials.slider-box-text', ['desc' => $data->description->description])
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <!-- end slide-inner -->
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @else
        <section class="hero-slider hero-style container">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-inner slide-bg-image" data-background="{{asset('assets/images/bg-for-all.jpg')}}">
                            <div class="container">
                                <div data-swiper-parallax="300" class="slide-title">
                                    <h2>{{@translate("Establish the right partnership according to Islamic principles")}}</h2>
                                </div>
                                @include($theme.'partials.slider-box-text', ['desc' => ''])
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
                        <div class="slide-inner slide-bg-image" data-background="{{asset('assets/images/bg-for-all.jpg')}}">
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
                        <div class="slide-inner slide-bg-image" data-background="{{asset('assets/images/bg-for-all.jpg')}}">
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
    @endif
