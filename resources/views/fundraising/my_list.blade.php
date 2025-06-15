@extends($theme.'layouts.app', ['body_class' => 'my-list hide-top-section'])

@section('title',__('My Portfolio'))
@inject('common', 'App\Http\Controllers\ProjectController')
@section('content')

<section class="my_portfolio_area pd0">

    <div class="container">
        @include($theme.'partials.pitch-menu')
        <?php 
        
            // dd(count($shortlists));
            // dd($interesteds);
            // dd($paymoneys);
        ?>
        <div class="top_portfolio">
            <div
                class="w-full px-4 max-w-screen-lg max-w-screen-md mx-auto flex flex-wrap items-center gap-6 gap-3 py-3 mt-8 mb-4">
                <div class="font-normal rounded-full h-24 w-24">
                    {{-- <span class="text-white inline-flex items-center justify-center rounded-full h-24 w-24 text-center leading-12">
                        AE
                    </span> --}}
                    @if (auth()->user()->image)
                        <img class="rounded-full object-center object-cover h-24 w-24" src="{{getFile(config('location.user.path').auth()->user()->image)}}" alt="@lang('preview user image')" />
                    @else
                        <img class="rounded-full object-center object-cover h-24 w-24" alt="investor" src="https://placehold.jp/86x86.png">
                    @endif
                </div>
                <div class="flex flex-col gap-y-2">
                    <h5 class="text-2xl text-xl font-medium mb-0">
                        {{auth()->user()->firstname}} {{auth()->user()->lastname}}
                    </h5>
                    <p class="text-sm text-gray-700 mb-0">{{translate('Welcome to your investment overview')}}</p>
                    <a href="{{route("user.profile")}}" class="capitalize text-blue-600 hover:text-blue-700 underline text-base">
                       {{translate("Edit My Profile")}}</a>
                </div>
                <div class="flex flex-grow flex-wrap gap-3 justify-between">
                    <div class="text-gray-700 text-base">
                        <span class="text-2xl">
                            {{$total_paymoneys}}
                        </span>
                        <br>
                        {{translate("Invested")}}
                    </div>
                    <div class="text-gray-700 text-base">
                        <span class="text-2xl">
                            {{$total}}
                        </span>
                        <br>
                        {{translate("Interested")}}
                    </div>
                    <div class="text-gray-700 text-base">
                        <span class="text-2xl">
                            {{$total_shortlists}}
                        </span>
                        <br>
                        {{translate("Shortlisted")}}
                    </div>
                    <div class="text-gray-700 text-base">
                        <span class="text-2xl">
            
                        </span>
                        <br>
                        &nbsp;
                    </div>
                </div>
            
            </div>
        </div>
        
        <div class="py-10 md:px-0 px-5 flex justify-center overflow-auto">
            <ul class="flex w-auto items-center text-sm border text-gray-600 border-blue-600 rounded-lg overflow-hidden">
                <li role="tab" class="tab-option cursor-pointer px-6 py-1.5 hover:underline  text-gray-600"
                    id="invested" onclick="toggleTab('invested', 'invested-list')">
                    {{translate("Invested")}} </li>
                <li role="tab" class="tab-option cursor-pointer px-6 py-1.5 text-white hover:underline bg-blue-600"
                    id="interested" onclick="toggleTab('interested', 'interested-list')">
                    {{translate("Interested")}} </li>
                <li role="tab" class="tab-option cursor-pointer px-6 py-1.5 hover:underline text-blue-600 text-gray-600"
                    id="shortlisted" onclick="toggleTab('shortlisted', 'shortlisted-list')">
                    {{translate("Shortlisted")}} </li>
            </ul>
        </div>

        <div role="tabpanel" class="w-full hidden" id="invested-list">
            
            @if($total_paymoneys)
                <div class="column-sm">
                    <div class="row row-box" id="invested-project">
                        @foreach ($paymoneys as $project)
                            <div class="col-md-4 wow fadeInUp col-box">
                                @include('project.project_box')
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div id="pagination-invested">
                    @if ($total_paymoneys > 12)
                    <nav class="theme-pagination-invested"></nav>
                    @endif
                </div>
            @else
                <div class="w-full flex justify-center">
                    <div class="md:max-w-sm flex-grow rounded-md border-2 border-dashed bg-slate-50 py-32 m-3">
                        <div class="px-16 text-center">
                            <p class="text-xl italic font-medium text-slate-300"> {{translate("You haven't shown interest in any proposals
                                yet")}}. <br><br>{{translate("Click the button below to check out our
                                latest pitches")}}</p><img src="{{asset("public/assets/images/")}}/curve-arrow-28X84.png" class="py-3">
                            <div class="flex justify-center"><a href="{{route("searchProject")}}"
                                    class=" bg-blue-400 cursor-pointer rounded-full w-28 h-28 text-white text-7xl flex justify-center items-center ">＋</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
                
           
        </div>
        <div role="tabpanel" class="w-full" id="interested-list">
          
   
            @if($total)
                <div class="column-sm">
                    <div class="row row-box" id="interested-project">
                        @foreach ($interesteds as $project)
                        <div class="col-md-4 wow fadeInUp col-box">
                            @include('project.project_box')
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div id="pagination-interested">
                    @if ($total > 12)
                    <nav class="theme-pagination-interested"></nav>
                    @endif
                </div>
            @else
                <div class="w-full flex justify-center">
                    <div class="md:max-w-sm flex-grow rounded-md border-2 border-dashed bg-slate-50 py-32 m-3">
                        <div class="px-16 text-center">
                            <p class="text-xl italic font-medium text-slate-300"> {{translate("You haven't shown interest in any proposals
                                yet")}}. <br><br>{{translate("Click the button below to check out our
                                latest pitches")}}</p><img src="{{asset("public/assets/images/")}}/curve-arrow-28X84.png" class="py-3">
                            <div class="flex justify-center"><a href="{{route("searchProject")}}"
                                    class=" bg-blue-400 cursor-pointer rounded-full w-28 h-28 text-white text-7xl flex justify-center items-center ">＋</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            
        </div>
        <div role="tabpanel" class="w-full hidden" id="shortlisted-list">
        
        
            @if($total_shortlists)
                <div class="column-sm">
                    <div class="row row-box" id="shortlisted-project">
                        @foreach ($shortlists as $project)
                        <div class="col-md-4 wow fadeInUp col-box">
                            @include('project.project_box')
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div id="pagination-shortlisted">
                    @if ($total_shortlists > 12)
                    <nav class="theme-pagination-shortlisted"></nav>
                    @endif
                </div>
            @else
                <div class="w-full flex justify-center">
                    <div class="md:max-w-sm flex-grow rounded-md border-2 border-dashed bg-slate-50 py-32 m-3">
                        <div class="px-16 text-center">
                            <p class="text-xl italic font-medium text-slate-300">
                                {{translate("You haven't shown interest in any proposals yet")}}. <br><br>{{translate("Click the button below to
                                check out our latest pitches")}}.</p><img src="{{asset("
                                public/assets/images/")}}/curve-arrow-28X84.png" class="py-3">
                            <div class="flex justify-center"><a href="{{route("searchProject")}}"
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
        
        // ajax run here
        function ajaxCall($page = 1, $updatePagination = true) {
			$.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '{{route("loadMylistAjax")}}',
		        data: {
		            'page' : $page,
		            'type': 'interested'
		        },
				beforeSend: function(){
					$('.loading-spin').html('<div class="loader">Loading...</div>');
			    },
			    complete: function(){
					$('.loading-spin').html('');
			    },
		        success: function(data) {

		            $('#interested-project').html(data.view);
		            $('.from-result').text(data.fromText);
		            $('.to-result').text(data.toText);
		            $('.total-result').text(data.total);
		            if($updatePagination) {
		                if(data.total > 12) {
			                // append pagenation
			                $('.theme-pagination-interested').remove();
			                $('#pagination-interested').append('<nav class="theme-pagination-interested"></nav>');
							pagination(data.total);
			            }
			            else {
			                $('#pagination-interested').html('');
			            }
		            }


		        }
		    });
		}
	    function pagination($total, $updatePagination = true){
	        $('.theme-pagination-interested').pagination({
	            items: $total,
	            itemsOnPage: 12,
	            listStyle: 'pagination',
	            cssStyle: 'light-theme',

	            onPageClick: function(pageNumber, event) {

					$('html, body').animate({scrollTop: $('.top_portfolio').offset().top - 200}, 500);
	                ajaxCall(pageNumber, false);
	                paged = localStorage.getItem('paged');
	                localStorage.setItem('paged', parseInt(paged) + 1);


	            }
	        });
	    }
        pagination({{$total}}, true);

        //-------- invested
        function ajaxCallInvested($page = 1, $updatePagination = true) {
			$.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '{{route("loadMylistAjax")}}',
		        data: {
		            'page' : $page,
		            'type': 'invested'
		        },
				beforeSend: function(){
					$('.loading-spin').html('<div class="loader">Loading...</div>');
			    },
			    complete: function(){
					$('.loading-spin').html('');
			    },
		        success: function(data) {

		            $('#invested-project').html(data.view);
		            $('.from-result').text(data.fromText);
		            $('.to-result').text(data.toText);
		            $('.total-result').text(data.total);
		            if($updatePagination) {
		                if(data.total > 12) {
			                // append pagenation
			                $('.theme-pagination-invested').remove();
			                $('#pagination-invested').append('<nav class="theme-pagination-invested"></nav>');
							pagination(data.total);
			            }
			            else {
			                $('#pagination-invested').html('');
			            }
		            }


		        }
		    });
		}
	    function paginationInvested($total, $updatePagination = true){
	        $('.theme-pagination-invested').pagination({
	            items: $total,
	            itemsOnPage: 12,
	            listStyle: 'pagination',
	            cssStyle: 'light-theme',

	            onPageClick: function(pageNumber, event) {

					$('html, body').animate({scrollTop: $('.top_portfolio').offset().top - 200}, 500);
	                ajaxCallInvested(pageNumber, false);
	                paged = localStorage.getItem('paged2');
	                localStorage.setItem('paged2', parseInt(paged) + 1);


	            }
	        });
	    }
        paginationInvested({{$total_paymoneys}}, true);
        
        //----- shortlisted
        function ajaxCallShortlisted($page = 1, $updatePagination = true) {
			$.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '{{route("loadMylistAjax")}}',
		        data: {
		            'page' : $page,
		            'type': 'interested'
		        },
				beforeSend: function(){
					$('.loading-spin').html('<div class="loader">Loading...</div>');
			    },
			    complete: function(){
					$('.loading-spin').html('');
			    },
		        success: function(data) {

		            $('#shortlisted-project').html(data.view);
		            $('.from-result').text(data.fromText);
		            $('.to-result').text(data.toText);
		            $('.total-result').text(data.total);
		            if($updatePagination) {
		                if(data.total > 12) {
			                // append pagenation
			                $('.theme-pagination-shortlisted').remove();
			                $('#pagination-shortlisted').append('<nav class="theme-pagination-shortlisted"></nav>');
							pagination(data.total);
			            }
			            else {
			                $('#pagination-shortlisted').html('');
			            }
		            }


		        }
		    });
		}
	    function paginationShortlisted($total, $updatePagination = true){
	        $('.theme-pagination-shortlisted').pagination({
	            items: $total,
	            itemsOnPage: 12,
	            listStyle: 'pagination',
	            cssStyle: 'light-theme',

	            onPageClick: function(pageNumber, event) {

					$('html, body').animate({scrollTop: $('.top_portfolio').offset().top - 200}, 500);
	                ajaxCallShortlisted(pageNumber, false);
	                paged = localStorage.getItem('paged3');
	                localStorage.setItem('paged3', parseInt(paged) + 1);


	            }
	        });
	    }
        paginationShortlisted({{$total_shortlists}}, true);
        
</script>
@endpush