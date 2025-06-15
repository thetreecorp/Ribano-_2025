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
    @include('partials.seo')

    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/all.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/fontawesome.min.css')}}"/>

    {{-- public --}}
    <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet">
    {{--  --}}
    @stack('css-lib')

    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/magnific-popup.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset($themeTrue.'css/style.css')}}">
    {{-- public --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom.css')}}">
    {{--  --}}
    <script src="{{asset($themeTrue.'js/modernizr.custom.js')}}"></script>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    {{-- public --}}
    <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('public/assets/css/summernote.css')}}" rel="stylesheet"> --}}
    <link href="{{asset('assets/css/summernote-lite.min.css')}}" rel="stylesheet">
    {{--  --}}

    @livewireStyles

    @stack('style')

    <style>

    </style>


    {{-- <script type="application/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script type="application/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

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
{{-- <script src="{{ asset('public/assets/js/swiper.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

{{-- public/ --}}
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/summernote-lite.min.js')}}"></script>
{{--  --}}
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
        loop: true,
        speed: 500,
        // parallax: true,
        autoplay: true,
        autoplay: {
            delay: 5000,
        },
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
<script src="{{asset('vendor/livewire/livewire.js')}}"></script>
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



    function createSummernote($id) {

        $('#' + $id).summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link']],
            ],
            callbacks: {

            }
        });
    }

    var ids = [];

    function callSummernote() {
        window.addEventListener('initSummernote', event => {
            console.log(event.detail.id);
            let $id = (event.detail.id);

            ids.push($id);
            if($id) {
                createSummernote($id)
            }

        });
    }

    callSummernote();


    function removeDuplicates(arr) {
        var unique = {};
        arr.forEach(function(i) {
            if(!unique[i]) {
                unique[i] = true;
            }
        });
        return Object.keys(unique);
    }


    document.addEventListener('livewire:load', function () {

        setTimeout(() => {
            Livewire.hook('element.updated', (el, component) => {


                ids = removeDuplicates(ids);
                ids.forEach(element => {

                console.log(element);

                $('#' + element).summernote({
                    height: 200,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['insert', ['link']],
                    ],
                    callbacks: {

                    }
                });
            });


        })
        }, 2000);


    });
    $(".show-help").click(function () {
        $("#help-modal").modal("show");
    });

</script>


<div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p>A SAFE (Simple Agreement for Future Equity) convertible note is a type of financial instrument commonly used in early-stage startup funding rounds. It is a form of debt that can convert into equity in the future under certain predefined conditions.</p>

                <p>Here are some key characteristics of a SAFE convertible note:</p>
                <ul>
                    <li>Convertible Debt: A SAFE is a debt instrument that has the potential to convert into equity at a later stage, typically during a future equity financing round. Instead of setting a repayment date or interest rate, it offers investors the right to convert their investment into equity.</li>
                    <li>Conversion Trigger: The conversion of the SAFE into equity is usually triggered by a specific event, such as the company's next equity financing round, which is often referred to as a qualified financing round. The terms of the conversion are typically outlined in the SAFE agreement.</li>
                    <li>Conversion Mechanics: When the conversion event occurs, the investor has the option to convert the outstanding balance of the SAFE into equity based on predetermined terms, such as a conversion price or discount to the price per share in the qualified financing round.</li>
                    <li>Lack of Valuation: Unlike traditional convertible notes, a SAFE does not establish an explicit valuation of the company at the time of investment. This allows for simpler and quicker negotiations between investors and startups since the valuation is determined in a future financing round.</li>
                    <li>Investor Protections: SAFEs often include investor-friendly provisions, such as a discount on the conversion price, a valuation cap that limits the company's valuation for conversion purposes, and occasionally, other rights or privileges.</li>
                    <li>Lack of Interest and Repayment Terms: SAFEs typically do not accrue interest or have specific repayment terms. Instead, they convert into equity upon the occurrence of a conversion event.</li>

                </ul>
                <p>SAFE (Simple Agreement for Future Equity) convertible note contract. Here are the explanations for some important terms :</p>

                <ol>
                    <li><strong>Exercise Price:</strong> The exercise price, also known as the conversion price, is the predetermined price at which the convertible note will convert into equity or stock in the company. It is typically set at a discount to the price per share in a future equity financing round.</li>

                    <li><strong>Exercise Date:</strong> The exercise date is the date on which the conversion of the convertible note into equity or stock can occur. It is usually triggered by a specific event, such as a qualified financing round or an acquisition of the company.</li>

                    <li><strong>Purchase Price:</strong> The purchase price refers to the amount of money the investor pays to acquire the convertible note. It is the principal amount of the investment made by the investor.</li>

                    <li><strong>Discount:</strong> The discount is a benefit offered to the investor upon conversion of the convertible note. It allows the investor to convert the note into equity at a lower price per share compared to the price per share paid by new investors in a subsequent financing round. The discount is typically expressed as a percentage.</li>

                    <li><strong>Maturity Date:</strong> The maturity date is the date on which the convertible note matures and becomes due for repayment if it has not already been converted into equity. At maturity, the company is obligated to repay the principal amount of the note along with any accrued interest, unless a conversion event has occurred.</li>
                </ol>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
          </div>
        </div>
    </div>
</body>

</html>
