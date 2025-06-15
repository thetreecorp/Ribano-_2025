@extends($theme.'layouts.app', ['body_class' => 'my-investor hide-top-section'])
@section('title',__('My investor'))

@section('content')

<!-- login_signup_area_start -->
<section class="my_pitches_area my_portfolio_area pd0">

    <div class="container">
        @include($theme.'partials.pitch-menu')
        
   
   
    
        <div class="py-10 md:px-0 px-5 flex justify-center overflow-auto">
            <ul class="flex w-auto items-center text-sm border text-gray-600 border-blue-600 rounded-lg overflow-hidden">
                <li role="tab" class="tab-option cursor-pointer px-6 py-1.5 hover:underline  text-gray-600" id="invested"
                    onclick="toggleTab('invested', 'invested-list')">
                    {{translate("Invested")}} </li>
                <li role="tab" class="tab-option cursor-pointer px-6 py-1.5 text-white hover:underline bg-blue-600"
                    id="interested" onclick="toggleTab('interested', 'interested-list')">
                    {{translate("Shortlist")}} </li>
                <li role="tab" class="tab-option cursor-pointer px-6 py-1.5 hover:underline text-blue-600 text-gray-600"
                    id="shortlisted" onclick="toggleTab('shortlisted', 'shortlisted-list')">
                    {{translate("Nudged")}} </li>
            </ul>
        </div>
        
        <div role="tabpanel" class="w-full hidden" id="invested-list">
            @if($total_userlists)
                <div class="content-investor-page grid" id="investor-wrap">
                    @foreach ($userlists as $user)
                        @include('fundraising.investor_box')
                    @endforeach
                
                </div>
                {{-- <div id="pagination-wrap">
                    @if ($total_userlists > 12)
                    <nav class="theme-pagination"></nav>
                    @endif
                </div> --}}
            @else
           <div class="w-full flex justify-center">
                <div class="md:max-w-sm flex-grow rounded-md border-2 border-dashed bg-slate-50 py-32 m-3">
                    <div class="px-16 text-center">
                        <p class="text-xl italic font-medium text-slate-300"> {{translate("You don't have any investors interested yet.", null, false)}}. <br><br>{{translate("Make sure your pitch is well filled in.")}}
                        <br><br>{{translate("Then search the investors and get nudging!")}}</p><img src="{{asset("public/assets/images/")}}/curve-arrow-28X84.png" class="py-3">
                        <div class="flex justify-center"><a href="{{route("investorSearch")}}"
                                class=" bg-blue-400 cursor-pointer rounded-full w-28 h-28 text-white text-7xl flex justify-center items-center ">＋</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        
        </div>
        <div role="tabpanel" class="w-full" id="interested-list">
        
        
            @if($total_interesteds)
                <div class="content-investor-page grid" id="investor-wrap">
                    @foreach ($interesteds as $user)
                        @include('fundraising.investor_box')
                    @endforeach
                
                </div>
                {{-- <div id="pagination-wrap">
                    @if ($total_interesteds > 12)
                    <nav class="theme-pagination"></nav>
                    @endif
                </div> --}}
            @else
            <div class="w-full flex justify-center">
                <div class="md:max-w-sm flex-grow rounded-md border-2 border-dashed bg-slate-50 py-32 m-3">
                    <div class="px-16 text-center">
                        <p class="text-xl italic font-medium text-slate-300"> {{translate("You don't have any investors interested yet.", null, false)}}. <br><br>{{translate("Make sure your pitch is well filled in.")}}
                        <br><br>{{translate("Then search the investors and get nudging!")}}</p><img src="{{asset("public/assets/images/")}}/curve-arrow-28X84.png"
                            class="py-3">
                        <div class="flex justify-center"><a href="{{route("investorSearch")}}"
                                class=" bg-blue-400 cursor-pointer rounded-full w-28 h-28 text-white text-7xl flex justify-center items-center ">＋</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        
        
        </div>
        <div role="tabpanel" class="w-full hidden" id="shortlisted-list">
        
            @if($total)
                <div class="content-investor-page grid" id="investor-wrap">
                    @foreach ($shortlists as $user)
                        @include('fundraising.investor_box')
                    @endforeach
                
                </div>
                {{-- <div id="pagination-wrap">
                    @if ($total > 12)
                    <nav class="theme-pagination"></nav>
                    @endif
                </div> --}}
            @else
            <div class="w-full flex justify-center">
                <div class="md:max-w-sm flex-grow rounded-md border-2 border-dashed bg-slate-50 py-32 m-3">
                    <div class="px-16 text-center">
                        <p class="text-xl italic font-medium text-slate-300">
                            {{translate("You haven't shown interest in any proposals yet", null, false)}}. <br><br>{{translate("Click the button
                            below to
                            check out our latest pitches")}}.</p><img src="{{asset("public/assets/images/")}}/curve-arrow-28X84.png" class="py-3">
                        <div class="flex justify-center"><a href="{{route("investorSearch")}}"
                                class=" bg-blue-400 cursor-pointer rounded-full w-28 h-28 text-white text-7xl flex justify-center items-center ">＋</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        
        </div>
        
        
        
        
    </div>
    
    
    </section>
    @endsection
    
    @push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{asset('public/assets/js/simplePagination.js')}}"></script>
    <script>
        
            
           
            
    </script>
    @endpush