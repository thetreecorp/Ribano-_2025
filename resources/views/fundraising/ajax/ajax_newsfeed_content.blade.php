@if (count($news_feeds))
    @foreach ($news_feeds as $news)
        @include('fundraising.newsfeed_box' , compact('news'))
    @endforeach
@endif