@extends($theme.'layouts.app', ['body_class' => 'search-project'])
@push('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
@endpush
@section('title', translate($title))
@inject('common', 'App\Http\Controllers\ProjectController')
@section('content')
    <section class="search-filter pd0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
                <div class="container-fluid">
                 
                  <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content">
                    <div class="hamburger-toggle">
                      <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                      </div>
                    </div>
                  </button>
                  <div class="collapse navbar-collapse" id="navbar-content">
                    <form class="d-flex" method="post" action="">
                        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown dropdown-mega position-static">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Investment Range</a>
                                <div class="dropdown-menu shadow">
                                    <div class="mega-content px-4">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <p>
                                                    <label for="amount">Price range:</label>
                                                    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                                  </p>
                                                   
                                                  <div id="slider-range"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-mega position-static">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Country</a>
                                <div class="dropdown-menu shadow">
                                    <div class="mega-content px-4">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="countries-top">
                                                    <a class="clear-countries-option" href="javascript:void(0)" > {{translate('Clear')}}</a>
                                                    
                                                </div>
                                                <div class="countries-wrap scroll-div">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="check_all_countries" type="checkbox" value="-1">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            {{translate('All')}}
                                                        </label>
                                                    </div>
                                                    @foreach(config('country') as $value)
                                                        
                                                        <div class="form-check">
                                                            <input name="countries[]" class="form-check-input" type="checkbox" value="{{$value['name']}}">
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
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Location</a>
                                <div class="dropdown-menu shadow">
                                    <div class="mega-content px-4">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="location-top">
                                                    <a class="clear-location-option" href="javascript:void(0)" > {{translate('Clear')}}</a>
                                                    
                                                </div>
                                                <div class="location-wrap scroll-div">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="check_all_location" type="checkbox" value="-1">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            {{translate('All')}}
                                                        </label>
                                                    </div>
                                                    
                                                    @foreach($common->getLocationsOption() as $value)
                                                    
                                                        <div class="form-check">
                                                            <input name="locations[]" class="form-check-input" type="checkbox" value="{{$value}}">
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
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Industry</a>
                                <div class="dropdown-menu shadow">
                                    <div class="mega-content px-4">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="location-top">
                                                    <a class="clear-industries-option" href="javascript:void(0)" > {{translate('Clear')}}</a>
                                                    
                                                </div>

                                                <div class="industries-wrap">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="check_all_industries" type="checkbox" value="-1">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            {{translate('All')}}
                                                        </label>
                                                    </div>
                                                    @foreach($common->getIndustries() as $value)
                                                    
                                                        <div class="form-check">
                                                            <input name="industries[]" class="form-check-input" type="checkbox" value="{{$value}}">
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
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Stages</a>
                                <div class="dropdown-menu shadow">
                                    <div class="mega-content px-4">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="stages-top">
                                                    <a class="clear-stages-option" href="javascript:void(0)" > {{translate('Clear')}}</a>
                                                    
                                                </div>
                                                <div class="stages-wrap">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="check_all_stages" type="checkbox" value="-1">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            {{translate('All')}}
                                                        </label>
                                                    </div>
                                                    
                                                    @foreach($common->getStages() as $value)
                                                    
                                                        <div class="form-check">
                                                            <input name="stages[]" class="form-check-input" type="checkbox" value="{{$value}}">
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
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Funding Type</a>
                                <div class="dropdown-menu shadow">
                                    <div class="mega-content px-4">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="location-top">
                                                    <a class="clear-funding-option" href="javascript:void(0)" > {{translate('Clear')}}</a>
                                                    
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" id="check_all_funding" type="checkbox" value="-1">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{translate('All')}}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="equity_checked" class="form-check-input" type="checkbox" value="1">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{translate('Equity')}}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="convertible_notes_checked" class="form-check-input" type="checkbox" value="1">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{translate('SAFE convertible notes')}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        
                       
                        <div class="input-group">
                            <input class="form-control border-0 mr-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-primary border-0" type="submit">Search</button>
                        </div>
                    </form>
                  </div>
                </div>
              </nav>
        </div>
    </section>

    <section class="content-search">
        <div class="top-title-project">
            <div class="container">
                <h6 class="text-center">{{translate('Recent Project')}}</h6>
                <p class="desc-p">{{translate('Find project and investment opportunities worldwide on the Middle East Investment Network and connect with business entrepreneurs, start up companies, established businesses looking for funding')}}</p>
            </div>
            
            <div class="row column-sm" id="project-lists">
                <div class="container">
                    @if (count($properties))
						@foreach ($properties as $property)
							<div class="col-md-4 wow fadeInUp">
								@include('kemedar.property.property_box')
							</div>
						@endforeach
					@else
						<p class="no-result">{{translate('No property found')}}</p>
					@endif
                </div>
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
            $( "#slider-range" ).slider({
              range: true,
              min: 0,
              max: 500,
              values: [ 75, 300 ],
              slide: function( event, ui ) {
                $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
              }
            });
            $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
              " - $" + $( "#slider-range" ).slider( "values", 1 ) );
        });
    </script>
@endpush