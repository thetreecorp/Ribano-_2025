@extends($theme.'layouts.app')
@section('title',__('Register'))

@section('content')
    <!-- login_signup_area_start -->
    <section class="login_signup_area">
        <div class="container">
            <div class="row align-items-center">

                {{-- <div class="col-lg-7 col-md-5">
                    <div class="login_signup_banner">
                        <div class="image_area animation1">
                            <img src="{{ asset($themeTrue.'img/login/1.png') }}" alt="">
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-8 mx-auto col-md-8">
                    <div class="login_signup_form p-4">
                        <div class="section_header text-center">
                            <h4 class="pt-30 pb-30">@lang('Create New Account')</h4>
                        </div>
                        <form action="{{ route('register') }}" method="post">
                            @csrf

                            @if(session()->get('sponsor') != null)
                                <div class="col-md-12">
                                    <div class="form-group mb-30">
                                        <label>@lang('Sponsor Name')</label>
                                        <input type="text" name="sponsor" class="form-control" id="sponsor"
                                               placeholder="{{trans('Sponsor By') }}"
                                               value="{{session()->get('sponsor')}}" readonly>
                                    </div>
                                </div>
                            @endif

                            <div class="register-intro">
                                <p>{{trans("It's easy to create a pitch using our online form. Your pitch can be in front of our investors before you know it.")}}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" value="investor" name="role" type="radio" id="investor">
                                        <label class="form-check-label" for="investor">
                                            {{trans("I'm an Investor")}}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" value="capital-agents" name="role" type="radio" id="capital-agents">
                                        <label class="form-check-label" for="capital-agents">
                                            {{trans("I'm an Capital Agents ")}}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" value="founder" type="radio" name="role" id="enerpreuner" checked>
                                        <label class="form-check-label" for="founder">
                                            {{trans("I'm an Entrepreneur")}}
                                        </label>
                                    </div>
                                </div>

                            </div>



                            <p>@lang('First Name')</p>
                            <div class="input-group mb-3">
                                <input type="text" name="firstname" class="form-control" value="{{old('firstname')}}" placeholder="@lang('First Name')">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-pen-to-square"></i></span>
                            </div>
                            @error('firstname')
                                <span class="text-danger mt-1 mb-2">@lang($message)</span>
                            @enderror

                            <p>@lang('Last Name')</p>
                            <div class="input-group mb-3">
                                <input type="text" name="lastname" class="form-control" value="{{old('lastname')}}" placeholder="@lang('Last Name')">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-pen-to-square"></i></span>
                            </div>
                            @error('lastname')
                                <span class="text-danger mt-1">@lang($message)</span>
                            @enderror

                            <p>@lang('Username')</p>
                            <div class="input-group mb-3">
                                <input type="text" name="username" class="form-control" value="{{old('username')}}" placeholder="@lang('User Name')">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-pen-to-square"></i></span>
                            </div>
                            @error('username')
                                <span class="text-danger mt-1">@lang($message)</span>
                            @enderror

                            <p>@lang('Email Address')</p>
                            <div class="input-group mb-3">
                                <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="@lang('Email Address')">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-regular fa-envelope"></i></span>
                            </div>
                            @error('email')
                                <span class="text-danger mt-1">@lang($message)</span>
                            @enderror


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
                                        <option value="{{$value['phone_code']}}"
                                                data-name="{{$value['name']}}"
                                                data-code="{{$value['code']}}"
                                            {{$country_code == $value['code'] ? 'selected' : ''}}
                                        > {{$value['name']}} ({{$value['phone_code']}})
                                        </option>
                                    @endforeach
                                </select>
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-globe-americas"></i></span>

                                <input type="text" name="phone" class="form-control dialcode-set" value="{{old('phone')}}" placeholder="@lang('Phone Number')">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone"></i></span>

                            </div>
                            @error('phone')
                            <span class="text-danger mt-1">@lang($message)</span>
                            @enderror

                            <input type="hidden" name="country_code" value="{{old('country_code')}}" class="text-dark">

                            <p>@lang('Password')</p>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control" placeholder="@lang('Password')">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock"></i></span>
                            </div>
                            @error('password')
                                <span class="text-danger mt-1">@lang($message)</span>
                            @enderror

                            <p>@lang('Confirm password')</p>
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock"></i></span>
                            </div>
                            @error('password_confirmation')
                                <span class="text-danger mt-1">@lang($message)</span>
                            @enderror

                            @if(basicControl()->reCaptcha_status_registration)
                                <div class="col-md-6 box mb-4 form-group">
                                    {!! NoCaptcha::renderJs(session()->get('trans')) !!}
                                    {!! NoCaptcha::display($basic->theme == 'deepblack' ? ['data-theme' => 'dark'] : []) !!}
                                    @error('g-recaptcha-response')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                    @enderror
                                </div>
                            @endif


                            {{-- Investor --}}
                            <div id="section-investor" class="role-section  mb-4">
                                <h5>@lang('Partner / Investor Details')</h5>
                                <p class="text-muted">@lang('Invest in diversified opportunities and participate in profit-share across curated portfolios.')</p>

                                <div class="accordion" id="investorAccordion">

                                    {{-- ===== A.1 Profile ===== --}}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingProfile">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfile" aria-expanded="true" style="color:#6777ef">
                                                @lang('A.1 Profile')
                                            </button>
                                        </h2>
                                        <div id="collapseProfile" class="accordion-collapse collapse show" aria-labelledby="headingProfile" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">
                                                <div>
                                                    <p>@lang('Full Name')</p>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="investor_fullname" class="form-control mb-2" placeholder="@lang('Full Name')" value="{{ old('investor_fullname') }}" required>
                                                        <span class="input-group-text" id="basic-addon3"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_fullname')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>


                                                <div>
                                                    <p>@lang('Date of Birth')</p>
                                                    <div class="input-group mb-3">
                                                        <input type="date" name="investor_dob" class="form-control mb-2" value="{{ old('investor_dob') }}" required>
                                                        <span class="input-group-text" id="basic-addon4"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_dob')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>


                                                <div>
                                                    <p>@lang('Nationality')</p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_nationality" class="form-control mb-2" required>
                                                            @foreach(config('country') as $value)
                                                                <option value="{{ $value['code'] }}" {{ old('investor_nationality') == $value['code'] ? 'selected' : '' }}>
                                                                    {{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon5"><i class="fa fa-globe-americas"></i></span>
                                                    </div>
                                                    @error('investor_nationality')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <p>@lang('Residential Address')</p>

                                                    <div class="input-group mb-3">
                                                        <textarea name="investor_address" class="form-control mb-2" required>{{ old('investor_address') }}</textarea>

                                                        <span class="input-group-text" id="basic-addon6"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_address')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <p>@lang('Tax Residency')</p>

                                                    <div class="input-group mb-3">
                                                        <select name="investor_tax_residency" class="form-control mb-2" required>
                                                            @foreach(config('country') as $value)
                                                                <option value="{{ $value['code'] }}" {{ old('investor_tax_residency') == $value['code'] ? 'selected' : '' }}>
                                                                    {{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon7"><i class="fa fa-globe-americas"></i></span>
                                                    </div>
                                                    @error('investor_tax_residency')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>


                                                <div>
                                                    <p>@lang('ID Type & Number')</p>

                                                    <div class="d-flex gap-2 mb-2">
                                                        <div class="w-50">
                                                            <div class="input-group mb-3">
                                                                <select name="investor_id_type" class="form-control" required>
                                                                    <option value="passport" {{ old('investor_id_type') == 'passport' ? 'selected' : '' }}>@lang('Passport')</option>
                                                                    <option value="national_id" {{ old('investor_id_type') == 'national_id' ? 'selected' : '' }}>@lang('National ID')</option>
                                                                    <option value="driver_license" {{ old('investor_id_type') == 'driver_license' ? 'selected' : '' }}>@lang('Driver\'s License')</option>
                                                                </select>
                                                                <span class="input-group-text" id="basic-addon8"><i class="fa fa-globe-americas"></i></span>
                                                            </div>
                                                            @error('investor_id_type')
                                                                <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                            @enderror
                                                        </div>

                                                        <div class="w-50">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="investor_id_number" class="form-control" placeholder="@lang('ID Number')" value="{{ old('investor_id_number') }}" required>
                                                                <span class="input-group-text" id="basic-addon9"><i class="fa-regular fa-pen-to-square"></i></span>

                                                            </div>
                                                            @error('investor_id_number')
                                                                <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>


                                                <div>
                                                    <p>@lang('ID Document Upload')</p>

                                                    <div class="input-group mb-3">
                                                        <input type="file" name="investor_id_document" accept=".jpg,.jpeg,.png,.pdf" class="form-control mb-2" required>

                                                        <span class="input-group-text" id="basic-addon10"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_id_document')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <p>@lang('Selfie / Liveness Check')</p>

                                                    <div class="input-group mb-3">
                                                        <input type="file" name="investor_selfie" accept=".jpg,.jpeg,.png" class="form-control mb-2" required>

                                                        <span class="input-group-text" id="basic-addon11"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_selfie')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>


                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn  btn-primary btn-next" data-next="#collapseCategory" style="background-color: #ff5400;border:1px solid #ff5400">@lang('Next')</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- ===== A.2 Investor Category ===== --}}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingCategory">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="false" style="color:#6777ef">
                                                @lang('A.2 Investor Category')
                                            </button>
                                        </h2>
                                        <div id="collapseCategory" class="accordion-collapse collapse" aria-labelledby="headingCategory" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">

                                                 <div>
                                                    <p>@lang('Type of User')</p>
                                                    <div class="input-group mb-3">
                                                       <select name="investor_type" class="form-control mb-2" required>
                                                            <option value="individual">@lang('Individual')</option>
                                                            <option value="investment_firm">@lang('Investment Firm')</option>
                                                            <option value="family_office">@lang('Family Office')</option>
                                                            <option value="institutional">@lang('Institutional Fund Manager')</option>
                                                            <option value="charity">@lang('Charitable Organization')</option>
                                                            <option value="endowment">@lang('Endowment')</option>
                                                            <option value="digital_agency">@lang('Digital Marketing Agency')</option>
                                                            <option value="service_provider">@lang('Service Provider')</option>
                                                            <option value="pension_fund">@lang('Pension Fund')</option>
                                                            <option value="insurance_fund">@lang('Insurance Fund')</option>
                                                            <option value="sovereign_wealth">@lang('Sovereign Wealth Fund (SWF)')</option>
                                                            <option value="investment_authority">@lang('Investment Authority')</option>
                                                            <option value="foundation">@lang('Foundation/Charitable')</option>
                                                            <option value="non_profit">@lang('Non-Profit')</option>
                                                            <option value="private_equity">@lang('Private Equity Fund')</option>
                                                            <option value="venture_capital">@lang('Venture Capital')</option>
                                                            <option value="hedge_fund">@lang('Hedge Fund')</option>
                                                            <option value="real_estate">@lang('Real Estate Fund')</option>
                                                            <option value="reit">@lang('REIT')</option>
                                                            <option value="infrastructure">@lang('Infrastructure Fund')</option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon13"><i class="fa fa-globe-americas"></i></span>
                                                    </div>
                                                    @error('investor_type')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-2">
                                                    <p>@lang('Accredited / Qualified Investor Status')</p>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="investor_accredited" id="investor_yes" value="yes" {{ old('investor_accredited') == 'yes' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="investor_yes">@lang('Yes')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="investor_accredited" id="investor_no" value="no" {{ old('investor_accredited') == 'no' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="investor_no">@lang('No')</label>
                                                    </div>
                                                    @error('investor_accredited')
                                                        <span class="text-danger mt-1">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <p>@lang('Proof of Status (if Yes)')</p>
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="investor_proof_status" accept=".jpg,.jpeg,.png,.pdf" class="form-control mb-2">
                                                        <span class="input-group-text" id="basic-addon14"> <i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_proof_status')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <p>@lang('Investment Horizon')</p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_horizon" class="form-control mb-2">
                                                            <option value="">@lang('Select')</option>
                                                            <option value="short">@lang('Short')</option>
                                                            <option value="medium">@lang('Medium')</option>
                                                            <option value="long">@lang('Long')</option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon14"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    @error('investor_horizon')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <p>@lang('Risk Appetite')</p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_risk" class="form-control mb-2">
                                                            <option value="">@lang('Select')</option>
                                                            <option value="low">@lang('Low')</option>
                                                            <option value="moderate">@lang('Moderate')</option>
                                                            <option value="high">@lang('High')</option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon15"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    @error('investor_risk')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>


                                                <div>
                                                    <p>@lang('Ticket Size Preference')</p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_risk" class="form-control mb-2">
                                                            <option value="">@lang('Select')</option>
                                                            <option value="low">@lang('Low')</option>
                                                            <option value="moderate">@lang('Moderate')</option>
                                                            <option value="high">@lang('High')</option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon16"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    @error('investor_risk')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <p>@lang('Typical Ticket Size')</p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_ticket" class="form-control mb-2">
                                                            <option value="">@lang('Select')</option>
                                                            <option value="10k">@lang('<$10k')</option>
                                                            <option value="10-50k">@lang('$10–50k')</option>
                                                            <option value="50-250k">@lang('$50–250k')</option>
                                                            <option value="250k+">@lang('$250k+')</option>
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon17"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    @error('investor_ticket')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>


                                                <div>
                                                    <p>@lang('Sectors of Interest')</p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_sectors[]" class="form-control mb-2" multiple>
                                                            @php
                                                                $sectors = ['Real Estate', 'REITs', 'Infrastructure', 'Fintech', 'Sukuk (Mudarabah)', 'Other'];
                                                            @endphp
                                                            @foreach($sectors as $sector)
                                                                <option value="{{ $sector }}" {{ is_array(old('investor_sectors')) && in_array($sector, old('investor_sectors')) ? 'selected' : '' }}>{{ $sector }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon18"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    @error('investor_sectors[]')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                   <p>@lang('Geographies of Interest')</p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_geographies[]" class="form-control mb-2" multiple>
                                                            @foreach(config('country') as $value)
                                                                <option value="{{ $value['code'] }}" {{ is_array(old('investor_geographies')) && in_array($value['code'], old('investor_geographies')) ? 'selected' : '' }}>
                                                                    {{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon19"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    @error('investor_geographies[]')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>




                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary btn-prev" data-prev="#collapseProfile" >@lang('Previous')</button>
                                                    <button type="button" class="btn btn-primary btn-next" data-next="#collapseCompliance" style="background-color:#ff5400;border:1px solid #ff5400 ">@lang('Next')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ===== A.3 Compliance ===== --}}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingCompliance">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCompliance" style="color:#6777ef">
                                                @lang('A.3 Compliance')
                                            </button>
                                        </h2>
                                        <div id="collapseCompliance" class="accordion-collapse collapse" aria-labelledby="headingCompliance" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">

                                                <div class="mb-2">
                                                    <p>@lang('PEP Exposure')</p>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="investor_pep" value="yes" class="form-check-input" {{ old('investor_pep') == 'yes' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="investor_yes">@lang('Yes')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="investor_pep" value="no" class="form-check-input" {{ old('investor_pep') == 'no' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="investor_no">@lang('No')</label>
                                                    </div>
                                                    @error('investor_pep')
                                                        <span class="text-danger mt-1">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div class="input-group mb-3">
                                                   <textarea name="investor_pep_details" class="form-control mb-2" placeholder="@lang('If Yes, explain details')">{{ old('investor_pep_details') }}</textarea>
                                                    <span class="input-group-text" id="basic-addon20"><i
                                                            class="fa-regular fa-pen-to-square"></i></span>
                                                </div>
                                                @error('investor_pep_details')
                                                    <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                @enderror


                                                <div>
                                                    <p>@lang('Source of Funds')</p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_source_of_funds[]" class="form-control mb-2" multiple required>
                                                                @php
                                                                    $sources = ['Income', 'Savings', 'Asset Sale', 'Corporate Profits', 'Investment/Portfolio Management Funds', 'Other'];
                                                                @endphp
                                                                @foreach($sources as $source)
                                                                    <option value="{{ $source }}" {{ is_array(old('investor_source_of_funds')) && in_array($source, old('investor_source_of_funds')) ? 'selected' : '' }}>{{ $source }}</option>
                                                                @endforeach
                                                            </select>
                                                        <span class="input-group-text" id="basic-addon21"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    @error('investor_source_of_funds[]')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>


                                                <div>
                                                    <p>@lang('Proof of Address')</p>
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="investor_proof_address" accept=".jpg,.jpeg,.png,.pdf" class="form-control mb-2" required>
                                                        <span class="input-group-text" id="basic-addon22"><i
                                                                class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_proof_address')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                 <div>
                                                    <p>@lang('Tax ID / TIN')</p>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="investor_tax_id" class="form-control mb-2" value="{{ old('investor_tax_id') }}">
                                                        <span class="input-group-text" id="basic-addon23"><i
                                                                class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_tax_id')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>





                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary btn-prev" data-prev="#collapseCategory">@lang('Previous')</button>
                                                    <button type="button" class="btn btn-primary btn-next" data-next="#collapseEntity" style="background-color:#ff5400;border:1px solid #ff5400 ">@lang('Next')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ===== A.4 Entity Add-On (shown if not Individual) ===== --}}
                                    <div class="accordion-item" id="collapseEntityWrapper">
                                        <h2 class="accordion-header" id="headingEntity">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEntity" style="color:#6777ef">
                                                @lang('A.4 Entity Add-On')
                                            </button>
                                        </h2>
                                        <div id="collapseEntity" class="accordion-collapse collapse" aria-labelledby="headingEntity" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">

                                                <div>
                                                    <p>@lang('Legal Entity Name')</p>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="investor_entity_name" class="form-control mb-2" value="{{ old('investor_entity_name') }}">
                                                        <span class="input-group-text" id="basic-addon24"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_entity_name')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                   <p>@lang('Registration Country')</p>
                                                    <div class="input-group mb-3">
                                                        <select name="investor_entity_country" class="form-control mb-2">
                                                            @foreach(config('country') as $value)
                                                                <option value="{{ $value['code'] }}" {{ old('investor_entity_country') == $value['code'] ? 'selected' : '' }}>{{ $value['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-text" id="basic-addon25"><i class="fa fa-globe-americas"></i></span>

                                                    </div>
                                                    @error('investor_entity_country')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>



                                                <div>
                                                    <p>@lang('Registration Number')</p>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="investor_entity_number" class="form-control mb-2" value="{{ old('investor_entity_number') }}">
                                                        <span class="input-group-text" id="basic-addon26"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_entity_number')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <p>@lang('Incorporation Certificate')</p>
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="investor_entity_cert" class="form-control mb-2">
                                                        <span class="input-group-text" id="basic-addon27"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_entity_cert')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>




                                                <p>@lang('Directors / UBOs')</p>
                                                <div id="investor_ubos" class="mb-2">
                                                    <input type="text" name="investor_ubo_name[]" placeholder="@lang('Full Name')" class="form-control mb-1">
                                                    <input type="date" name="investor_ubo_dob[]" class="form-control mb-1">
                                                    <input type="text" name="investor_ubo_nationality[]" placeholder="@lang('Nationality')" class="form-control mb-1">
                                                    <input type="number" name="investor_ubo_ownership[]" placeholder="@lang('Ownership %')" class="form-control mb-1">
                                                    <input type="file" name="investor_ubo_id[]" class="form-control mb-1">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary mb-2" id="add-investor-ubo">@lang('Add Another UBO')</button>

                                                <div>
                                                     <p>@lang('Authorised Signatory Letter')</p>
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="investor_signatory_letter" class="form-control mb-2">
                                                        <span class="input-group-text" id="basic-addon29"><i class="fa-regular fa-pen-to-square"></i></span>
                                                    </div>
                                                    @error('investor_entity_cert')
                                                        <span class="text-danger mt-1 mb-2">@lang($message)</span>
                                                    @enderror
                                                </div>



                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary btn-prev" data-prev="#collapseCompliance">@lang('Previous')</button>
                                                    <button type="button" class="btn btn-primary btn-next" data-next="#collapsePreferences" style="background-color:#ff5400;border:1px solid #ff5400 ">@lang('Next')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ===== A.5 Preferences ===== --}}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingPreferences">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePreferences" style="color:#6777ef">
                                                @lang('A.5 Preferences')
                                            </button>
                                        </h2>
                                        <div id="collapsePreferences" class="accordion-collapse collapse" aria-labelledby="headingPreferences" data-bs-parent="#investorAccordion">
                                            <div class="accordion-body">
                                                <p>@lang('Communication Channels')</p>
                                                <div class="form-check">
                                                    <input type="checkbox" name="investor_comm_email" class="form-check-input"> @lang('Email')
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="investor_comm_sms" class="form-check-input"> @lang('SMS')
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="investor_comm_whatsapp" class="form-check-input"> @lang('WhatsApp')
                                                </div>

                                                <p>@lang('Notification Frequency')</p>
                                                <select name="investor_notification_freq" class="form-control mb-2">
                                                    <option value="">@lang('Select')</option>
                                                    <option value="daily">@lang('Daily')</option>
                                                    <option value="weekly">@lang('Weekly')</option>
                                                    <option value="monthly">@lang('Monthly')</option>
                                                </select>

                                                <div class="form-check mb-2">
                                                    <input type="checkbox" name="investor_accept_electronic_sign" class="form-check-input" required> @lang('Accept Electronic Signatures')
                                                </div>

                                                <div class="d-flex justify-content-start">
                                                    <button type="button" class="btn btn-secondary btn-prev" data-prev="#collapseEntity">@lang('Previous')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="mb-3 form-check d-flex justify-content-between">
                                <div class="check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">@lang('I agree to the terms and
                                    conditions.')</label>
                                </div>
                            </div>

                            <button type="submit" class="btn custom_btn mt-30 w-100">@lang('Register')</button>
                            {{-- <a href="{{env('SSO_REGISTER')}}" class="btn custom_btn mt-30 w-100">@lang('Register with kemedar')</a> --}}
                            @includeFirst([$theme.'partials.social'])
                            <div class="pt-5 d-flex">
                                @lang('Already have an account?')
                                <br>
                                <h6 class="ms-2 mt-1"><a href="{{ route('login') }}">@lang('Login')</a></h6>
                            </div>



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
