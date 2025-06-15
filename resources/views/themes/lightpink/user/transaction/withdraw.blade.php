@inject('common', 'App\Http\Controllers\User\HomeController')
@extends($theme.'layouts.user')
@section('title',trans('Withdrawable'))
@section('content')

<div class="container-fluid">
    <div class="main row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">@lang('Withdrawable')</h3>
            </div>
            <!-- table -->
            <?php if($type == 'draw'): ?>
            <?php 
                $tokens = getWithdrawableTokens(auth()->user()->id);
                //dd($wallets);
            ?>
            <?php if(count($tokens) == 0): ?>
            <p>{{trans("No tokens have been unlocked yet.")}}</p>
            <?php else: ?>
            <form method="post" id="withdraw-form" action="{{route('user.createWithdrawRequest')}}">
                @csrf
                <div class="row">
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label>{{trans('Token Name')}}</label>
                            <select required="" id="token-select" onchange="updateTokenNumber()" class="form-control"
                                name="choose_token">
                                <option data-token="0" value="">{{trans('select token')}}</option>
                                @foreach ($tokens as $key => $tk )
                                <option data-token="{{$tk}}" value="{{$key}}">{{ getTokenName($key) }} - {{$tk}}
                                    {{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                    </diV>
                    <div class="col-6 mb-2">
                        <div class="form-group related">
                            <label>{{trans('Number Token')}}</label>
                            <input oninput="checkInputValue()" id="number_token" required="" type="number"
                                name="number_token" class="form-control" placeholder="number token withdraw">
                            <span id="fill-max" class="input-group-append">Max</span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group related">
                            <p class="mb-2 red">{{trans('Please be careful, incorrect address may cause you to lose your
                                money.')}}</p>
                            <label>{{trans('Withdrawal wallet address')}}</label>
                            <input required="" id="wallet_address" required="" type="text" name="wallet_address"
                                class="form-control" placeholder="Withdrawal wallet address">
                            @if (count($wallets))
                                <p class="mt-3">{{trans('Recent wallet')}}</p>
                                <ul>
                                    @foreach ($wallets as $item)
                                        <li>{{$item}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 mt-4">
                        <button type="submit" id="withdraw_token_button"
                            class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-4"><span><i
                                    class="fas fa-save pr-2"></i>
                                {{trans('Save Changes')}}</span></button>
                    </div>
                </div>
            </form>
            <?php endif; ?>

            <?php else: ?>
            <div class="table-parent table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">@lang('SL')</th>

                            <th scope="col">@lang('Total Token')</th>
                            <th scope="col">@lang('Token Name')</th>
                            <th scope="col">@lang('Withdrawable')</th>
                            <th scope="col">@lang('Withdraw History')</th>
                            <th scope="col">@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userTokens as $key => $invest)
                        <tr>
                            <td>{{loopIndex($userTokens) + $key}}</td>

                            <td>
                                {{$invest->totalToken}} {{!empty($invest->token) ? $invest->token->token_symbol : ''}}
                            </td>
                            <td>
                                {{!empty($invest->token) ? $invest->token->name : ''}}
                            </td>
                            <td>
                                {{!empty($invest->withdrawableTokens) ? $invest->withdrawableTokens : '0'}}
                            </td>
                            <td>
                                <?php  $count_withdraw = getTokenCount($invest->user_id, $invest->token_id);  ?>
                                
                                <?php if($count_withdraw['pending']): ?>
                                    <span class="badge badge-danger">{{trans('Pending')}}: {{$count_withdraw['pending']}}</span>
                                <?php endif; ?>
                                
                                <?php if($count_withdraw['approved']): ?>
                                    <span class="badge badge-success">{{trans('Approved')}}: {{$count_withdraw['approved']}}</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(!empty($invest->withdrawableTokens)):?>
                                <a href="{{route('user.withdraw')}}?type=draw">{{trans('Withdraw')}}</a>
                                <?php endif; ?>
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
            <?php endif; ?>

        </div>
    </div>
</div>
@endsection


@push('script')
    <script src="{{ asset('public/assets/js/sweetalert2@11.js') }}"></script>
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
    <script>
        $('#withdraw-form').submit(function(event) {
               event.preventDefault();
                
                if($("#withdraw-form")[0].checkValidity()) {
                   
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        success: function(data) {
                            if(data.code == 200) {
                                Swal.fire({
                                    title: data.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
            
                                        location.reload();
                                    }
                                })
                            }
                            else {
                                Swal.fire(
                                    'Error',
                                    data.message,
                                    'error'
                                );
                                
                            }
                        },
                        error: function(xhr, status, error) {
                          
                            console.log(xhr.responseText);
                        }
                    });
                }
                
            });
        
    </script>
@endpush
@push('style')
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
            cursor: pointer;
            color: red;
            z-index: 999;
        }
    </style>
@endpush