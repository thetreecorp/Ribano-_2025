
@extends($theme.'layouts.app')
@section('title',trans('Sucesss'))

@section('content')
    <div class="container mt-5 mb-5">
        <a href="{{ url('/') }}"><img src="{{asset('public/assets/images')}}/success.png" alt="success image" /></a>
    </div>
   
@endsection
