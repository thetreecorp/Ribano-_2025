<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js {{(getRTL('rtl') == 1) ? 'rtl' : ''}}" @if(getRTL('rtl') == 1) dir="rtl" @endif >
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    @include('partials.seo')

    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/all.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/fontawesome.min.css')}}"/>
    <link href="{{asset('public/assets/css/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/aiz-core.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/vendor.css')}}" rel="stylesheet">
    @stack('css-lib')

    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/magnific-popup.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/custom.css')}}">
    <script src="{{asset($themeTrue.'js/modernizr.custom.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">
    <link href="{{asset('public/assets/css/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/summernote.css')}}" rel="stylesheet">
    @stack('style')


    <script>
    	var AIZ = AIZ || {};
        AIZ.local = {
            nothing_selected: 'Nothing selected',
            nothing_found: 'Nothing found',
            choose_file: 'Choose file',
            file_selected: 'File selected',
            files_selected: 'Files selected',
            items_selected: 'Items selected',
            add_more_files: 'Add more files',
            adding_more_files: 'Adding more files',
            drop_files_here_paste_or: 'Drop files here, paste or',
            browse: 'Browse',
            upload_complete: 'Upload complete',
            upload_paused: 'Upload paused',
            resume_upload: 'Resume upload',
            pause_upload: 'Pause upload',
            retry_upload: 'Retry upload',
            cancel_upload: 'Cancel upload',
            uploading: 'Uploading',
            processing: 'Processing',
            complete: 'Complete',
            file: 'File',
            files: 'Files',
        }
	</script>
</head>

<body onload="preloder_function()" class="{{ $body_class ?? ''}}">

<!-- preloader_area_start -->
<div id="preloader">
</div>
<!-- preloader_area_end -->

<header id="header-section">
    <div class="overlay">
        <!-- TOPBAR -->
        @include($theme.'partials.topbar')
        <!-- /TOPBAR -->
    </div>
</header>

@include($theme.'partials.banner')

@yield('content')

@include($theme.'partials.footer')

@stack('extra-content')

<a href="#" class="scroll_up">
    <i class="fas fa-arrow-up"></i>
</a>

@include($theme.'partials.convertable_note')

<script src="{{asset($themeTrue.'js/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/owl.carousel.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/jquery.counterup.min.js')}}"></script>

@stack('extra-js')

<script src="{{asset('assets/global/js/notiflix-aio-2.7.0.min.js')}}"></script>
<script src="{{asset('assets/global/js/pusher.min.js')}}"></script>
<script src="{{asset('assets/global/js/vue.min.js')}}"></script>
<script src="{{asset('assets/global/js/axios.min.js')}}"></script>
<!-- custom script -->
<script src="{{asset($themeTrue.'js/main.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
<script src="{{ asset('public/assets/js/toastr.min.js') }}"></script>
<script src="{{asset('public/assets/js/custom.js')}}"></script>
<script src="{{asset('public/assets/js/summernote.min.js')}}"></script>
<script src="{{asset('public/assets/js/vendors.js')}}"></script>

<script src="{{asset('public/assets/js/aiz-core.js')}}"></script>
@stack('script')

