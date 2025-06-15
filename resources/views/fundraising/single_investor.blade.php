@extends($theme.'layouts.app', ['body_class' => 'my-pitches hide-top-section'])
@section('title',__('My Pitches'))
@inject('common', 'App\Http\Controllers\ProjectController')
@section('content')

    <section class="project-banner pd0 bg-brand-dark">
        <div class="container">
            <div class="top-detail investor-top">
                @if ($user->image)
                    <img src="{{getFile(config('location.user.path').$user->image)}}" alt="@lang('preview user image')" />
                @else
                    <img alt="investor" src="https://placehold.jp/86x86.png">
                @endif
                
                <div class="p-short-detail">
                    <p><strong>{{$user->firstname . ' ' . $user->lastname}}</strong></p>
                    <p><i class="fas fa-map-marker-alt"></i> {{$user->address ? $user->address : 'N/A'}}</p>
                    
                </div>
            </div>
        </div>
        
    </section>
    <section class="fixed-menu pd0" id="fixed-scroll-menu">
    </section>
    <section class="menu-section pd0 pdbt20">
        <div class="tab-menu-top">
            <div class="container">
                <div class="tabs-menu" id="fixed-navbar">
                    <?php 
                        $arrayTab = [translate("Background"), translate("Expertise"), translate("Criteria"), translate("My Companies")]; 
                        $arrayId = ["d-about", "d-my_area", "d-criteria", "d-my_company"]; 
                    ?>
                        @foreach ($arrayTab as $key => $val )
                       <a class="tab-link {{ $key == 0 ? 'active' : ''}} " href="#{{$arrayId[$key]}}">{{$val}}</a>
                    @endforeach
                </div>
            </div>
    
        </div>
    </section>
    
    <section class="project-content pdt10">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-9 mb-5">
                    @if($user->about)
                        <div class="section-scroll" id="d-about">
                            <h4>{{translate("About Me")}}</h4>
                            {{$user->about}}
                        </div>
                    @endif
                    
                    @if($user->my_area)
                        <div class="section-scroll" id="d-my_area">
                            <h4>{{translate("My Areas of Expertise")}}</h4>
                            {{$user->my_area}}
                        </div>
                    @endif
                    
                    <div class="section-scroll" id="d-criteria">
                        <h4>{{translate("Criteria")}}</h4>
                        <div class="criteria-info">
                            <div class="flex-row flex">
                                <div class="width25 pr-4">
                                    <span>{{translate("Investment Range")}}</span>
                                </div>
                                <div class="width75">
                                    <span>${{$user->minimum_investment}}</span>
                                    <span>{{translate("to")}}</span>
                                    <span>${{$user->maximum_investment}}</span>
                                </div>
                            </div>
                            <div class="flex-row flex">
                                <div class="width25 pr-4">
                                    <span>{{translate("Stages")}}</span>
                                </div>
                                <div class="width75">
                                    {{-- @foreach ($common->returnStages($user->project_stage) as $Val)
                                        {{$Val}}
                                    @endforeach --}}
                                    {{implode(', ', $common->returnStages($user->project_stage))}}
                                </div>
                            </div>
                            <div class="flex-row flex">
                                <div class="width25 pr-4">
                                    <span>{{translate("Industries")}}</span>
                                </div>
                                <div class="width75">
                                    {{implode(', ', $common->returnIndustryCategory($user->industry_category))}}
                                </div>
                            </div>
                            <div class="flex-row flex">
                                <div class="width25 pr-4">
                                    <span>{{translate("Location")}}</span>
                                </div>
                                <div class="width75">
                                    {{implode(', ', $common->returnLocation($user->location))}}
                                </div>
                            </div>
                            <div class="flex-row flex">
                                <div class="width25 pr-4">
                                    <span>{{translate("Countries")}}</span>
                                </div>
                                <div class="width75">
                                    {{implode(', ', $common->returnLocation($user->countries))}}
                                </div>
                            </div>
                           
                            
                        </div>
                    </div>
                    
                    
                    @if($user->my_company)
                        <div class="section-scroll" id="d-my_company">
                            <h4>{{translate("My Companies" )}}</h4>
                            {{$user->my_company}}
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 col-md-9 mb-5">
                    <h5>{{translate("My Profile")}}</h5>
                    <div class="investment-summary">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>{{translate("Minimum Investment")}}</td>
                                    <td>
                                        <div> <strong>${{$user->minimum_investment}}</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{translate("Maximum Investment")}} </td>
                                    <td>
                    
                                        <div> <strong>${{$user->maximum_investment}}</strong></div>
                                    </td>
                                </tr>
                                <tr>
                    
                                    <td>{{translate("Investor Type")}}</td>
                                    <td>
                                        <div><strong>{{$user->investor_type ?? 'N/A'}}</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{translate("Registration Date")}}</td>
                                    <td><strong>{{date('M d Y', strtotime($user->created_at))}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{translate("Network")}} </td>
                                    <td><strong>{{$user->network ?? 'N/A'}}</strong></td>
                                </tr>
                                
                    
                            </tbody>
                        </table>
                    </div>
                    <?php 
                        $keywords = $user->keywords;
                        if($keywords)
                            $keywords = json_decode($keywords, true);
                        
                        
                       // dd($keywords);
                    ?>
                    <div class="keyword-desc">
                        <h5>{{translate("Keywords")}}</h5>
                        @if ($keywords)
                            <div class="keywords-box">
                                @foreach ( $keywords as $key => $val)
                                    <span>{{$val['value']}}</span>
                                @endforeach
                            </div>
                            
                            
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    "use strict";
        $(document).on('click', 'a[href^="#"]', function(e) {
        // target element id
            var id = $(this).attr('href');
            
            // target element
            var $id = $(id);
            if ($id.length === 0) {
            return;
            }
            
            // prevent standard hash navigation (avoid blinking in IE)
            e.preventDefault();
            
            // top position relative to the document
            var pos = $id.offset().top - parseFloat($id.css('margin-top')) - $('#fixed-navbar').outerHeight();
            
            // animated top scrolling
            $('body, html').animate({scrollTop: pos}, 500);
            
        });

        function scrollToElement(elementId) {
            elementId = elementId.replace("Button", "");
            const elementToMoveTo = $('#' + elementId);
            window.scrollTo({
            top: elementToMoveTo.offset().top - parseFloat(elementToMoveTo.css('margin-top')) - $('#fixed-navbar').outerHeight(),
            behavior: 'smooth'
        });
        }

</script>
@endpush
