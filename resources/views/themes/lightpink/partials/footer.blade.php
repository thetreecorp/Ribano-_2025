{{-- @inject('common', 'App\Http\Controllers\ProjectController')
@php
$currency_code = Session::get('currency_code');
$currencies = $common->getCurrencies();
$lang = Session::get('trans') ?? 'US';




$get_currency = (Session::get('currency')) ? (Session::get('currency')) : 'USD';
$get_country = (Session::get('country')) ? (Session::get('country')) : 'AE';

$languageArray = json_decode($languages, true) ? json_decode($languages, true) : array();
if(array_key_exists( $lang, $languageArray))
$lang = $languageArray[$lang];

@endphp --}}
<!-- footer_area_start -->
<section class="footer_area">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-sm-6">
                <div class="footer_widget">
                    <div class="widget_logo">
                        <h5><a href="{{url('/')}}" class="site_logo">
                        <img src="{{asset('assets/images/ribano500-233-darkbg.png')}}" alt="{{config('basic.site_title')}}"></a></h5>
                        @if(isset($contactUs['contact-us'][0]) && $contact = $contactUs['contact-us'][0])
                            <p class="">@lang(strip_tags(@$contact->description->footer_short_details))</p>
                        @endif
                    </div>
                    @if(isset($contentDetails['social']))
                        <div class="social_area mt-50">
                            <ul class="">
                                @foreach($contentDetails['social'] as $data)
                                <li><a href="{{@$data->content->contentMedia->description->link}}" target="_blank"><i class="{{@$data->content->contentMedia->description->icon}}"></i></a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                @if(getRTL('rtl') == 1)
                    {{-- <x-top-menu></x-top-menu> --}}
                    {{-- <div class="language-select footer-select">
                        <select class="form-control select2">
                            @foreach ($languageArray as $key => $l)
                            <option value="{{$key}}" @if ($lang==$l) selected @endif> {{$l}}</option>

                            @endforeach
                        </select>
                    </div>

                    <div class="country-select footer-select">


                        @if(config('country'))
                        <select class="form-control select2">
                            @foreach(config('country') as $value)
                            <option value="{{$value['code']}}" @if ($value['code']==$get_country) selected @endif> {{$value['name']}}
                            </option>
                            @endforeach
                        </select>
                        @endif
                    </div> --}}

                @endif

            </div>

            <div class="col-lg-2 col-sm-6 {{(session()->get('rtl') == 1) ? 'pe-lg-3': 'ps-lg-3'}}">
                <div class="footer_widget ps-lg-2">
                    <h5>@lang('Links') <span class="highlight"></span></h5>
                    <ul>
                        <li>
                            <a href="{{route('about')}}">{{translate('About')}}</a>
                        </li>
                        <li>
                            <a href="#">{{translate('Investment strategy')}}</a>
                        </li>
                        <li>
                            <a href="#">{{@translate('How it work')}}</a>
                        </li>
                        <li>
                            <a href="{{route('searchProject')}}">{{@translate('Projects')}}</a>
                        </li>

                        <li>
                            <a href="{{route('blog')}}">{{@translate('Blog')}}</a>
                        </li>

                        <li>
                            <a href="{{route('faq')}}">{{@translate('FAQs')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 pt-sm-0 pt-3 ps-lg-3 {{(session()->get('rtl') == 1) ? 'pe-lg-5': 'ps-lg-5'}}">
                <div class="footer_widget">
                    <h5>{{@translate('Partners')}} <span class="highlight"></span></h5>
                    <ul>
                        <li>
                            <a href="#">{{@translate('Enterpreuners')}}</a>
                        </li>
                        <li>
                            <a href="#">{{@translate('Investors')}}</a>
                        </li>
                        <li>
                            <a href="#">{{@translate('Service providers')}}</a>
                        </li>
                        <li>
                            <a href="#">{{@translate('Job seekers')}}</a>
                        </li>


                    </ul>
                    {{-- @isset($contentDetails['support'])
                        <ul>
                            @foreach($contentDetails['support'] as $data)
                                <li>
                                    <a href="{{route('getLink', [slug($data->description->title), $data->content_id])}}">@lang($data->description->title)</a>
                                </li>
                            @endforeach
                            <li>
                                <a href="{{route('faq')}}">@lang('FAQ')</a>
                            </li>
                        </ul>
                    @endif --}}
                </div>
            </div>

            @if(isset($contactUs['contact-us'][0]) && $contact = $contactUs['contact-us'][0])
                <div class="col-lg-3 col-sm-6 pt-sm-0 pt-3">


                    <div class="footer_widget">
                        <h5>{{@translate('Contact Us')}} <span class="highlight"></span></h5>
                        <p>@lang(@$contact->description->address)</p>
                        <p>@lang(@$contact->description->email)</p>
                        <p>@lang(@$contact->description->phone)</p>
                    </div>
                    <div class="footer_widget">
                        <ul>
                            @foreach($contentDetails['support'] as $data)
                                <li>
                                    <a href="{{route('getLink', [slug($data->description->title), $data->content_id])}}">@lang($data->description->title)</a>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                    {{-- <x-top-menu></x-top-menu> --}}


                </div>
            @endif
        </div>
    </div>
</section>
<!-- footer_area_end -->

<!-- copy_right_area_start -->
<div class="copy_right_area text-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p>{{@translate('Copyright')}} &copy; {{date('Y')}} @lang($basic->site_title) {{@translate('All Rights Reserved')}} </p>
            </div>
        </div>
    </div>
</div>
<!-- copy_right_area_end -->
