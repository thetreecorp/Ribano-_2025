@extends($theme.'layouts.app', ['body_class' => 'active-by-phone hide-top-section'])
@section('title',__('Active By Phone'))

@section('content')

<!-- login_signup_area_start -->
<section class="login_signup_area">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-8 mx-auto col-md-8">
                <div class="login_signup_form p-4">
                    <div class="section_header text-center">
                        <h4 class="pt-30 pb-30">{{@translate('Active Account')}}</h4>
                    </div>
                    <form id="request-active-phone" action="{{ route('sendOtpPhoneVerify') }}" method="post">
                        @csrf
                      
                        <div class="input-group mb-3">
                            @php
                            $country_code = (string) @getIpInfo()['code'] ?: null;
                            $myCollection = collect(config('country'))->map(function($row) {
                                return collect($row);
                            });
                            $countries = $myCollection->sortBy('code');
                            @endphp
            
                            <select name="phone_code" class="form-control country_code dialCode-change register_phone_select">
                                @foreach(config('country') as $value)
                                <option value="{{$value['phone_code']}}" data-name="{{$value['name']}}"
                                    data-code="{{$value['code']}}" {{$country_code==$value['code'] ? 'selected' : '' }}>
                                    {{$value['name']}} ({{$value['phone_code']}})
                                </option>
                                @endforeach
                            </select>
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-globe-americas"></i></span>
            
                            <input type="text" name="phone" class="form-control dialcode-set" value="{{old('phone')}}"
                                placeholder="{{@translate('Phone Number')}}">
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone"></i></span>
            
                        </div>
                        
                        <a href="javascript:void(0)" class="mt-1 mb-1 send-active-phone-otp active-phone btn custom_btn btn-block m-t-10" type="submit">{{trans('Send Otp')}}</a>
                        <div class="mt-4 mb-4"><span class="reset-password-link">{{translate("If do not receive OTP ")}}?
                            <a class="btn-link text-danger send-active-phone-otp" href="javascript:void(0)">{{translate("Resend")}}</a></span>
                        </div>
                    </form>
                        
                    <form id="frm-phone-active" action="{{ route('activeAccount') }}" method="post">
                        <input type="hidden" name="country_code" value="{{old('country_code')}}" class="text-dark">
            
                        <p>{{@translate('Enter OTP')}} {{translate(" last 4 digits of missed call")}}</p>
                        <div class="input-group mb-3">
                            <input type="text" name="otp_code" class="form-control" placeholder="{{translate('Otp')}}">
                            <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock"></i></span>
                        </div>
            
                       
                        @if(basicControl()->reCaptcha_status_registration)
                            <div class="col-md-6 box mb-4 form-group">
                                {!! NoCaptcha::renderJs(session()->get('trans')) !!}
                                {!! NoCaptcha::display($basic->theme == 'deepblack' ? ['data-theme' => 'dark'] : []) !!}
                                @error('g-recaptcha-response')
                                <span class="text-danger mt-1">{{@translate($message)}}</span>
                                @enderror
                            </div>
                        @endif
                        <button type="submit" class="btn custom_btn mt-30 w-100">{{@translate('Active')}}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- login_signup_area_end -->
@endsection

@push('script')
<script>
    "use strict";
        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                setDialCode();
            });
            function setDialCode() {
                let currency = $('.dialCode-change').val();
                $('.dialcode-set').val(currency);
            }
        });

</script>
@endpush