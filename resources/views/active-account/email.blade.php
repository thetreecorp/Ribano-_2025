@extends($theme.'layouts.app', ['body_class' => 'active-by-email hide-top-section'])
@section('title',__('Active By Email'))

@section('content')

<!-- login_signup_area_start -->
<section class="login_signup_area">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-8 mx-auto col-md-8">
                <div class="login_signup_form p-4">
                    <div class="section_header text-center">
                        <h4 class="pt-30 pb-30">{{@translate('Active account by email')}}</h4>
                    </div>
                    <form id="request-active-email" action="{{route('sendOtpEmailVerify')}}" method="post">
                        @csrf

                        <div class="input-group mb-3">
                            <input required type="email" name="email" class="form-control" value="" placeholder="Email Address">
                            <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-envelope"></i></span>
                        </div>

                        <button type="submit" class="mt-1 mb-1 send-active-email btn custom_btn btn-block m-t-10"
                            >{{translate('Send Otp')}}</button>
                    </form>
                    <form id="frm-email-active" action="{{route("activeAccount")}}" method="post">
                        <div class="mt-4 mb-4"><span class="reset-password-link">{{translate("If do not receive OTP ")}}?
                                <a class="btn-link text-danger send-active-email"
                                    href="javascript:void(0)">{{translate("Resend")}}</a></span>
                        </div>
                        <input type="hidden" name="country_code" value="{{old('country_code')}}" class="text-dark">

                        <p>{{@translate('Enter OTP')}}</p>
                        <div class="input-group mb-3">
                            <input type="text" name="otp_code" class="form-control" placeholder="{{@translate('Otp')}}">
                            <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock"></i></span>
                        </div>


                        @if(basicControl()->reCaptcha_status_registration)
                        <div class="col-md-6 box mb-4 form-group">
                            {!! NoCaptcha::renderJs(session()->get('translate')) !!}
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