@extends('admin.layouts.app')
@section('title',trans('Send Token'))
@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{route('admin.planList')}}" class="btn btn-sm  btn-primary mr-2">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>

            @if ($status)
                <form id="send_token_frm" method="post" action="{{route('admin.sendTokenAjax')}}" class="form-row justify-content-center">
                 
    
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label>{{$findAccount->name}} </label>
                                <p> Total Token: <span style="color: red">{{$total_token}}</span> {{$token_symbol}}</p>
                            </div>
                            <div class="col-md-6">
                                <label>@lang('To account')</label>
                                <input type="text" id="account_address" name="account_address" value="" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>@lang('Number token')</label>
                                <input type="number" min="1" max="{{$total_token}}" id="number_token" name="number_token_sent" value="" class="form-control">
                            </div>
    
    
    
                        </div>
                        
                        <div class="row fl-edit-token">
                            <div class="form-group col-sm-4 ">
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                                    <span>@lang('Send')</span>
                                </button>
                            </div>
                        </div>
                        
    
                    </div>
                </form>
            @else
                <p>{{trans('Token not exist for near protocol')}}</p>
            @endif
            
        </div>
    </div>
@endsection


@push('js')
    <script>
        "use strict";

        const myInput = document.getElementById("number_token");

        myInput.addEventListener("input", function () {
            const enteredValue = parseFloat(myInput.value);
        
            const maxValue = parseFloat(myInput.getAttribute("max"));
        
            if (!isNaN(enteredValue) && enteredValue > maxValue) {
                myInput.value = maxValue;
            }
        });
        $(document).on('change', '#plan_price_type', function () {
            var isCheck = $(this).prop('checked');
            if (isCheck == false) {
                $('.rangeAmount').addClass('d-block');
                $('.fixedAmount').removeClass('d-block');
                $('.fixedAmount').addClass('d-none');
            } else {
                $('.rangeAmount').removeClass('d-block');
                $('.fixedAmount').addClass('d-block');
            }
        });

        @if ($status)
           $("#send_token_frm").submit(function(e) {
    
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var actionUrl = form.attr('action');
            showToastV2('Sending data...', 4000, 'warning');
            $.ajax({
                //headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: actionUrl,
                data: {
                    old_owner_id: '{{$findAccount->name}}',
                    receiver_id: $('#account_address').val(),
                    amount: $('#number_token').val(),
                    memo: 'Token sent form Ribano',
                    contract: '{{$findAccount->name}}',
                    private_key: '{{$findAccount->private_key}}',
                    "_token": "{{ csrf_token() }}",
                },
                datatType: 'json',
                type: "post",
                success: function (data) {
                   // console.log(data);
                    if(data.code == '400')
                        showToastV2('Error', 1000, 'error');
                    else {
                        showToastV2('Token sent', 1000, 'success');
                        location.reload();
                       
                    }
                },
            });
            
            });
        @endif
        


    </script>

    
@endpush
