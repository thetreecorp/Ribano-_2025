@inject('common', 'App\Http\Controllers\User\HomeController')
@extends('admin.layouts.app')
@section('title')
    @lang("Invest Log")
@endsection
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

    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{route('admin.investments.search')}}" method="get">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="user_name" value="{{@request()->user_name}}" class="form-control get-username"
                                       placeholder="@lang('Username')">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" class="form-control" name="datetrx" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-search"></i> @lang('Search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <table class="categories-show-table table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>@lang('SL')</th>
                    <th>@lang('Name')</th>
                    <th>@lang('Project')</th>
                    <th >@lang('Number Token')</th>
                    <th>@lang('Token Name')</th>
                    <th>@lang('Created at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($investments as $key => $invest)



                    <tr>
                        <td data-label="@lang('SL')">
                            {{loopIndex($investments) + $key}}
                        </td>

                        <td data-label="@lang('Name')">
                            <a href="{{route('admin.user-edit',$invest->user_id)}}" target="_blank">
                                <div class="d-flex no-block align-items-center">
                                    <div class="mr-3"><img src="{{getFile(config('location.user.path').optional($invest->user)->image) }}" alt="user" class="rounded-circle" width="45" height="45">
                                    </div>
                                    <div class="">
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">
                                            @lang(optional($invest->user)->firstname) @lang(optional($invest->user)->lastname)
                                        </h5>
                                        <span class="text-muted font-14"><span>@</span>@lang(optional($invest->user)->username)</span>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td data-label="@lang('Plan')">
                            {{($invest->getProject->title)}}
                        </td>

                        <td data-label="@lang('Return Interest')" class="text-capitalize">
                            {{$invest->totalToken}}
                        </td>
                        <td data-label="@lang('Received Amount')">
                            {{$common->getTokenName($invest->project_id)}}
                        </td>

                        <td data-label="@lang('Upcoming Payment')">
                            {{$invest->created_at}}

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-danger" colspan="8">@lang('No User Data')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $investments->links('partials.pagination') }}
        </div>

    </div>
@endsection

@push('js')
    <script>
        "use strict";
        $(document).ready(function () {
            $(document).on('click', '#check-all', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            $(document).on('change', ".row-tic", function () {
                let length = $(".row-tic").length;
                let checkedLength = $(".row-tic:checked").length;
                if (length == checkedLength) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
            });

        });
    </script>
@endpush
