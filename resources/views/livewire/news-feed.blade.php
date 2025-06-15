@inject('common', 'App\Http\Controllers\ProjectController')
<section class="project_submit_area pd0">
    <div class="container">
        <div class="row-news-feed">
            @if(!empty($successMessage))
            <div class="alert alert-success">
                {{ $successMessage }}
            </div>
            @endif

            <div class="row">
                <div class="col-sm-12 column-item">
                    <div class="form-group">
                        <label for="title"><span wire:ignore id="textCount" style="color:blue">150 </span> {{translate('characters remaining')}}:</label>
                        <textarea type="text" onkeyup="charCount(this);" wire:model="description" class="form-control" id="description"></textarea>
                    </div>
                </div>    
                
                @php
                    //dd($user_id);
                    $country_code = (string) @getIpInfo()['code'] ?: null;
                    $myCollection = collect(config('country'))->map(function($row) {
                    return collect($row);
                    });
                    $countries = $myCollection->sortBy('code');
                @endphp
               
                <div class="col-sm-12 column-item">
                   
                    <select class="form-control" id="form_management_locations">
                        @foreach($common->getLocationsOption() as $value)
                        <option value="{{$value}}">{{$value}}</option>
                        @endforeach
        
                    </select>
                </div>
                <div class="col-sm-12 column-item">
                    
                    <div class="form-group">
                        <div class="input-group pu-link-js">
                            <span class="input-group-addon">http://</span>
                                            <input type=" text" class="form-control pu-url-js placeholder-js" data-placeholder="URL"
                                placeholder="URL" name="pu_url">
                        </div>
                    </div>
                </div>
               
                <div class="col-sm-12 column-item">
                    <div class="form-group">
                        
                        <input class="form-control" type="file" id="formFile">
                    </div>
                </div>
                <div class="col-sm-12 column-item text-right">
                    <button class="btn btn-primary nextBtn btn-lg float-end mrt-10" wire:click="submitForm"
                        type="button">{{translate("Post")}}</button>
                    
                </div>
                
                
                
                
            </div>
            
            




        </div>
    </div>

</section>
@push('script')
{{-- <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script> --}}
<script src="{{asset('public/assets/js/bootstrap-tagsinput.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
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

        function charCount(textarea1) {
            var max1 = 150;
            var length1 = textarea1.value.length;
            if(length1 >= max1)
            {
                textarea1.value = textarea1.value.substring(0, 150);
            }
            else{
                $('#textCount').text(max1 - length1); 
            
            }
        
        }
        
       
</script>
@endpush