@extends($theme.'layouts.app')
@section('title',trans('Home'))

@section('content')
    @include($theme.'partials.banner-slider')
    {{-- @include($theme.'partials.heroBanner') --}}
    @include($theme.'partials.featured-project')
    @include($theme.'sections.feature')
    @include($theme.'sections.about-us')
    @include($theme.'sections.why-chose-us')
    {{-- @include($theme.'sections.investment') --}}
    @include($theme.'sections.how-it-work-tab')
    @include($theme.'sections.why-invest')
    @include($theme.'sections.we-accept')
    @include($theme.'sections.faq')
    {{-- @include($theme.'sections.referral') --}}
    {{-- @include($theme.'sections.testimonial') --}}
   
    {{-- @include($theme.'sections.how-it-work') --}}
    {{-- @include($theme.'sections.investor')
    @include($theme.'sections.deposit-withdraw')
    @include($theme.'sections.blog') --}}
   
    @include($theme.'sections.news-letter')
@endsection
