{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{@translate('Payment Failed')}}</title>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
    <link href="{{asset('assets/admin/css/success-failed.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset($themeTrue.'assets/fontawesome/fontawesome.min.js')}}"></script>
</head>
<body>
<header class="site-header" id="header">
 
    @if (session('message'))
        <h1 data-lead-id="site-header-title">
            {{ session('message') }}
        </h1>
    @else
        <h1 data-lead-id="site-header-title">{{@translate('Sorry!')}}</h1>
            
    @endif
</header>

<div class="main-content">
    <i class="fa fa-times main-content__times" id="checkmark"></i>
    <p class="main-content__body" data-lead-id="main-content-body">{{@translate('We really appreciate you giving us a moment of your time today but unfortunately the payment was unsuccessful due to')}} {{ session('error') ?? translate('it seems some issue in server to server communication. Kindly connect with administrator') }}</p>
</div>
<footer class="site-footer" id="footer">
    <a href="{{ url('/') }}">{{@translate('Go back to Home')}}</a>
    <p class="site-footer__fineprint" id="fineprint">{{@translate('Copyright')}} ©{{ date('Y') }} | {{@translate('All Rights Reserved')}} <a href="{{ url('/') }}">{{ $basic->site_title ?? 'Photoica' }}</a></p>
</footer>
</body>
</html> --}}

@extends($theme.'layouts.app')
@section('title',trans('failed'))

@section('content')
    <div class="container mt-5 mb-5">
        @if (session('message'))
            <h1 data-lead-id="site-header-title">
                {{ session('message') }}
            </h1>
            @else
            <h1 data-lead-id="site-header-title">{{@translate('Sorry!')}}</h1>
            
        @endif
        <div class="main-content" style="min-height: 300px">
            
            <p class="main-content__body" data-lead-id="main-content-body">{{@translate('We really appreciate you giving us a moment of your time today but unfortunately the payment was unsuccessful due to')}} {{ session('error') ?? translate('it seems some issue in server to server communication. Kindly connect with administrator') }}</p>
        </div>
    </div>
   
@endsection

