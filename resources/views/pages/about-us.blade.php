@extends($theme.'layouts.app', ['body_class' => 'my-pitches hide-top-section'])
@push('style')

@endpush
@section('title',__('About us'))
@inject('common', 'App\Http\Controllers\ProjectController')
@section('content')

<div class="my_pitches_area pd0">

    <div class="banner-section">
        <div class="banner-section-inner">
            <h1>{{translate("About us")}}</h1>
        </div>
    </div>
    <div class="container">
        @if ($contact)
            <div class="page-content">
                @if($contact->title)
                    <h4>{{$contact->title}}</h4>
                @endif
                
                @if($contact->page_content)
                    <div class="about-content">{!!$contact->page_content !!}</div>
                @endif
                
            </div>
        @endif
        
    </div>
    
    
</div>
@endsection

@push('script')

@endpush