@extends($theme.'layouts.app', ['body_class' => 'my-pitches hide-top-section'])
@push('style')

@endpush
@section('title',__('Entrepreneur FAQ'))
@inject('common', 'App\Http\Controllers\ProjectController')
@section('content')

<div class="my_pitches_area pd0">

    <div class="banner-section">
        <div class="banner-section-inner">
            <h1>{{translate("Investor Terms")}}</h1>
        </div>
    </div>
    <div class="container">
        @if ($config)
            <div class="page-content">
                @if($config->title)
                    <h4>{{$config->title}}</h4>
                @endif
                
                @if($config->page_content)
                    <div class="about-content">{!!$config->page_content !!}</div>
                @endif
                
            </div>
        @endif
        
    </div>
    
    
</div>
@endsection

@push('script')

@endpush