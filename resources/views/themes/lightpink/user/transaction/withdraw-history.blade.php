@inject('common', 'App\Http\Controllers\User\HomeController')
@extends($theme.'layouts.user')
@section('title',trans('Withdraw history'))
@section('content')

<div class="container-fluid">
    <div class="main row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">@lang('Withdraw history')</h3>
            </div>
            <!-- table -->
            
            <div class="table-parent table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">@lang('SL')</th>

                            <th scope="col">@lang('Total Token')</th>
                            <th scope="col">@lang('Token Name')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Transaction (approved)')</th>
                            <th scope="col">@lang('Created at')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userTokens as $key => $invest)
                        <tr>
                            <td>{{loopIndex($userTokens) + $key}}</td>

                            <td>
                                {{$invest->number_token}} {{!empty($invest->token) ? $invest->token->token_symbol : ''}}
                            </td>
                            <td>
                                {{!empty($invest->token) ? $invest->token->name : ''}}
                            </td>
                            <td>
                                {{$invest->status}}
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

<script>
    var maxTokenNumber = 0;
    function updateTokenNumber() {
        var selectedOption = document.getElementById('token-select').options[document.getElementById('token-select').selectedIndex];
        maxTokenNumber = parseInt(selectedOption.getAttribute('data-token'));
        document.getElementById('number_token').value = 0;
       
    }
    
    function checkInputValue() {
        var inputValue = parseInt(document.getElementById('number_token').value);
        if (inputValue > maxTokenNumber) {
          document.getElementById('number_token').value = maxTokenNumber;
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('fill-max').addEventListener('click', function() {
        document.getElementById('number_token').value = maxTokenNumber;
      });
    });
</script>
<style>
    .related {
        position: relative;
    }
    .red {
        color: red;
    }
    .input-group-append {
        position: absolute;
        right: 4px;
        top: 24px;
        padding: 5px;
        background-color: #fff;
        /* border: 1px solid #ccc; */
        cursor: pointer;
        color: red;
        z-index: 999;
    }
</style>