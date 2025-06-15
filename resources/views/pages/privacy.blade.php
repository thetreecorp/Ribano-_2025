@extends($theme.'layouts.app', ['body_class' => 'my-pitches hide-top-section'])
@push('style')

@endpush
@section('title',__('Privacy Policy'))
@inject('common', 'App\Http\Controllers\ProjectController')
@section('content')

<div class="my_pitches_area pd0">

    <div class="banner-section">
        <div class="banner-section-inner">
            <h1>{{translate("Privacy Policy")}}</h1>
        </div>
    </div>
    <div class="container">
        @if ($privacy)
            <div class="page-content">
                @if($privacy->title)
                    <h4>{{$privacy->title}}</h4>
                @endif
                
                @if($privacy->page_content)
                    <div class="about-content">{!!$privacy->page_content !!}</div>
                @endif
                
            </div>
        @endif
        
    </div>
    
    
</div>
@endsection

@push('script')

@endpush