<script>
    var root = document.querySelector(':root');
    root.style.setProperty('--theme_color', '{{config('basic.base_color')??'#ff007a'}}');
    root.style.setProperty('--btn_bg1', '{{config('basic.base_color')??'#ff007a'}}');

    root.style.setProperty('--theme_light_color', '{{config('basic.base_light_color')??'#ff3178'}}');
    root.style.setProperty('--bright_pink', '{{config('basic.base_light_color')??'#ff3178'}}');

    root.style.setProperty('--theme_secondary_color', '{{config('basic.secondary_color')??'#8037c6'}}');
    root.style.setProperty('--heading_color', '{{config('basic.heading_color')??'#001064'}}');

    
    // HERO SLIDER
    var menu = [];
    jQuery('.swiper-slide').each( function(index){
        menu.push( jQuery(this).find('.slide-inner').attr("data-text") );
    });
    var interleaveOffset = 0.05;
    var swiperOptions = {
       // loop: true,
        speed: 500,
        // parallax: true,
        autoplay: false,
        // autoplay: {
        //     delay: 5000,
        // },
       // watchSlidesProgress: true,
        pagination: {
            // el: '.swiper-pagination',
            // clickable: true,
        },

        navigation: {
            // nextEl: '.swiper-button-next',
            // prevEl: '.swiper-button-prev',
        },

        // on: {
        //     progress: function() {
        //         var swiper = this;
        //         for (var i = 0; i < swiper.slides.length; i++) {
        //             var slideProgress = swiper.slides[i].progress;
        //             var innerOffset = swiper.width * interleaveOffset;
        //             var innerTranslate = slideProgress * innerOffset;
        //             swiper.slides[i].querySelector(".slide-inner").style.transform =
        //             "translate3d(" + innerTranslate + "px, 0, 0)";
        //         }      
        //     },

        //     touchStart: function() {
        //       var swiper = this;
        //       for (var i = 0; i < swiper.slides.length; i++) {
        //         swiper.slides[i].style.transition = "";
        //       }
        //     },

        //     setTransition: function(speed) {
        //         var swiper = this;
        //         for (var i = 0; i < swiper.slides.length; i++) {
        //             swiper.slides[i].style.transition = speed + "ms";
        //             swiper.slides[i].querySelector(".slide-inner").style.transition =
        //             speed + "ms";
        //         }
        //     }
        // }
    };

    var swiper = new Swiper(".swiper-container", swiperOptions);

    // DATA BACKGROUND IMAGE
    var sliderBgSetting = $(".slide-bg-image");
    sliderBgSetting.each(function(indx){
        if ($(this).attr("data-background")){
            $(this).css("background-image", "url(" + $(this).data("background") + ")");
        }
    });


</script>

@auth
    <script>
        'use strict';
        let pushNotificationArea = new Vue({
            el: "#pushNotificationArea",
            data: {
                items: [],
            },
            mounted() {
                this.getNotifications();
                this.pushNewItem();
            },
            methods: {
                getNotifications() {
                    let app = this;
                    axios.get("{{ route('user.push.notification.show') }}")
                        .then(function (res) {
                            app.items = res.data;
                        })
                },
                readAt(id, link) {
                    let app = this;
                    let url = "{{ route('user.push.notification.readAt', 0) }}";
                    url = url.replace(/.$/, id);
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.getNotifications();
                                if (link != '#') {
                                    window.location.href = link
                                }
                            }
                        })
                },
                readAll() {
                    let app = this;
                    let url = "{{ route('user.push.notification.readAll') }}";
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.items = [];
                            }
                        })
                },
                pushNewItem() {
                    let app = this;
                    // Pusher.logToConsole = true;
                    let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                        encrypted: true,
                        cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                    });
                    let channel = pusher.subscribe('user-notification.' + "{{ Auth::id() }}");
                    channel.bind('App\\Events\\UserNotification', function (data) {
                        app.items.unshift(data.message);
                    });
                    channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                        app.getNotifications();
                    });
                }
            }
        });
    </script>
@endauth

@if (session()->has('success'))
    <script>
        Notiflix.Notify.Success("@lang(session('success'))");
    </script>
@endif

@if (session()->has('error'))
    <script>
        Notiflix.Notify.Failure("@lang(session('error'))");
    </script>
@endif

@if (session()->has('warning'))
    <script>
        Notiflix.Notify.Warning("@lang(session('warning'))");
    </script>
@endif
<script src="{{asset('public/vendor/livewire/livewire.js')}}"></script>
@livewireScripts

@include('plugins')
<script>
    window.addEventListener('scrollToError', event => {
        console.log(event);
        console.log(event.detail.customErrors);
        let error = event.detail.customErrors;
        if(error) {
            const element = document.getElementById('errorDiv');
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }
        
    })
</script>
</body>

</html>
