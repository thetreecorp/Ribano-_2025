@if (count($data))
@foreach ($data as $project)
    <div class="col-md-4 wow fadeInUp col-box">

        @include('project.project_box' , compact('project'))
    </div>
@endforeach
@else
<p class="no-result">{{trans('No project found')}}</p>
@endif

