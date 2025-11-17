@inject('common', 'App\Http\Controllers\ProjectController')
@php
    $currency_code = Session::get('currency_code');
    $currencies = $common->getCurrencies();
    $lang_code = $lang = Session::get('trans');



    $get_currency = (Session::get('currency')) ? (Session::get('currency')) : 'USD';

    $languageArray = json_decode($languages, true) ? json_decode($languages, true) : array();
    if(array_key_exists( $lang, $languageArray))
    $lang = $languageArray[$lang];


@endphp
<!-- Header_area_start -->
<div class="header_area fixed-to" id="header_top">
    <!-- Header_top_area_start -->
    <div class="header_top_area">
        <div class="container">
            {{-- <div class="row align-items-center g-3">
                <div class="col-md-7 text-center">
                    <div class="header_top_left  d-none d-sm-block">
                        @if(isset($contactUs['contact-us'][0]) && $contact = $contactUs['contact-us'][0])
                        <ul class="d-flex justify-content-md-start justify-content-center">
                            <li><i class="fa-solid fa-envelope"></i> <a
                                    href="mailto:{{@translate(@$contact->description->email)}}">{{@translate(@$contact->description->email)}}</a>
                            </li>
                            <li><i class="fa-solid fa-phone"></i> <a
                                    href="tel:{{@translate(@$contact->description->phone)}}">{{@translate(@$contact->description->phone)}}</a>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="col-md-5 ">
                    @php
                    //echo $get_currency;
                    @endphp
                    <div
                        class="header_top_right d-flex justify-content-md-end justify-content-center align-items-center">
                        <div class="language_select_area">
                            <div class="dropdown">
                                <button class="custom_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <?php //echo $lang ? $lang : 'Eng' ?>
                                </button>

                                <ul class="dropdown-menu">
                                    @foreach ($languageArray as $key => $lang)
                                    <li><a class="dropdown-item" href="{{route('language',$key)}}"><span
                                                class="flag-icon flag-icon-{{strtolower($key)}}"></span> {{$lang}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="currencies-select">


                            @if($currencies)
                            <select class="form-control">
                                @foreach ($currencies as $key => $currency)
                                <option value="{{ $currency->code }}" @if ($currency->code == $get_currency) selected
                                    @endif

                                    data-currency="{{ $currency->code }}">{{ $currency->name }}
                                    ({{ $currency->symbol }})

                                </option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        @if(isset($contentDetails['social']))
                        <div class="login_area">
                            <ul class="social_area d-flex">
                                @foreach($contentDetails['social'] as $data)
                                <li><a href="{{@$data->content->contentMedia->description->link}}" target="_blank"
                                        class="{{session()->get('trans') == $key ? 'lang_active' : ''}}"><i
                                            class="{{@$data->content->contentMedia->description->icon}}"></i></a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div> --}}
            <div class="custom-top-head">
                <div class="col-md-12">
                    <div class="header_top_right d-flex justify-content-md-end justify-content-center align-items-center">

                        <div class="currencies-select">


                            @if($currencies)
                            <select class="form-control">
                                @foreach ($currencies as $key => $currency)
                                <option value="{{ $currency->code }}" @if ($currency->code == $get_currency) selected
                                    @endif

                                    data-currency="{{ $currency->code }}">{{ $currency->name }}
                                    ({{ $currency->symbol }})

                                </option>
                                @endforeach
                            </select>
                            @endif
                        </div>

                        <div class="language_select_area">
                            <div class="dropdown">
                                <button class="custom_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <?php echo $lang ? $lang : 'Eng' ?>
                                </button>

                                <ul class="dropdown-menu">
                                    @foreach ($languageArray as $key => $lang)
                                    <li><a class="dropdown-item" href="{{route('language',$key)}}"><span
                                                class="flag-icon flag-icon-{{strtolower($key)}}"></span> {{$lang}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header_top_area_end -->

    <!-- Nav_area_start -->

    <div class="nav_area">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
            <div class="container custom_nav">
                <a class="logo" href="{{url('/')}}"><img src="{{getFile(config('location.logoIcon.path').'logo.png')}}"
                        alt="{{config('basic.site_title')}}"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="bars"><i class="fa-solid fa-bars-staggered"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="menus navbar-nav ms-auto text-center align-items-center align-items-center">
                        @include($theme.'partials.menu')
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}"> {{@translate('Home')}}</a>
                        </li>
                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside">{{@translate('Invest')}}
                                <i class="fas fa-comments-dollar"></i>
                            </a>
                            <ul class="dropdown-menu shadow">
                                <li>
                                    <a class="dropdown-item{{Request::routeIs('contact') ? 'active' : ''}}"
                                        href="{{route('contact')}}">{{@translate('Investment methods')}}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{Request::routeIs('contact') ? 'active' : ''}}"
                                        href="#">{{@translate('Explore Projects')}}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{Request::routeIs('searchProject') ? 'active' : ''}}"
                                        href="{{route('searchProject')}}">{{@translate('Search Projects')}}</a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside">{{@translate('Fundraising')}}
                                <i class="fas fa-hand-holding-usd"></i>
                            </a>
                            <ul class="dropdown-menu shadow">
                                @role('founder')
                                    <li>
                                        <a class="dropdown-item {{Request::routeIs('fundDashboard') ? 'active' : ''}}"
                                            href="{{route('founder.fundDashboard')}}">{{@translate('My Pitches')}}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{Request::routeIs('createProject') ? 'active' : ''}}"
                                            href="{{route('founder.myInvestors')}}">{{@translate('My Investors')}}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{Request::routeIs('contact') ? 'active' : ''}}"
                                            href="{{route('investorSearch')}}">{{@translate('Investor Search')}}</a>
                                    </li>


                                @else
                                    <li>
                                        <a class="dropdown-item {{Request::routeIs('contact') ? 'active' : ''}}"
                                            href="#">{{@translate('How to apply')}}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{Request::routeIs('createProject') ? 'active' : ''}}"
                                            href="{{route('user.createProject')}}">{{@translate('Add a pitch')}}</a>
                                    </li>
                                @endrole


                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside">{{@translate('Help')}}
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <ul class="dropdown-menu shadow ">
                                <li>
                                    <a class="dropdown-item {{Request::routeIs('contact') ? 'active' : ''}}"
                                        href="#">{{@translate('How it works')}}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{Request::routeIs('entrepreneursFaqsPage') ? 'active' : ''}}"
                                        href="{{route('entrepreneursFaqsPage')}}">{{@translate('Fundraise FAQ')}}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{Request::routeIs('investorsFaqsPage') ? 'active' : ''}}"
                                        href="{{route('investorsFaqsPage')}}">{{@translate('Invest FAQ')}}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{Request::routeIs('contact') ? 'active' : ''}}"
                                        href="#">{{@translate('About Us')}}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{Request::routeIs('contact') ? 'active' : ''}}"
                                        href="#">{{@translate('Company information')}}</a>
                                </li>

                            </ul>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"> {{@translate('Sign in')}}</a>

                            </li>
                            <li class="nav-item">
                                <a class="login_btn" href="{{ route('register') }}"> {{@translate('Sign up')}}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="" href="{{ route('user.home') }}"> {{@translate('Dashboard')}}</a>
                            </li>
                        @endguest --}}



                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Nav_area_end -->

    <div class="mobile">
        <div class="hamburger-menu">
            <div class="bar"></div>
        </div>
    </div>
    <div class="mobile-nav hide">
        <ul>
            @include($theme.'partials.menu')
        </ul>
      </div>

</div>

<!-- Header_area_end -->
