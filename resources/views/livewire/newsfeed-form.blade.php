@inject('common', 'App\Http\Controllers\ProjectController')
<section class="project_submit_area">
    <div class="container">
        <div class="row">  
            @if(!empty($successMessage))
                <div class="alert alert-success">
                   {{ $successMessage }}
                </div>
            @endif

  
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="title">{{translate('Pitch Title')}}:</label>
                                    <textarea type="text" wire:model="description" class="form-control" id="description"></textarea>
                                    
                                </div>
                               
                                <div class="col-sm-6">
                                    <label for="webiste">{{translate('Website (Optional)')}}:</label>
                                    <input type="text" wire:model="website" class="form-control" placeholder="https//" />

                                   
                                    
                                    
                                </div>
                                
                            </div>
                            
                            
                            @php
                                $country_code = (string) @getIpInfo()['code'] ?: null;
                                $myCollection = collect(config('country'))->map(function($row) {
                                    return collect($row);
                                });
                                $countries = $myCollection->sortBy('code');
                            @endphp
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">{{translate('Where is the management located?')}}:</label>
                                    <select class="form-control" wire:model="located" id="form_management_locations">
                                        @foreach($common->getLocationsOption() as $value)       
                                            <option value="{{$value}}">{{$value}}</option>  
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">{{translate('Country')}}:</label>
                                    <select wire:model="country" name="country" class="form-control">
                                        @foreach(config('country') as $value)
                                            <option value="{{$value['name']}}"
                                                    data-name="{{$value['name']}}"
                                                    data-code="{{$value['code']}}"
                                                {{$country_code == $value['code'] ? 'selected' : ''}}
                                            > {{$value['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="">{{translate('Mobile Number')}}:</label>
                                <div class="input-group mb-3">
                                
                                    <select wire:model="phone_code" name="phone_code" class="form-control country_code dialCode-change register_phone_select">
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
    
                                    <input wire:model="mobile_number" type="text" name="mobile_number" class="form-control dialcode-set" value="" placeholder="@lang('Phone Number')">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone"></i></span>
                                    @error('mobile_number')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                    @enderror
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="webiste">{{translate('Industry 1')}}:</label>
                                    <select class="select form-control" wire:model="industry_1" name="industry_1">
                                        <option value="">Please Select</option>
                                        @foreach($common->getIndustries() as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>            
                                            
                                            
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <label for="webiste">{{translate('Industry 2')}}:</label>
                                    <select class="select form-control" wire:model="industry_2" name="industry_2">
                                        <option value="">Please Select</option>
                                        @foreach($common->getIndustries() as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>            
                                            
                                            
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="webiste">{{translate('Stage')}}:</label>
                                    <select class="select form-control"  wire:model="stage" name="stage">
                                        @foreach($common->getStages() as $value)
                                            <option value="{{$value->id}}">{{htmlspecialchars_decode($value->name)}}</option>            
                                        @endforeach
                                       
                                    </select>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <label for="webiste">{{translate('Ideal Investor Role')}}:</label>
                                    <select class="select form-control"  wire:model="ideal_investor_role" name="ideal_investor_role">
                                       
                                        @foreach($common->getInvestorRole() as $value)
                                            <option value="{{$value}}">{{$value}}</option>            
                                        @endforeach
    
                                    </select>
                                    
                                </div>
    
                            </div>
                            
                            
              
                            <button class="btn btn-primary nextBtn btn-lg pull-right mrt-10" wire:click="submitForm" type="button" >{{translate("Post")}}</button>
                        </div>
                    </div>
                </div>
                
                
                
                
        </div>
    </div>
    
</section>
@push('script')
{{-- <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script> --}}
<script src="{{asset('public/assets/js/bootstrap-tagsinput.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        "use strict";
        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                $('.dialcode-set').attr('value', $(this).val());
            });
            function setDialCode() {
                let currency = $('.dialCode-change').val();
                console.log(currency);
                $('.dialcode-set').attr('value', currency);
            }

           
        });

        
       
    </script>
@endpush