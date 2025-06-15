@extends('admin.layouts.app')
@section('title',trans('Edit Token'))
@section('content')

<div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="media mb-4 justify-content-end">
            <a href="{{route('admin.planList')}}" class="btn btn-sm  btn-primary mr-2">
                <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
            </a>
        </div>

        <form method="post" action="{{route('admin.planUpdate',[$data->id])}}" class="form-row justify-content-center">
            @csrf
            @method('put')

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input disabled type="text" id="token_name" name="name" value="{{old('name', $data->name)}}"
                                class="form-control">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="schedule">@lang('Select Project')</label>
                        <select name="project_id" id="project_id" class="form-control">
                            <option value="" disabled>@lang('Select a project')</option>
                            @foreach($projects as $item)
                            <option {{ old('project_id', $data->project_id) == $item->id ? 'selected' : '' }}
                                value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group ">
                            <label for="">{{translate('Token Icon')}}</label>
                            {{-- <input accept="image/*" name="icon" id="t_icon" type="file" class="form-control"> --}}

                            <img id="imgb64" src="{{$data->token_icon}}" style="max-height: 120px">
                            <input id="b64" type="hidden" name="token_icon" value="{{$data->token_icon}}">
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="form-group">
                            <label>@lang('Token Symbol')</label>
                            <input disabled required id="token_symbol" type="text" name="token_symbol"
                                value="{{$data->token_symbol}}" placeholder="@lang('Token Symbol')"
                                class="form-control">
                            @error('token_symbol')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group col-md-6 min_amount d-block">
                        <label>@lang('Number of withdrawal days')</label>
                        <div class="input-group mb-3">
                            <input required value="{{$data->set_withdraw_date}}" type="number" name="set_withdraw_date"
                                class="form-control" placeholder="Set withdrawal date">

                        </div>
                        @error('min_buy_amount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{--
                    <div class="form-group col-md-6 fixedAmount d-block">
                        <label>@lang('Total Supply')</label>
                        <div class="input-group mb-3">
                            <input disabled id="total_supply" type="number" name="fixed_amount"
                                value="{{$data->fixed_amount}}" class="form-control" placeholder="0.00">

                        </div>

                        @error('fixed_amount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class=" col-md-6">
                        <div class="form-group">
                            <label>@lang('Token decimals')</label>
                            <input disabled id="token_decimals" required type="number" name="token_decimals"
                                value="{{$data->token_decimals}}" placeholder="@lang('Token decimals')"
                                class="form-control">
                            @error('token_decimals')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6 d-none">
                        <div class="form-group">
                            <label>@lang('Plan Price Type')</label>
                            <input data-toggle="toggle" id="plan_price_type" class="amount" data-onstyle="success"
                                data-offstyle="info" data-on="Fixed" data-off="Range" data-width="100%" type="checkbox"
                                @if($data->fixed_amount != 0) checked @endif name="plan_price_type">


                            @error('plan_price_type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}



                    <div class="form-group col-md-6 priceAmount d-block">
                        <label>@lang('Price')</label>
                        <div class="input-group mb-3">
                            <input type="text" name="token_price" value="{{old('price', $data->token_price)}}"
                                class="form-control" placeholder="0.00">

                        </div>
                        @error('token_price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 fixedAmount d-block">
                        <label>@lang('Min Amount')</label>
                        <div class="input-group mb-3">
                            <input type="number" name="min_buy_amount"
                                value="{{old('min_buy_amount', $data->min_buy_amount)}}" class="form-control"
                                placeholder="0.00">

                        </div>

                        @error('fixed_amount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>







                    <div class="form-group col-md-6 rangeAmount d-none">
                        <label>@lang('Minimum Amount')</label>
                        <div class="input-group mb-3">
                            <input type="text" name="minimum_amount"
                                value="{{old('minimum_amount', $data->minimum_amount)}}" class="form-control"
                                placeholder="0.00">
                            <div class="input-group-append">
                                <span class="input-group-text">@lang(config('basic.currency_symbol'))</span>
                            </div>
                        </div>
                        @error('minimum_amount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 rangeAmount d-none">
                        <label>@lang('Maximum Amount')</label>
                        <div class="input-group mb-3">
                            <input type="text" name="maximum_amount"
                                value="{{old('maximum_amount', $data->maximum_amount)}}" class="form-control"
                                placeholder="0.00">
                            <div class="input-group-append">
                                <span class="input-group-text">@lang(config('basic.currency_symbol'))</span>
                            </div>
                        </div>
                        @error('maximum_amount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-md-6 d-none">
                        <label>@lang('Yield')</label>
                        <div class="input-group mb-3">
                            <input type="text" name="profit" class="form-control"
                                value="{{old('profit', $data->profit)}}" placeholder="0.00">
                            <div class="input-group-append">
                                <select name="profit_type" id="profit_type" class="form-control">
                                    <option value="1" @if($data->profit_type == 1) selected @endif>%</option>
                                    <option value="0" @if($data->profit_type == 0) selected
                                        @endif>@lang(config('basic.currency_symbol'))</option>
                                </select>
                            </div>
                        </div>
                        @error('profit')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-md-6 d-none">
                        <label for="schedule">@lang('Accrual')</label>

                        <select name="schedule" id="schedule" class="form-control">
                            <option value="" disabled>@lang('Select a Period')</option>
                            @foreach($times as $item)
                            <option value="{{$item->time}}" {{ old('schedule', $data->schedule) == $item->time ?
                                'selected' : '' }}>
                                @lang('Every') {{$item->name}}
                            </option>
                            @endforeach
                        </select>

                        @error('schedule')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-sm-6 d-none">
                        <label>@lang('Return')</label>

                        <input data-toggle="toggle" id="is_lifetime" data-onstyle="success" data-offstyle="info"
                            data-on="PERIOD" data-off="LIFETIME" data-width="100%" type="checkbox"
                            @if($data->is_lifetime =='0') checked @endif name="is_lifetime">

                        @error('is_lifetime')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 repeatable d-none">
                        <label>@lang('Maturity')</label>

                        <div class="input-group mb-3">
                            <input type="text" name="repeatable" value="{{old('repeatable', $data->repeatable)}}"
                                class="form-control" placeholder="@lang('How many times')">
                            <div class="input-group-append">
                                <span class="input-group-text">@lang('Times')</span>
                            </div>
                        </div>
                        @error('repeatable')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-sm-4 d-none">
                        <label>@lang('Capital back')</label>
                        <input data-toggle="toggle" id="is_capital_back" data-onstyle="success" data-offstyle="info"
                            data-on="YES" data-off="NO" data-width="100%" type="checkbox" @if($data->is_capital_back)
                        checked @endif name="is_capital_back">

                        @error('is_capital_back')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>


                    {{-- <div class="form-group col-sm-4 ">
                        <label>@lang('Featured')</label>
                        <input data-toggle="toggle" id="featured" data-onstyle="success" data-offstyle="info"
                            data-on="YES" data-off="NO" data-width="100%" type="checkbox" @if($data->featured) checked
                        @endif name="featured">
                        @error('featured')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-sm-4 ">
                        <label>@lang('Status')</label>

                        <input data-toggle="toggle" id="status" data-onstyle="success" data-offstyle="info"
                            data-on="Active" data-off="Deactive" data-width="100%" type="checkbox" @if($data->status)
                        checked @endif name="status">

                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div> --}}


                </div>

                <div class="row fl-edit-token">
                    <div class="form-group col-sm-4 ">
                        <button type="submit"
                            class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                            <span><i class="fas fa-save pr-2"></i> @lang('Save Changes')</span>
                        </button>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <div id="create-token-wrap"></div>

                        {{-- <div id="create-account-wrap"></div> --}}
                    </div>
                </div>


            </div>
        </form>
    </div>
</div>
@endsection


@push('js')
<script>
    "use strict";

        $(document).ready(function () {
            let priceType = $('#plan_price_type').prop('checked');
            if (priceType == false) {
                $('.rangeAmount').addClass('d-block');
                $('.fixedAmount').removeClass('d-block');
                $('.fixedAmount').addClass('d-none');
            } else {
                $('.rangeAmount').removeClass('d-block');
                $('.fixedAmount').addClass('d-block');
            }


            let lifetimeType = $('#is_lifetime').prop('checked');
            if (lifetimeType == false) {
                // $('.repeatable').removeClass('d-block');
                // $('.repeatable').addClass('d-none');
            } else {
                // $('.repeatable').removeClass('d-none');
                // $('.repeatable').addClass('d-block');
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

        $(document).on('change','#is_lifetime', function () {
            var isCheck = $(this).prop('checked');
            if (isCheck == false) {
                $('.repeatable').removeClass('d-block');
                $('.repeatable').addClass('d-none');
            } else {
                $('.repeatable').removeClass('d-none');
                $('.repeatable').addClass('d-block');
            }
        })

        $(document).ready(function () {
            $('select[name=schedule], select[name=project_id]').select2({
                selectOnClose: true
            });
        });


</script>

@if ($errors->any())
@php
$collection = collect($errors->all());
$errors = $collection->unique();
@endphp
<script>
    "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{trans($error)}}");
            @endforeach
</script>
@endif
@endpush