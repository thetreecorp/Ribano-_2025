@extends($theme.'layouts.app', ['body_class' => 'my-pitches hide-top-section'])
@push('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

@endpush
@section('title',__('My Pitches'))
@inject('common', 'App\Http\Controllers\ProjectController')
@section('content')

<section class="my_pitches_area pd0">

    <div class="container">
        @include($theme.'partials.pitch-menu')

        <div class="search-filter pd0">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
                    <div class="container-fluid">
        
                        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbar-content-search">
                            <div class="hamburger-toggle">
                                <div class="hamburger">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </button>
                        <div class="collapse navbar-collapse" id="navbar-content-search">
                            <form id="seach-investor-form" class="d-flex search-form" method="post" action="">
                                <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                                    <li class="nav-item dropdown dropdown-mega position-static">
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside">{{translate("Investment Range")}}</a>
                                        <div class="dropdown-menu shadow">
                                            <div class="mega-content px-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <p>
                                                            <label for="amount">{{translate('Show price between')}}:</label>
                                                            <input type="text" id="amount-text-input" readonly style="">
                                                        </p>
        
                                                        <div id="slider-range"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown dropdown-mega position-static">
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside">{{translate("Country")}}</a>
                                        <div class="dropdown-menu shadow">
                                            <div class="mega-content px-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="countries-top">
                                                            <a class="clear-countries-option" href="javascript:void(0)">
                                                                {{translate('Clear')}}</a>
        
                                                        </div>
                                                        <div class="countries-wrap scroll-div row">
                                                            <div class="form-row">
                                                                <input class="form-check-input" id="check_all_countries"
                                                                    type="checkbox" value="-1">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    {{translate('All')}}
                                                                </label>
                                                            </div>
                                                            @foreach(config('country') as $value)
        
                                                            <div class="form-row col-lg-4 col-md-4 col-sm-4">
                                                                <input name="countries[]" class="form-check-input"
                                                                    type="checkbox" value="{{$value['code']}}">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    {{$value['name']}}
                                                                </label>
                                                            </div>
        
                                                            @endforeach
                                                        </div>
        
        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown dropdown-mega position-static">
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside">{{translate("Location")}}</a>
                                        <div class="dropdown-menu shadow">
                                            <div class="mega-content px-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="location-top">
                                                            <a class="clear-location-option" href="javascript:void(0)">
                                                                {{translate('Clear')}}</a>
        
                                                        </div>
                                                        <div class="location-wrap scroll-div row">
                                                            <div class="form-row">
                                                                <input class="form-check-input" id="check_all_location"
                                                                    type="checkbox" value="-1">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    {{translate('All')}}
                                                                </label>
                                                            </div>
        
                                                            @foreach($common->getLocationsOption() as $value)
        
                                                            <div class="form-row col-lg-4 col-md-4 col-sm-4">
                                                                <input name="locations[]" class="form-check-input"
                                                                    type="checkbox" value="{{$value}}">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    {{$value}}
                                                                </label>
                                                            </div>
        
                                                            @endforeach
                                                        </div>
        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown dropdown-mega position-static">
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside">{{translate("Industry")}}</a>
                                        <div class="dropdown-menu shadow">
                                            <div class="mega-content px-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="location-top">
                                                            <a class="clear-industries-option" href="javascript:void(0)">
                                                                {{translate('Clear')}}</a>
        
                                                        </div>
        
                                                        <div class="industries-wrap scroll-div row">
                                                            <div class="form-row">
                                                                <input class="form-check-input" id="check_all_industries"
                                                                    type="checkbox" value="-1">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    {{translate('All')}}
                                                                </label>
                                                            </div>
                                                            @foreach($common->getIndustries() as $value)
        
                                                            <div class="form-row col-lg-4 col-md-4 col-sm-4">
                                                                <input name="industries[]" class="form-check-input"
                                                                    type="checkbox" value="{{$value->id}}">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    {{$value->name}}
                                                                </label>
                                                            </div>
        
                                                            @endforeach
                                                        </div>
        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                   
                                    <li class="nav-item dropdown dropdown-mega">
                                        <a class="nav-link clear_filter clear-all-cb"
                                            href="javascript:void(0)">{{translate('Clear filters')}}</a>
                                    </li>
                                </ul>
                                <input type="hidden" name="min-price" value="" id="min-price">
                                <input type="hidden" name="max-price" value="" id="max-price">
        
                                <div class="input-group">
                                    <input class="form-control border-0 mr-2" name="keyword" type="search" placeholder="Search"
                                        aria-label="Search">
                                    <button class="btn btn-primary border-0" type="submit">{{translate("Search")}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </nav>
                <div class="loading loading-spin"></div>
            </div>
        </div>
        
        <div class="content-investor-page grid" id="investor-wrap">
            @if (count($users))
                @foreach ($users as $user)
                    @include('fundraising.investor_box')
                @endforeach
                @else
                    <div class="w-full md:max-w-md mx-auto rounded-md flex flex-col py-6 px-4">
                        <p class="no-result">{{translate('No investor found')}}</p>
                    </div>
            @endif
            
        </div>
        <div id="pagination-wrap">
            @if ($total > 12)
            <nav class="theme-pagination"></nav>
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
        $( function() {
           
        });
        resetSlider({{$min}}, {{$max}});
        function resetSlider(min, max) {
            $( "#slider-range" ).slider({
                range: true,
                min: min,
                max: max,
                values: [ min, max ],
                slide: function( event, ui ) {
                $( "#amount-text-input" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                $( "#min-price" ).val(ui.values[ 0 ]);
                $( "#max-price" ).val(ui.values[ 1 ] );
                
            }
            });
            $( "#amount-text-input" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
            " - $" + $( "#slider-range" ).slider( "values", 1 ) );
        }
        
        function checkAll(id) {
            $(id).click(function() {
                var checked = $(this).prop('checked');
                $(this).closest('.mega-content').find('input:checkbox').prop('checked', checked);
            });
        }
        
        $('.clear-countries-option, .clear-location-option, .clear-industries-option, .clear-stages-option, .clear-funding-option').click(function() {
            var checked = $(this).prop('checked');
            $(this).closest('.mega-content').find('input:checkbox').prop('checked', false);
        });
        
        $('.clear-all-cb').click(function() {
            $('#seach-investor-form').find('input:checkbox').prop('checked', false);
            resetSlider({{$min}}, {{$max}});
            $( "#min-price" ).val('');
            $( "#max-price" ).val('');
        });
        
        checkAll('#check_all_countries, #check_all_location, #check_all_industries, #check_all_stages, #check_all_funding');

        $( "#seach-investor-form" ).submit(function( event ) {
            event.preventDefault();
            var fields = $('#seach-investor-form').serializeArray();
            ajaxCall(1, true);
            console.log(fields);
        });
        
        // ajax run here
        function ajaxCall($page = 1, $updatePagination = true) {
			$.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '{{route("investorSearch")}}',
		        data: $('#seach-investor-form').serialize()  + "&page=" + $page,
				beforeSend: function(){
					$('.loading-spin').html('<div class="loader">Loading...</div>');
			    },
			    complete: function(){
					$('.loading-spin').html('');
			    },
		        success: function(data) {

		            $('#investor-wrap').html(data.view);
		            $('.from-result').text(data.fromText);
		            $('.to-result').text(data.toText);
		            $('.total-result').text(data.total);
		            if($updatePagination) {
		                if(data.total > 12) {
			                // append pagenation
			                $('.theme-pagination').remove();
			                $('#pagination-wrap').append('<nav class="theme-pagination"></nav>');
							pagination(data.total);
			            }
			            else {
			                $('#pagination-wrap').html('');
			            }
		            }


		        }
		    });
		}
	    function pagination($total, $updatePagination = true){
	        $('.theme-pagination').pagination({
	            items: $total,
	            itemsOnPage: 12,
	            listStyle: 'pagination',
	            cssStyle: 'light-theme',

	            onPageClick: function(pageNumber) {
					$('html, body').animate({scrollTop: $('#navbar-content-search').offset().top - 200}, 500);
	                ajaxCall(pageNumber, false);
	                paged = localStorage.getItem('paged');
	                localStorage.setItem('paged', parseInt(paged) + 1);


	            }
	        });
	    }
        pagination({{$total}}, true);
        
</script>
@endpush