@extends($theme.'layouts.app', ['body_class' => 'news-feed hide-top-section'])
@section('title',__('Newsfeed'))

@section('content')

<!-- login_signup_area_start -->
<section class="newsfeed_area pd0">

    <div class="container">
        
        <div class="news__feeds_wrapper">
            <div class="news__feeds_container">
                <livewire:news-feed />
            </div>
            @if($news_feeds)
                <div id="news__feeds_content">
                    <?php $i = 0; ?>
                    @foreach ($news_feeds as $news)
                        @include('fundraising.newsfeed_box')
                    @endforeach
                    @else
                        <div class="news__feeds_container">
                            <p>{{translate("No newsfeed")}}</p>
                        </div>
                </div>
               
            @endif
        </div>
        <!-- Data Loader -->
        <div class="auto-load text-center" style="display: none;">
            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                <path fill="#000"
                    d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                    <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50"
                        to="360 50 50" repeatCount="indefinite" />
                </path>
            </svg>
        </div>
        
       
       
        
        
    </div>
</section>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
   
        var ENDPOINT = "{{ route('newsFeed') }}";
        var page = 1;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= ($(document).height() - 20)) {
            page++;
            infinteLoadMore(page);
            }
        });
        function infinteLoadMore(page) {
            $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
            .done(function (response) {
                if (response.html == '') {
                    $('.auto-load').html("We don't have more data to display :(");
                    return;
                }
  
                $('.auto-load').hide();
                $("#news__feeds_content").append(response.html);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
        }
</script>
@endpush