@inject('common', 'App\Http\Controllers\ProjectController')
<div class="gallery-wrap container">
    <h5>{{translate('Galleries')}}</h5>
    <div class="loading-spin"></div>
    <div class="gallery-row">
        @foreach ($imagesPerPage as $img)
           
            @if($img)
                
                <a class="horizontal" data-fancybox="gallery" data-src="{{$common->getLinkIdrive($img)}}">
                    <img src="{{$common->getLinkIdrive($img)}}" />
                </a>
            @endif
           
           
        @endforeach
    </div>
</div>





