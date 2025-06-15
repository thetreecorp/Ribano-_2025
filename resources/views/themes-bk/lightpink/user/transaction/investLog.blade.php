@inject('common', 'App\Http\Controllers\User\HomeController')
@extends($theme.'layouts.user')
@section('title',trans('Invest History'))
@section('content')
    <script>
        "use strict"
        function getCountDown(elementId, seconds) {
            var times = seconds;
            var x = setInterval(function () {
                var distance = times * 1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "COMPLETE";
                }
                times--;
            }, 1000);
        }
    </script>

    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >
                    <h3 class="mb-0">@lang('Invest History')</h3>
                </div>
                <!-- table -->
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Project')</th>
                                <th scope="col">@lang('Number Token')</th>
                                <th scope="col">@lang('Token Name')</th>
                                <th scope="col">@lang('Created at')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($investments as $key => $invest)
                            <tr>
                                <td>{{loopIndex($investments) + $key}}</td>
                                <td>
                                    {{($invest->getProject->title)}}
                                </td>
                                <td>
                                   {{$invest->totalToken}}
                                </td>
                                <td>
                                   {{$common->getTokenName($invest->project_id)}}
                                </td>
                                <td>
                                    {{$invest->created_at}}
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="100%">{{trans('No Data Found!')}}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $investments->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
