@inject('common', 'App\Http\Controllers\User\HomeController')
@extends($theme.'layouts.user')
@section('title',trans('Transaction History'))
@section('content')

<div class="container-fluid">
    <div class="main row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">@lang('Transaction History')</h3>
            </div>
            <!-- table -->
            <div class="table-parent table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">@lang('SL')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Number Token')</th>
                            <th scope="col">@lang('Token Name')</th>
                            <th scope="col">@lang('Token Symbol')</th>
                            <th scope="col">@lang('View Transaction')</th>
                            <th scope="col">@lang('Created at')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userTokens as $key => $invest)
                        <tr>
                            <td>{{loopIndex($userTokens) + $key}}</td>
                            <td>
                                {{$invest->total_amount ?? ''}}$
                            </td>
                            <td>
                                {{$invest->number_token}} {{!empty($invest->token) ? $invest->token->token_symbol : ''}}
                            </td>
                            <td>
                                {{!empty($invest->token) ? $invest->token->name : ''}}
                            </td>
                            <td>
                                {{!empty($invest->token) ? $invest->token->token_symbol : ''}}
                            </td>
                            <td>
                                <?php if($invest->hash):  ?>
                                <a href="{{createHashLink($invest->hash, 1)}}" target="_blank">{{trans('View
                                    transaction')}}</a>
                                <?php endif; ?>

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
                {{ $userTokens->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection