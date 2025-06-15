@extends($theme.'layouts.app', ['body_class' => 'single-view-project'])
@push('style')
    
    
@endpush
@section('title', translate($title))
@inject('common', 'App\Http\Controllers\ProjectController')
@section('content')
    <?php 
        $count_percent = $findProject->have_you_raised ?? 0;
        
        $count_raising = (int)( $findProject->raising) ?  $findProject->raising : 1;
        $getPriceToken = 1;
        if($findProject->token)
            $getPriceToken = $findProject->token->token_price ? $findProject->token->token_price : 1;
        if($common->sumToken($findProject->id))
            $count_percent = (float)$common->sumToken($findProject->id)*(float)$getPriceToken;
        $percent = (int)( ($count_percent/$count_raising)*100);
        $percent = $percent < 100 ? $percent: 100;
            
            
                
    ?>
    <section class="project-banner pd0" id>
        <div class="rib-b-img">
            <img class="bg-cover" src="{{$findProject->banner ? $common->getLinkIdrive($findProject->banner) : 'https://placehold.jp/1920x600.png' }}" alt="bg-cover">
        </div>
        <div class="container">
            <div class="row">
                <div class="cover-bottom">
                    <div class="top-detail">
                        
                        <img alt="logo" src="{{$findProject->logo ? $common->getLinkIdrive($findProject->logo) : 'https://placehold.jp/86x86.png' }}" alt="project-logo">
                        <div class="p-short-detail">
                            <p><strong>{{$findProject->title ?? translate('N/A')}}</strong></p>
                            <p>{{translate("Address")}}: {{$findProject->country ?? translate('N/A')}} </p>
                        </div>
                    </div>
                </div>

                <div class="raised">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-right single-progress">
                        <div class="progress profile-complition text-right ">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: {{$percent}}%">
                                <span style="min-width:120px" class="sr-only">{{$percent}}% <span class="editableLabel" labelid="find_proposal:raised"> {{translate("Raised")}}</span><i class="down"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </section>
    <section class="fixed-menu pd0" id="fixed-scroll-menu">
    </section>
    <section class="menu-section pd0 pdbt20">
        <div class="tab-menu-top" >
            <div class="container">
                <ul class="tabs-menu">
                    <?php 
                        $arrayTab = [translate("Overview"), translate("Pitch Details"), translate("The Team"), translate("Documents"), translate("Questions & Answers")]; 
                    ?>
                    @foreach ($arrayTab as $key => $val )
                        <li class="tab-link {{$key == 0 ? 'active' : ''}}" data-tab="{{$key + 1}}">{{$val}}</li>
                    @endforeach
                </ul>
            </div>
            
        </div>
    </section>
    
    
    <section class="project-content pdt10">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 mb-5">
                    <div class="content-tab-wrapper">
                        
                        <div id="tab-1" class="tab-content active">
                            
                            <div class="summary">
                                
                                @if($findProject->short_summary)
                                    <div class="content-item">
                                        <h5>@lang("Short Summary")</h5>
                                        <div class="desc-content ">
                                            {{$findProject->short_summary}}
                                        </div>
                                    </div>
                                    
                                @endif
                            </div>
                            <div class="highlights">
                                @if($findProject->highlights)
                                    <div class="content-item">
                                        <h5>@lang("Highlights")</h5>
                                        <div class="desc-content">
                                            <ul>
                                                @foreach (explode('#%#', $findProject->highlights) as $val)
                                                    <li>{{$val}}</li>
                                                @endforeach
                                                
                                            </ul>
                                            
                                        </div>
                                    </div>
                                    
                                @endif
                            </div>
                        </div>
                
                        <div id="tab-2" class="tab-content">
                            <div class="pitch-detail">
                                @if($findProject->the_business)
                                    <div class="content-item">
                                        <h5>@lang("The Business")</h5>
                                        <div class="desc-content ">
                                            {{$findProject->the_business}}
                                        </div>
                                    </div>
                                    
                                @endif
                                @if($findProject->the_market)
                                    <div class="content-item">
                                        <h5>@lang("The Market")</h5>
                                        <div class="desc-content ">
                                            {{$findProject->the_market}}
                                        </div>
                                    </div>
                                    
                                @endif
                                @if($findProject->progress_proof)
                                    <div class="content-item">
                                        <h5>@lang("Progress/Proof")</h5>
                                        <div class="desc-content ">
                                            {{$findProject->progress_proof}}
                                        </div>
                                    </div>
                                    
                                @endif
                                @if($findProject->objectives_future)
                                    <div class="content-item">
                                        <h5>@lang("Objectives/Future")</h5>
                                        <div class="desc-content ">
                                            {{$findProject->objectives_future}}
                                        </div>
                                    </div>
                                    
                                @endif
                                @if($findProject->custom_section)
                                    <?php 
                                        $custom_section = json_decode($findProject->custom_section, true);
                                    ?>
                                    @if ($custom_section)
                                        @foreach ( $custom_section as $key => $value )
                                            <div class="content-item">
                                                <h5>{{key_exists(0, $value) ? $value[0] : NULL}}</h5>
                                                <div class="desc-content ">
                                                    {{key_exists(1, $value) ? $value[1] : NULL}}
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                    @endif

                                    
                                @endif
                                @if($findProject->highlights)
                                    <div class="content-item">
                                        <h5>@lang("Highlights")</h5>
                                        <div class="desc-content">
                                            <ul>
                                                @foreach (explode('#%#', $findProject->highlights) as $val)
                                                    <li>{{$val}}</li>
                                                @endforeach
                                                
                                            </ul>
                                            
                                        </div>
                                    </div>
                                    
                                @endif
                                <div class="content-tbl financials_tbl ">
                                    <table class="table">
                                        <tbody>
                                            @if($findProject->equity_checked || $findProject->convertible_notes_checked)
                                                <tr>
                                                    
                                                    <td>@lang("The Deal")</td>
                                                    <td>
                                                        @if($findProject->equity_checked)
                                                            <span>@lang("Equity")</span>, 
                                                        @endif
                                                        @if($findProject->convertible_notes_checked)
                                                            <span>@lang("SAFE convertible notes")</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                
                                            @endif
                                            
                                            @if($findProject->equity_checked)
                                                @if($findProject->raising)
                                                    <tr>
                                                        <td>@lang("How much are you raising in total in this round?")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->raising}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->equity_checked)
                                                @if($findProject->amount_of_investment)
                                                    <tr>
                                                        <td>@lang("How much equity do you give for this amount of investment?")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->amount_of_investment}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($findProject->equity_checked)
                                                @if($findProject->investment_type)
                                                    <tr>
                                                        <td>@lang("What will you do with that amount of investment")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->investment_type}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($findProject->equity_checked)
                                                @if($findProject->as_investments)
                                                    <tr>
                                                        <td>@lang("As investments")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->as_investments}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->purchase_price)
                                                    <tr>
                                                        <td>@lang("Purchase price")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->purchase_price}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->date_of_issuance)
                                                    <tr>
                                                        <td>@lang("Date of issuance")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->date_of_issuance}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->exercise_price)
                                                    <tr>
                                                        <td>@lang("Exercise price")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->exercise_price}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->exercise_date)
                                                    <tr>
                                                        <td>@lang("Exercise date")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->exercise_date}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->discount)
                                                    <tr>
                                                        <td>@lang("Discount")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->discount}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->maturity_date)
                                                    <tr>
                                                        <td>@lang("Maturity Date")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->maturity_date}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->valuation_cap)
                                                    <tr>
                                                        <td>@lang("Valuation cap")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->valuation_cap}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->previous_round_raise)
                                                    <tr>
                                                        <td>@lang("If you did a previous round, how much did you raise?")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->previous_round_raise}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->have_you_raised)
                                                    <tr>
                                                        <td>@lang("How much of this total have you raised?")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->have_you_raised}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->minimum_investment)
                                                    <tr>
                                                        <td>@lang("What is the minimum investment per investor?")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->minimum_investment}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            @if($findProject->convertible_notes_checked)
                                                @if($findProject->maximum_investment)
                                                    <tr>
                                                        <td>@lang("What is the maximum investment per investor?")</td>
                                                        <td class="desc-content ">
                                                            {{$findProject->maximum_investment}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            
                                            
                                            
                                            <tr>
                                                <td>Investor Role</td>
                                                <td><strong>Monthly Involvement</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                

                                @if($findProject->add_financials)
                                    <?php 
                                        $add_financials = json_decode($findProject->add_financials, true);
                                    ?>
                                    @if ($add_financials)
                                        <div class="financials_tbl">

                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Year</th>
                                                        <th>Turner</th>
                                                        <th>Profit<br></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ( $add_financials as $key => $value )
                                                        <tr>
                                                            <td>{{key_exists(0, $value) ? $value[0] : NULL}}</td>
                                                            <td>{{key_exists(1, $value) ? $value[1] : NULL}}</td>
                                                            <td>{{key_exists(2, $value) ? $value[2] : NULL}}</td>
                                                        </tr>
                                                       
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                       
                                        
                                    @endif

                                    
                                @endif
                                @if($findProject->tags)
                                    <div class="content-item">
                                        <h5>@lang("Tags")</h5>
                                        <div class="desc-content ">
                                            {{$findProject->tags}}
                                        </div>
                                    </div>
                                    
                                @endif
                            </div>
                            
                        
                        </div>
                
                        <div id="tab-3"class="tab-content team-content">
                            <!-- Team item -->
                            @if($findProject->team_overview)
                                <div class="container">
                                    <div class="team-overview">
                                        {{$findProject->team_overview}}
                                    </div>
                                </div>
                            @endif
                            
                            <div class="container">
                                <div class="row">
                                    <?php
                                        //var_dump($findProject->team_members);
                                        $members = [];
                                        if($findProject->team_members) {
                                            $members = json_decode($findProject->team_members, true);
                                        }
                                    
                                       
                                    ?>
                                    @if (count($members))
                                        @for ($i = 0; $i < count($members); $i++)
                                            @if($i % 3 == 0 && $i > 0)
                                                </div><div class="row">
                                            @endif
                                            @php
                                                $url = "javascript:void(0)";
                                                if(key_exists(2, $members[$i])) {
                                                    if(filter_var($members[$i][2], FILTER_VALIDATE_URL))
                                                        $url = $members[$i][2];
                                                        
                                                }
                                               
                                            @endphp
                                            <div class="col-lg-4 col-md-4">
                                                <div class="column">
                                                    <div class="card">
                                                        <a href="{{$url}}">
                                                            <div class="img-wrap">
                                                                @if (key_exists(0, $members[$i]))
                                                                    <img src="{{ $common->getLinkIdrive($members[$i][0])}}" alt="Jane">
                                                                @else
                                                                    <img src="https://placehold.jp/86x86.png" alt="Jane">
                                                                @endif
                                                            </div>
                                                        </a>
                                                        
                                                        <div class="team-desc">
                                                            @if (key_exists(1, $members[$i]))
                                                                <h5>{{$members[$i][1]}}</h5>
                                                            @endif
                                                            @if (key_exists(3, $members[$i]))
                                                                <p class="title">{{$members[$i][3]}}</p>
                                                            @endif
                                                            @if (key_exists(4, $members[$i]))
                                                                <p>{{$members[$i][4]}}</p>
                                                            @endif
                                                            
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <div id="tab-4"class="tab-content">
                            <div class="gallery-wrapper container">
                                <div class="wrapper">
                                   
                                </div>
                                
                            </div>
                            
                            <div class="content-tbl financials_tbl">
                                @if($findProject->business_plan || $findProject->financials || $findProject->pitch_deck || $findProject->executive_summary || $findProject->additional_documents )
                                    <table class="table">
                                        <tbody>
                                            
                                            
                                
                                            @if($findProject->business_plan)
                                                <tr>
                                                    <td>@lang("Business Plan")</td>
                                                    <td class="desc-content ">
                                                        <a download href="{{$common->getLinkIdrive($findProject->business_plan) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                                    </td>
                                                </tr>
                                            @endif
                                
                                            @if($findProject->financials)
                                                <tr>
                                                    <td>@lang("Financials")</td>
                                                    <td class="desc-content ">
                                                        <a download href="{{$common->getLinkIdrive($findProject->financials) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                                    </td>
                                                </tr>
                                            @endif
                                            
                                            @if($findProject->pitch_deck)
                                                <tr>
                                                    <td>@lang("Pitch Deck")</td>
                                                    <td class="desc-content ">
                                                        <a download href="{{$common->getLinkIdrive($findProject->pitch_deck) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                                    </td>
                                                </tr>
                                            @endif
                                            
                                            @if($findProject->executive_summary)
                                                <tr>
                                                    <td>@lang("Executive Summary")</td>
                                                    <td class="desc-content ">
                                                        <a download href="{{$common->getLinkIdrive($findProject->executive_summary) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                                    </td>
                                                </tr>
                                            @endif
                                            
                                            @if($findProject->additional_documents)
                                                <tr>
                                                    <td>@lang("Additional Documents")</td>
                                                    <td class="desc-content ">
                                                        <a download href="{{$common->getLinkIdrive($findProject->additional_documents) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                @endif
                                
                            </div>
                            
                        
                        </div>
                        <div id="tab-5"class="tab-content">
                        
                        </div>
                
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 mb-5">
                    <div class="proposal-blocks">
                        <p><span class="editableLabel">Overview</span></p>
                        <div class="investment-summary">
                            <table class="table">
                                <tbody><tr>
                                    <td>Target</td>
                                    <td>
                                        <div> <strong>{{$findProject->maximum_investment ? 'US$ ' .number_format((float)$findProject->maximum_investment , 2, '.', '') : translate('N/A')}}</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Minimum </td>
                                    <td>
                                        <div> <strong>{{$findProject->minimum_investment ? 'US$ ' .number_format((float)$findProject->minimum_investment, 2, '.', '') :  translate('N/A')}}</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Investment Raised</td>
                                    <td>
                                        <div><strong>{{$findProject->have_you_raised ? 'US$ ' .number_format((float)$findProject->have_you_raised, 2, '.', '') :  translate('N/A')}}</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Previous Rounds</td>
                                    <td><strong>{{$findProject->previous_round_raise ? 'US$ ' .number_format((float)$findProject->previous_round_raise, 2, '.', '') :  translate('N/A')}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stage </td>
                                    <td><strong>{{$findProject->stage ?? translate('N/A')}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Investor Role</td>
                                    <td><strong>{{$findProject->ideal_investor_role ?? translate('N/A')}}</strong></td>
                                </tr>
                            </tbody></table>
                        </div>
                                                                                                                                   
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="alert alert-info">
                <div class=" custom-info">
                    <strong>@lang('Please note'):</strong> 
                    <span class="editableLabel" labelid="proposal_view:note_content">
                        {{translate("Investing in early stage businesses involves risks, including illiquidity, lack of dividends, loss of investment and dilution, and it should be done only as part of a diversified portfolio. This platform is targeted solely at investors who are sufficiently sophisticated to understand these risks and make their own investment decisions. Investors are encouraged to review and evaluate the investments and determine at their own discretion, the appropriateness of making the particular investment. The information on this website is provided for informational purposes only, but we cannot guarantee that the information is accurate or complete. We strongly encourage investors to complete their own due diligence with licensed professionals, prior to making any investment and will not offer any legal or tax advice")}}.
                    </span>                    
                </div>
            </div>
        </div>
    </section>
    
    <section class="contact-admin">
        <div class="container">
            <h6>{{translate("To view the full pitch you must be a registered investor. To upgrade to an investor account, please email")}} </h6>
            <a href="mailto:info-desk@ribano.com" class="admin-email">info-desk@ribano.com</a>
        </div>
    </section>
    
@endsection

