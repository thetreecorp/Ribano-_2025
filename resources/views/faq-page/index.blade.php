@extends($theme.'layouts.app', ['body_class' => 'my-pitches hide-top-section'])
@push('style')
{{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> --}}

@endpush
@section('title',__('Entrepreneur FAQ'))
@inject('common', 'App\Http\Controllers\ProjectController')
@section('content')

<div class="my_pitches_area pd0">

    <div class="banner-section">
        <div class="banner-section-inner">
            <h1>Entrepreneur FAQ </h1></div>
        </div>
    </div>
    <div class="container">
        

        <?php $i = 0; $j = 0; ?>
        @if ($faqs)
            {{-- <div class="ain-body">
                <div class="container">
                    <div class="question-wrap-divs">
                        @foreach ( $faqs as $faq)
                            <h5><a href="#question_"> {{++$i}}.  {{$faq->name}}</a> </h5>
                        @endforeach
                    </div>
                </div>
            </div> --}}
            @if ($faqs)
                <div class="row mb-4">
                    @foreach($faqs as $k => $faq)
                        @if ($faq->name)
                            <div class="col-md-12" data-aos="fade-left">
                                <div class="accordion_area mt-45">
                                    <div class="accordion_item shadow3">
                                        <button class="accordion_title">{{$faq->name}}<i
                                                class="{{($k == 0) ? 'fa fa-minus': 'fa fa-plus' }}"></i></button>
                                        <div class="accordion_body {{($k == 0) ? 'show' : ''}}">
                                            {!! nl2br($faq->description) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    
                    @endforeach
                </div>
            @endif
        @else
            <div class="ain-body">
                {{translate("No faq found")}}  
            </div>
        @endif
        {{-- @if ($faqs)
            <div class="answer-wrap-div">
                @foreach ( $faqs as $faq)
                    <div class="answer-item" id="question_{{$j}}">
                        {!! nl2br($faq->description) !!}
                    </div>
                @endforeach
            </div>
        
        @endif --}}
        
        
    </div>
    
    
</section>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
{{-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{asset('public/assets/js/simplePagination.js')}}"></script> --}}
<script>
        $('.question-wrap-divs h5 a').click(function (e) {
            e.preventDefault();
            var id = this.hash;
            var target = $(id);
            window.scrollTo(target, 500, {offset: -20});
        })

        
</script>
@endpush