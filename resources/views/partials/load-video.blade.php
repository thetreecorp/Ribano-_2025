@inject('common', 'App\Http\Controllers\ProjectController')
<div class="row" id="video-wrap">
    @foreach ($videosPerPage as $video) 
        @if($common->generateVideoEmbedUrl($video[0] ?? NULL))
            <div class="video-container col-sm-6">
                <div class="video-ct">
                    @if(array_key_exists(1, $video))
                        <h6>{{$video[1]}}</h6>
                    @endif
                    @if(array_key_exists(2, $video))
                        <div class="video-description">{{$video[2]}}</div>
                    @endif
                </div>
                
                
                <iframe allowfullscreen width="100%" height="250" src="{{$common->generateVideoEmbedUrl($video[0])}}">
                </iframe>
            </div>
        @endif
    @endforeach
</div>






