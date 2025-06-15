@inject('common', 'App\Http\Controllers\ProjectController')
@if (count($data))
@foreach ($data as $img)
    @if($img)                          
        <a class="horizontal" data-fancybox="gallery" data-src="{{$common->getLinkIdrive($img)}}">
            <img src="{{$common->getLinkIdrive($img)}}" />
        </a>
    @endif
@endforeach
@else
    <p class="no-result">{{trans('No project found')}}</p>
@endif

