@extends($theme.'layouts.app', ['body_class' => 'single-view-project'])
@inject('common', 'App\Http\Controllers\ProjectController')
@push('style')

    <style>
        .tabs-menu{
            flex-wrap:wrap !important;
            gap:16px;
        }

        .tab-link{
            margin:0;
        }
    </style>

@endpush

<?php
    $have_you_raised = $findProject->have_you_raised;
    $getPriceToken = 1;
    if($findProject->token)
        $getPriceToken = $findProject->token->token_price ? $findProject->token->token_price : 1;
    if($common->sumToken($findProject->id))
        $have_you_raised = (float)$common->sumToken($findProject->id)*(float)$getPriceToken;
    $bg_img = $findProject->banner ? $common->getLinkIdrive($findProject->banner) : 'https://placehold.jp/1920x600.png';

    $token_symbol = "$";

    if($findProject->token)
        $token_symbol = $findProject->token->token_symbol;


    $currency_symbol = session('currency') ?? '$';
    if($currency_symbol == 'USD')
        $currency_symbol = '$';
?>
@push('css-lib')
<link rel="stylesheet" href="{{ asset('public/assets/css/toastr.min.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@endpush
@section('title', translate($title))

@section('content')
<section class="project-banner container pd0">
    <div class="rib-b-img" style="background: url({{$bg_img}})">
        {{-- <img class="bg-cover"
            src="{{$findProject->banner ? $common->getLinkIdrive($findProject->banner) : 'https://placehold.jp/1920x600.png' }}"
            alt="bg-cover"> --}}
    </div>
    <div class="container">
        <div class="row-cover">
            <div class="cover-bottom">
                <div class="top-detail">

                    <img alt="logo"
                        src="{{$findProject->logo ? $common->getLinkIdrive($findProject->logo) : 'https://placehold.jp/86x86.png' }}"
                        alt="project-logo">
                    <div class="p-short-detail">
                        <p><strong>{{$findProject->title ?? translate('N/A')}}</strong></p>
                        <p><label>{{translate("Location")}}</label>: {{$findProject->country ?? translate('N/A')}} </p>
                    </div>
                </div>
            </div>
            @include('project.raised', ['project' => $findProject])
            {{-- <div class="raised">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-right single-progress">
                    <div class="progress profile-complition text-right ">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="65"
                            aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            <span style="min-width:120px" class="sr-only">80% <span class="editableLabel"
                                    labelid="find_proposal:raised"> Raised</span> <i class="down"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>


</section>
<section class="fixed-menu pd0" id="fixed-scroll-menu">
</section>
<section class="menu-section pd0 pdbt20">
    <div class="tab-menu-top">
        <div class="container">
            <ul class="tabs-menu">

                <?php $question_answer = json_decode($findProject->question_answer, true); ?>
                <?php

                        $members = [];
                        if($findProject->team_members) {
                            $members = json_decode($findProject->team_members, true);
                        }
                        $overview_style = $pitch_details_style = $the_team_style = $data_room_style = $deal_style = $video_style = $galleries_style = $questions_style = "";
                        if(count($members) == 0) {
                            $the_team_style = "display: none";
                        }
                        if($findProject->business_plan == null && $findProject->financials == null && $findProject->pitch_deck == null
                        && $findProject->executive_summary  == null && $findProject->additional_documents == null) {
                            $data_room_style = "display: none";
                        }
                        if(!$findProject->equity_checked && !$findProject->convertible_notes_checked) {
                            $deal_style = "display: none";
                        }
                        if(!$common->generateVideoEmbedUrl($findProject->video_url) && !$findProject->videosPerPage) {
                            $video_style = "display: none";
                        }
                        if(!$imagesPerPage) {
                            $galleries_style = "display: none";
                        }
                        if(!$question_answer) {
                            $questions_style = "display: none";
                        }

                        $arrayTab = [translate("Overview"), translate("Pitch Details"), translate("The Team"), translate("Data Room"), translate("Deal"), translate("Video"), translate("Galleries"), translate("Questions & Answers")];

                    ?>
                {{-- @foreach ($arrayTab as $key => $val )
                <li class="tab-link {{$key == 0 ? 'active' : ''}}" data-tab="{{$key + 1}}">
                    <a href="javascript:void(0)">{{$val}}</a>
                </li>
                @endforeach --}}

                @foreach ($arrayTab as $key => $val )

                <?php

                            if($key == 7)
                                $class = $questions_style;
                            else
                                $class = ${convertToSnakeCase($val) . '_style'};


                        ?>

                <li <?php echo 'style="' .$class.'"' ?> class="{{slug($val)}} tab-link {{$key == 0 ? 'active' : ''}}"
                    data-tab="{{$key + 1}}">
                    <a href="javascript:void(0)" <?php if($key==5) echo 'onclick="loadVideoSpeed(event);"' ; if($key==6)
                        echo 'onclick="loadImagesSpeed(event);"' ?> >{{$val}} </a>
                </li>
                @endforeach

                @if (Auth::check())
                <li class="project-li-shortlist mb-1">
                    <form method="post" action="{{route('addProjectToList')}}">
                        <a data-type="interested" data-target="{{$findProject->id}}" class="add-project-shortlist" class
                            href="javascript:void(0)">{{translate("I'm Interested", null, false)}}</a>
                    </form>
                </li>
                <li class="project-li-shortlist none-bg">
                    <form method="post" action="{{route('addProjectToList')}}">
                        <a data-type="shortlist" data-target="{{$findProject->id}}" class="add-project-shortlist " class
                            href="javascript:void(0)">{{translate("Shortlist")}}</a>
                    </form>
                </li>
                @endif

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

                                <h5>
                                    @if ($findProject->summary_title)
                                    {{$findProject->summary_title}}
                                    @else
                                    {{translate("Short Summary")}}
                                    @endif


                                </h5>
                                <div class="desc-content ">
                                    {!!$findProject->short_summary!!}
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
                            {{-- <table class="table">
                                <tbody>



                                    @if($findProject->raising)
                                    <tr>
                                        <td>{{translate('Target')}}</td>
                                        <td>
                                            <div> <strong>{{$findProject->raising ?
                                                    number_format((float)$findProject->raising , 0, '.', '.'). ' ' .
                                                    $token_symbol : translate('N/A')}}</strong></div>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($findProject->investment_grand)
                                    <tr>
                                        <td>{{translate('Raised')}}</td>

                                        <td>
                                            <p>{{$findProject->investment_grand ? '$ '
                                                .number_format((float)$findProject->investment_grand, 2, '.', '.') :
                                                translate('N/A')}}</p>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($findProject->investor_numbers)
                                    <tr>
                                        <td>{{translate("Investors numbers")}}</td>
                                        <td>{{$findProject->investor_numbers ? $findProject->investor_numbers :
                                            translate('N/A')}}</td>
                                    </tr>

                                    @endif
                                    @if($findProject->minimum_investment)
                                    <tr>
                                        <td>{{translate("Minimum Investment")}}</td>
                                        <td class="desc-content ">
                                            {{$findProject->minimum_investment}}
                                        </td>
                                    </tr>

                                    @endif

                                    @if($findProject->maximum_investment)
                                    <tr>
                                        <td>{{translate("Maximum Investment")}}</td>
                                        <td class="desc-content ">
                                            {{$findProject->maximum_investment}}
                                        </td>
                                    </tr>


                                    @endif


                                    @if($findProject->website)
                                    <tr>
                                        <td>
                                            <p>{{translate("Website")}}</p>
                                        </td>
                                        <td><a href="{{$findProject->website}}">{{$findProject->website}}</a></td>
                                    </tr>

                                    @endif
                                    @if($findProject->located)
                                    <tr>
                                        <td>
                                            <p>{{translate("Management located")}}</p>
                                        </td>
                                        <td>
                                            <p>{{$findProject->located}}</p>
                                        </td>
                                    </tr>

                                    @endif
                                    @if($findProject->country)
                                    <tr>
                                        <td>
                                            <p>{{translate("Location")}}</p>
                                        </td>
                                        <td>
                                            <p>{{$findProject->country}}</p>
                                        </td>
                                    </tr>

                                    @endif
                                    @if($findProject->stage)
                                    <tr>
                                        <td>{{translate('Stage')}} </td>
                                        <td><strong>{{$findProject->get_stage->name ?? translate('N/A')}}</strong></td>
                                    </tr>
                                    @endif
                                    @if ($findProject->ideal_investor_role)
                                    <tr>
                                        <td>{{translate('Investor Role')}}</td>
                                        <td><strong>{{$findProject->ideal_investor_role ?? translate('N/A')}}</strong>
                                        </td>
                                    </tr>
                                    @endif

                                    @if($findProject->industry_1 && is_numeric($findProject->industry_1))
                                    <tr>
                                        <td>
                                            <p>{{translate("Industry")}}</p>
                                        </td>
                                        <td>
                                            <p>{{$findProject->get_industry1->name}}</p>
                                        </td>
                                    </tr>

                                    @endif
                                    @if($findProject->industry_2 && is_numeric($findProject->industry_2))
                                    <tr>
                                        <td>
                                            <p>{{translate("Industry")}}</p>
                                        </td>
                                        <td>
                                            <p>{{$findProject->get_industry2->name}}</p>
                                        </td>
                                    </tr>

                                    @endif
                                </tbody>
                            </table> --}}




                            @if($findProject->short_summary)
                            <div class="content-item">
                                {{-- <h5>@lang("The Business")</h5> --}}


                                <h5>
                                    @if ($findProject->summary_title)
                                    {!!$findProject->summary_title!!}
                                    @else
                                    {{translate("The Summary")}}
                                    @endif


                                </h5>

                                <div class="desc-content ">
                                    {!!$findProject->short_summary!!}
                                </div>
                            </div>

                            @endif
                            @if($findProject->the_business)
                            <div class="content-item">
                                {{-- <h5>@lang("The Business")</h5> --}}


                                <h5>
                                    @if ($findProject->business_title)
                                    {!!$findProject->business_title!!}
                                    @else
                                    {{translate("The Business")}}
                                    @endif


                                </h5>

                                <div class="desc-content ">
                                    {!!$findProject->the_business!!}
                                </div>
                            </div>

                            @endif
                            @if($findProject->the_market)
                            <div class="content-item">
                                {{-- <h5>@lang("The Market")</h5> --}}

                                <h5>
                                    @if ($findProject->the_market_title)
                                    {{$findProject->the_market_title}}
                                    @else
                                    {{translate("The Market")}}
                                    @endif


                                </h5>

                                <div class="desc-content ">
                                    {!!$findProject->the_market!!}
                                </div>
                            </div>

                            @endif
                            @if($findProject->progress_proof)
                            <div class="content-item">
                                {{-- <h5>@lang("Progress/Proof")</h5> --}}

                                <h5>
                                    @if ($findProject->progress_proof_title)
                                    {{$findProject->progress_proof_title}}
                                    @else
                                    {{translate("Progress/Proof")}}
                                    @endif


                                </h5>

                                <div class="desc-content ">
                                    {!!$findProject->progress_proof!!}
                                </div>
                            </div>

                            @endif
                            @if($findProject->objectives_future)
                            <div class="content-item">
                                {{-- <h5>@lang("Objectives/Future")</h5> --}}
                                <h5>
                                    @if ($findProject->objectives_future_title)
                                    {{$findProject->objectives_future_title}}
                                    @else
                                    {{translate("Objectives/Future")}}
                                    @endif


                                </h5>
                                <div class="desc-content ">
                                    {!!$findProject->objectives_future!!}
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
                                    @if (key_exists(1, $value))
                                    {!! nl2br($value[1]) !!}

                                    @endif

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



                            @if($findProject->add_financials)
                            <?php
                                        $add_financials = json_decode($findProject->add_financials, true);
                                    ?>
                            @if ($add_financials)
                            <div class="financials_tbl">

                                <table>
                                    <thead>
                                        <tr>
                                            <th>{{translate('Year')}}</th>
                                            <th>{{translate('Turner')}}</th>
                                            <th>{{translate('Profit')}}<br></th>
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
                            @php
                            $tags = explode('%###%', $findProject->tags);

                            @endphp
                            <div class="content-item">
                                <h5>@lang("Tags")</h5>
                                <div class="desc-content ">
                                    {{implode(', ', $tags)}}
                                </div>
                            </div>

                            @endif


                        </div>


                    </div>

                    <div id="tab-3" <?php echo 'style="' .$the_team_style.'"' ?> class="tab-content team-content" >
                        <!-- Team item -->
                        @if($findProject->team_overview)
                        <div class="container">
                            <div class="team-overview">
                                {!!$findProject->team_overview!!}
                            </div>
                        </div>
                        @endif

                        <div class="container">
                            <div class="row row-box">

                                @if (count($members))
                                @for ($i = 0; $i < count($members); $i++) @if($i % 3==0 && $i> 0)
                            </div>
                            <div class="row row-box">
                                @endif
                                @php
                                $url = "javascript:void(0)";
                                if(key_exists(2, $members[$i])) {
                                if(filter_var($members[$i][2], FILTER_VALIDATE_URL))
                                $url = $members[$i][2];

                                }

                                @endphp
                                <div class="col-lg-4 col-md-4 col-box">
                                    <div class="column">
                                        <div class="card-item">
                                            <a href="{{$url}}">
                                                <div class="img-wrap">

                                                    @if (key_exists(0, $members[$i]) && $members[$i][0] &&
                                                    strpos($members[$i][0], 'ribano.org') !== false)

                                                    <img src="{{ $common->getLinkIdrive($members[$i][0])}}"
                                                        alt="Team avatar">
                                                    @else
                                                    <img src="https://placehold.jp/266x200.png" alt="Team avatar">
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
                    <div id="tab-4" <?php echo 'style="' .$data_room_style.'"' ?> class="tab-content">


                        <div class="content-tbl financials_tbl">
                            @if($findProject->business_plan || $findProject->financials || $findProject->pitch_deck ||
                            $findProject->executive_summary || $findProject->additional_documents )
                            <table class="table">
                                <tbody>
                                    @if($findProject->business_plan)
                                    <tr>
                                        <td>@lang("Business Plan")</td>
                                        <td class="desc-content ">
                                            <a download
                                                href="{{$common->getLinkIdrive($findProject->business_plan) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                        </td>
                                    </tr>
                                    @endif

                                    @if($findProject->financials)
                                    <tr>
                                        <td>@lang("Financials")</td>
                                        <td class="desc-content ">
                                            <a download
                                                href="{{$common->getLinkIdrive($findProject->financials) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                        </td>
                                    </tr>
                                    @endif

                                    @if($findProject->pitch_deck)
                                    <tr>
                                        <td>@lang("Pitch Deck")</td>
                                        <td class="desc-content ">
                                            <a download
                                                href="{{$common->getLinkIdrive($findProject->pitch_deck) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                        </td>
                                    </tr>
                                    @endif

                                    @if($findProject->executive_summary)
                                    <tr>
                                        <td>@lang("Executive Summary")</td>
                                        <td class="desc-content ">
                                            <a download
                                                href="{{$common->getLinkIdrive($findProject->executive_summary) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                        </td>
                                    </tr>
                                    @endif

                                    @if($findProject->additional_documents)
                                    <tr>
                                        <td>{{$findProject->additional_documents_name ?
                                            $findProject->additional_documents_name : translate('Additional Documents')
                                            }}</td>
                                        <td class="desc-content ">
                                            <a download
                                                href="{{$common->getLinkIdrive($findProject->additional_documents) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @php
                                    $add_document_section = json_decode($findProject->more_documents, true);
                                    @endphp
                                    @if($add_document_section)

                                    @foreach ( $add_document_section as $key => $value )
                                    <tr>
                                        <td>{{key_exists(1, $value) ? $value[1] : translate('Additional Documents') }}
                                        </td>

                                        <td class="desc-content ">
                                            @if (key_exists(0, $value) && strpos($value[0], 'ribano.org') !== false)
                                            <a target="_blank"
                                                href="{{$common->getLinkIdrive($value[0]) ?? 'javascript:void(0)'}}">{{translate('View')}}</a>
                                            @else

                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @endif

                        </div>


                    </div>

                    @php
                    $add_more_investment = $add_financials = [];
                    if($findProject->add_more_investment) {
                    $add_more_investment = json_decode($findProject->add_more_investment, true);
                    }
                    if($findProject->add_financials) {
                    $add_financials = json_decode($findProject->add_financials, true);
                    }
                    @endphp

                    <div id="tab-5" <?php echo 'style="' .$deal_style.'"' ?> class="tab-content">

                        @if($findProject->equity_checked)
                        <h5>{{translate("Equity:")}}</h5>

                        <div class="equity-wrap">
                            <table class="table table-border">
                                <tbody>
                                    @if($findProject->raising)
                                    <tr>
                                        <td>@lang("Target")</td>
                                        <td class="desc-content ">
                                            <p>{{$findProject->raising ? $currency_symbol . ' ' . convertUSDToCurrency($findProject->raising, $currency_symbol) :
                                                translate('N/A')}}</p>
                                        </td>
                                    </tr>
                                    @endif

                                    @if($findProject->amount_of_investment)
                                    <tr>
                                        <td>{{translate("Equity for this investment")}}</td>
                                        <td class="desc-content ">
                                            {{$findProject->amount_of_investment}}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{{translate("Planned Expenses")}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$findProject->investment_type}}</td>
                                        <td class="desc-content ">
                                            {{$findProject->as_investments ?? 0}}
                                        </td>
                                    </tr>
                                    @endif

                                    @if ($add_more_investment)
                                    @foreach ($add_more_investment as $val)
                                    <tr>

                                        @if(array_key_exists(0, $val))
                                        <td>{{$val[0]}}</td>
                                        @else
                                        <td></td>
                                        @endif
                                        @if(array_key_exists(1, $val))
                                        <td class="desc-content ">{{$val[1]}}</td>
                                        @else
                                        <td></td>
                                        @endif
                                        {{-- <td class="desc-content ">
                                            {{$findProject->as_investments}}
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                    @endif
                                    @if($total_investment)
                                    <tr>
                                        <td>{{translate('Total of investment needed')}}</td>
                                        <td><strong>{{n_format($total_investment)}}</strong>
                                        </td>
                                    </tr>
                                    @endif

                                    @if ($findProject->total_share)

                                    <tr>
                                        <td>{{translate("Total shares of the company")}}</td>
                                        <td class="desc-content ">
                                            {{$findProject->total_share}}
                                        </td>
                                    </tr>
                                    @endif
                                    @if ($findProject->price_of_share)

                                    <tr>
                                        <td>{{translate("Price of share")}}</td>
                                        <td class="desc-content ">
                                            {{$findProject->price_of_share}}
                                        </td>
                                    </tr>
                                    @endif

                                    @if ($findProject->shares_granted)

                                    <tr>
                                        <td>{{translate("Shares granted for this investment")}}</td>
                                        <td class="desc-content ">
                                            {{$findProject->shares_granted}}
                                        </td>
                                    </tr>
                                    @endif





                                    @if($findProject->accept)
                                    <tr class="content-item">
                                        <td>{{translate("I can accept")}}</td>
                                        <td>{{$findProject->accept}}</td>
                                    </tr>

                                    @endif
                                    @if($findProject->investment_equity_previous_rounds)
                                    <tr class="content-item">
                                        <td>{{translate("Previous rounds raise the amount")}}</td>
                                        <td>{{$findProject->investment_equity_previous_rounds}}</td>
                                    </tr>

                                    @endif
                                    @if($findProject->investment_equity_grand)
                                    <tr class="content-item">
                                        <td>{{translate("Investment already granted from the current round")}}</td>
                                        <td>{{$findProject->investment_equity_grand}}</td>
                                    </tr>

                                    @endif
                                    @if($findProject->investor_equity_numbers)
                                    <tr class="content-item">
                                        <td>{{translate("Investor numbers of the current round")}}</td>
                                        <td>{{$findProject->investor_equity_numbers}}</td>
                                    </tr>

                                    @endif

                                    @if($findProject->minimum_equity_investment)
                                    <tr class="content-item">
                                        <td>{{translate("Minimum investment per investor")}}</td>
                                        <td>{{$findProject->minimum_equity_investment}}</td>
                                    </tr>

                                    @endif
                                    @if($findProject->maximum_equity_investment)
                                    <tr class="content-item">
                                        <td>{{translate("Maximum investment per investor")}}</td>
                                        <td>{{$findProject->maximum_equity_investment}}</td>
                                    </tr>

                                    @endif




                                </tbody>
                            </table>
                        </div>

                        @endif

                        @if($findProject->convertible_notes_checked)
                        <h5>{{translate("SAFE")}}</h5>
                        <table class="table table-border">
                            <tbody>
                                @if($findProject->safe_target)
                                <tr>
                                    <td>{{translate("Target")}}</td>
                                    <td class="desc-content ">
                                        {{$findProject->safe_target}}
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->purchase_price)
                                <tr>
                                    <td>{{translate("Purchase price")}}</td>
                                    <td class="desc-content ">
                                        {{$findProject->purchase_price}}
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->date_of_issuance)
                                <tr>
                                    <td>{{translate("Date of issuance")}}</td>
                                    <td class="desc-content ">
                                        {{$findProject->date_of_issuance}}
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->exercise_price)
                                <tr>
                                    <td>{{translate("Exercise price")}}</td>
                                    <td class="desc-content ">
                                        {{$findProject->exercise_price}}
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->exercise_date)
                                <tr>
                                    <td>{{translate("Exercise date")}}</td>
                                    <td class="desc-content ">
                                        {{$findProject->exercise_date}}
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->discount)
                                <tr>
                                    <td>{{translate("Discount")}}</td>
                                    <td class="desc-content ">
                                        {{$findProject->discount}}
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->maturity_date)
                                <tr>
                                    <td>{{translate("Maturity Date")}}</td>
                                    <td class="desc-content ">
                                        {{$findProject->maturity_date}}
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->valuation_cap)
                                <tr>
                                    <td>{{translate("Valuation cap")}}</td>
                                    <td class="desc-content ">
                                        {{$findProject->valuation_cap}}
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->previous_round_raise)
                                <tr class="content-item">
                                    <td>{{translate("Previous rounds raise the amount")}}</td>
                                    <td>{{$findProject->previous_round_raise}}</td>
                                </tr>

                                @endif
                                @if($findProject->investment_grand)
                                <tr class="content-item">
                                    <td>{{translate("Investment already granted from the current round")}}</td>
                                    <td>{{$findProject->investment_grand}}</td>
                                </tr>

                                @endif
                                @if($findProject->investor_numbers)
                                <tr class="content-item">
                                    <td>{{translate("Investor numbers of the current round")}}</td>
                                    <td>{{$findProject->investor_numbers}}</td>
                                </tr>

                                @endif

                                @if($findProject->minimum_investment)
                                <tr class="content-item">
                                    <td>{{translate("Minimum investment per investor")}}</td>
                                    <td>{{$findProject->minimum_investment}}</td>
                                </tr>

                                @endif
                                @if($findProject->maximum_investment)
                                <tr class="content-item">
                                    <td>{{translate("Maximum investment per investor")}}</td>
                                    <td>{{$findProject->maximum_investment}}</td>
                                </tr>

                                @endif


                            </tbody>
                        </table>
                        @endif



                    </div>
                    <div id="tab-6" <?php echo 'style="' .$video_style.'"' ?> class="tab-content">
                        @php
                        $images = [];
                        if($findProject->images) {
                        $images = explode('%###%', $findProject->images);
                        }
                        $videos = [];
                        if($findProject->add_video) {
                        $videos = json_decode($findProject->add_video, true);
                        }
                        @endphp



                        <div class="video-wrap container">
                            <h5>{{translate('Videos')}}</h5>
                            <div class="row">
                                <div class="loading-spin"></div>
                                @if ($common->generateVideoEmbedUrl($findProject->video_url))
                                <div class="video-container col-sm-12">
                                    <div class="video-ct">
                                        @if($findProject->video_title)
                                        <h6>{{$findProject->video_title}}</h6>
                                        @endif
                                        @if($findProject->video_description)
                                        <div class="video-description">{{$findProject->video_description}}</div>
                                        @endif
                                    </div>

                                    <iframe allowfullscreen width="100%" height="350"
                                        src="{{$common->generateVideoEmbedUrl($findProject->video_url)}}">
                                    </iframe>
                                </div>
                                @endif

                                @if ($videosPerPage)
                                <div id="load-video-wrap"></div>

                                {{-- <div class="row" id="video-wrap">
                                    @foreach ($videosPerPage as $video)
                                    @if($common->generateVideoEmbedUrl($video[0] ?? NULL))
                                    <div class="video-container col-sm-6">
                                        <div class="video-ct">
                                            @if(array_key_exists(1, $video))
                                            <h6>{{$video[1]}}</h6>
                                            @endif
                                            @if(array_key_exists(2, $video))
                                            <div class="video-description">{{$video[2]}}</div>
                                            @endif
                                        </div>


                                        <iframe allowfullscreen width="100%" height="250"
                                            src="{{$common->generateVideoEmbedUrl($video[0])}}">
                                        </iframe>
                                    </div>
                                    @endif
                                    @endforeach
                                </div> --}}



                                @if ($totalVideoItem > 12)
                                <div id="pagination-video" style="display: none">

                                    <nav class="theme-video-nav"></nav>

                                </div>
                                @endif


                                @endif

                            </div>


                        </div>



                    </div>


                    <div id="tab-7" <?php echo 'style="' .$galleries_style.'"' ?> class="tab-content">

                        @php
                        $images = [];
                        if($findProject->images) {
                        $images = explode('%###%', $findProject->images);
                        }

                        @endphp

                        @if($imagesPerPage)
                        <div id="load-gallery-wrap"></div>
                        {{-- <div class="gallery-wrap container">
                            <h5>{{translate('Galleries')}}</h5>
                            <div class="loading-spin"></div>
                            <div class="gallery-row">
                                @foreach ($imagesPerPage as $img)

                                @if($img)

                                <a class="horizontal" data-fancybox="gallery"
                                    data-src="{{$common->getLinkIdrive($img)}}">
                                    <img src="{{$common->getLinkIdrive($img)}}" />
                                </a>
                                @endif


                                @endforeach
                            </div>
                        </div>
                        @if ($totalItem > 12)
                        <div id="pagination-wrap">
                            <nav class="theme-pagination"></nav>
                        </div>
                        @endif --}}
                        @if ($totalItem > 12)
                        <div id="pagination-wrap" style="display: none">
                            <nav class="theme-pagination"></nav>
                        </div>
                        @endif

                        @endif

                    </div>


                    <div id="tab-8" <?php echo 'style="' .$questions_style.'"' ?> class="tab-content">
                        @if ($question_answer)
                        <div class="row">
                            @foreach($question_answer as $k => $data)
                            @if ($data[0])
                            <div class="col-md-12" data-aos="fade-left">
                                <div class="accordion_area mt-45">
                                    <div class="accordion_item shadow3">
                                        <button class="accordion_title">{{$data[0]}}<i
                                                class="{{($k == 0) ? 'fa fa-minus': 'fa fa-plus' }}"></i></button>
                                        <div class="accordion_body {{($k == 0) ? 'show' : ''}}">
                                            {{$data[1] ?? NULL}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @endforeach
                        </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-md-3 mb-5">
                <div class="proposal-blocks">
                    <p><span class="editableLabel">{{translate('Overview')}}</span></p>
                    <div class="investment-summary">
                        <?php

                                $add_more_investment = json_decode($findProject->add_more_investment, true) ?? [];
                                $more_investment = 'N/A';
                                $key = 'Shares granted for this investment';
                                if(key_exists($key, $add_more_investment)){
                                   $more_investment = $add_more_investment[$key];
                                }



                            ?>
                        <p><strong class="editableLabel">{{translate('Pitch Detail')}}</strong></p>
                        <table class="table">
                            <tbody>
                                @if($findProject->raising)
                                <tr>
                                    <td>{{translate('Target')}}</td>
                                    <td>
                                        <div> <strong>{{$findProject->raising ? $currency_symbol . ' ' . convertUSDToCurrency($findProject->raising, $currency_symbol) :
                                                translate('N/A')}}</strong></div>
                                    </td>
                                </tr>
                                @endif




                                {{-- @if($more_investment != 'N/A')
                                <tr>
                                    <td>{{translate($key)}} </td>
                                    <td>

                                        <div> <strong>{{$more_investment }}</strong></div>
                                    </td>
                                </tr>
                                @endif --}}

                                @if($findProject->investment_equity_grand)
                                <tr>
                                    <td>{{translate('Raised')}}</td>
                                    <td><strong>{{$findProject->investment_equity_grand ? '$ ' .
                                            $findProject->investment_equity_grand : 0 }}</strong>
                                    </td>
                                </tr>
                                @endif



                                @if($findProject->investor_equity_numbers)
                                <tr>
                                    <td>{{translate('Investor numbers')}}</td>
                                    <td><strong>{{$findProject->investor_equity_numbers ?
                                            $findProject->investor_equity_numbers : 0 }}</strong>
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->minimum_equity_investment)
                                <tr>
                                    <td>{{translate('Minimum Investment')}} </td>
                                    <td>

                                        <div> <strong>{{$findProject->minimum_equity_investment ? $currency_symbol . ' ' .
                                                convertUSDToCurrency($findProject->minimum_equity_investment, $currency_symbol) : 0}}</strong></div>
                                    </td>
                                </tr>
                                @endif

                                @if($findProject->maximum_investment)

                                <tr>
                                    <td>{{translate('Maximum Investment')}} </td>
                                    <td>

                                        <div> <strong>{{$findProject->maximum_equity_investment ? '$ ' .
                                                $findProject->maximum_equity_investment : 0 }}</strong></div>
                                    </td>
                                </tr>
                                @endif

                                {{-- @if($have_you_raised)
                                <tr>

                                    <td>{{translate('Investment Raised')}}</td>
                                    <td>
                                        <div><strong>{{$have_you_raised ? 'US$ ' .number_format((float)$have_you_raised,
                                                2, '.', '') : translate('N/A')}}</strong></div>
                                    </td>
                                </tr>
                                @endif --}}



                                {{-- @if($findProject->previous_round_raise)
                                <tr>
                                    <td>{{translate('Previous Rounds')}}</td>
                                    <td><strong>{{$findProject->previous_round_raise ? 'US$ '
                                            .number_format((float)$findProject->previous_round_raise, 2, '.', '') :
                                            translate('N/A')}}</strong>
                                    </td>
                                </tr>
                                @endif --}}
                                @if($findProject->website)
                                <tr>
                                    <td>
                                        <p>{{translate("Website")}}</p>
                                    </td>
                                    <td><a target="_blank"
                                            href="{{$findProject->website}}">{{$findProject->website}}</a></td>
                                </tr>

                                @endif

                                @if($findProject->country)
                                <tr>
                                    <td>
                                        <p>{{translate("Location")}}</p>
                                    </td>
                                    <td>
                                        <p>{{$findProject->country}}</p>
                                    </td>
                                </tr>

                                @endif
                                @if($findProject->stage)
                                <tr>
                                    <td>{{translate('Stage')}} </td>
                                    <td><strong>{{$findProject->get_stage->name ?? translate('N/A')}}</strong></td>
                                </tr>
                                @endif



                                @if($findProject->ideal_investor_role)
                                <tr>
                                    <td>{{translate('Investor Role')}}</td>
                                    <td><strong>{{$findProject->ideal_investor_role ?? translate('N/A')}}</strong></td>
                                </tr>
                                @endif

                                @if($findProject->industry_1 && is_numeric($findProject->industry_1))
                                <tr>
                                    <td>
                                        <p>{{translate("Industry")}}</p>
                                    </td>
                                    <td>
                                        <p>{{$findProject->get_industry1->name}}</p>
                                    </td>
                                </tr>

                                @endif
                                @if($findProject->industry_2 && is_numeric($findProject->industry_2))
                                <tr>
                                    <td>
                                        <p>{{translate("Industry")}}</p>
                                    </td>
                                    <td>
                                        <p>{{$findProject->get_industry2->name}}</p>
                                    </td>
                                </tr>

                                @endif


                                {{-- @if($total_investment)
                                <tr>
                                    <td>{{translate('Total of investment needed Sum of all')}}</td>
                                    <td><strong>{{$total_investment}}</strong>
                                    </td>
                                </tr>
                                @endif --}}


                                {{-- @if ($findProject->token && ($findProject->token->fixed_amount - $tokenBuy > 0)) --}}


                                    <tr>
                                        @auth
                                            @if ($findProject->user_id != Auth::user()->id)
                                            <td colspan="2" style="border-bottom: none">
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#buyToken" class="btn btn-danger buy-now-button"
                                                    href="javascript:void(0)">{{translate('Invest Now')}}</a>
                                            </td>
                                            @endif
                                        @endauth
                                        @guest
                                            <td colspan="2" style="border-bottom: none">
                                                <a href="{{ route('login') }}" class="btn btn-danger buy-now-button">{{translate('Login to Invest')}}</a>
                                            </td>
                                        @endguest



                                    </tr>

                                    {{-- @else --}}
                                        @guest
                                            <td colspan="2" style="border-bottom: none">
                                                <a href="{{ route('login') }}" class="btn btn-danger buy-now-button">{{translate('Login to Invest')}}</a>
                                            </td>
                                        @endguest


                                {{-- @endif --}}

                                {{--
                                @if ($ownerAdress)
                                <tr>
                                    @auth
                                    <td colspan="2" style="border-bottom: none"> <a target="_blank"
                                            class="btn btn-danger buy-now-button"
                                            href="{{env('NEAR_EXPLORER_URL') ?? 'https://testnet.nearblocks.io/' }}token/{{$ownerAdress}}">{{translate('View
                                            Token Contract')}}</a></td>
                                    @endauth


                                </tr>
                                @endif
                                --}}

                            </tbody>
                        </table>



                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="alert alert-info">
            <div class=" custom-info">
                <label><strong>{{@translate('Please note')}}</strong></label>
                <span class="editableLabel" labelid="proposal_view:note_content">
                    {{translate("Investing in early stage businesses involves risks, including illiquidity, lack of
                    dividends, loss of investment and dilution, and it should be done only as part of a diversified
                    portfolio. This platform is targeted solely at investors who are sufficiently sophisticated to
                    understand these risks and make their own investment decisions. Investors are encouraged to review
                    and evaluate the investments and determine at their own discretion, the appropriateness of making
                    the particular investment. The information on this website is provided for informational purposes
                    only, but we cannot guarantee that the information is accurate or complete. We strongly encourage
                    investors to complete their own due diligence with licensed professionals, prior to making any
                    investment and will not offer any legal or tax advice")}}.
                </span>
            </div>
        </div>
    </div>
</section>

<section class="contact-admin">
    <div class="container">
        <h6>{{translate("To view the full pitch you must be a registered investor. To upgrade to an investor account,
            please email")}} </h6>
        <a href="mailto:info-desk@ribano.com" class="admin-email">info-desk@ribano.com</a>
    </div>
    @auth

    @role('investor')
    <a href="{{route('all.messages')}}/?user_name={{$findProject->user->username}}">
        <div class="chat-invs">
            <div class="background"></div>
            <svg class="chat-bubble" width="100" height="100" viewBox="0 0 100 100">
                <g class="bubble">
                    <path class="line line1" d="M 30.7873,85.113394 30.7873,46.556405 C 30.7873,41.101961
                        36.826342,35.342 40.898074,35.342 H 59.113981 C 63.73287,35.342
                        69.29995,40.103201 69.29995,46.784744" />
                    <path class="line line2" d="M 13.461999,65.039335 H 58.028684 C
                        63.483128,65.039335
                        69.243089,59.000293 69.243089,54.928561 V 45.605853 C
                        69.243089,40.986964 65.02087,35.419884 58.339327,35.419884" />
                </g>
                <circle class="circle circle1" r="1.9" cy="50.7" cx="42.5" />
                <circle class="circle circle2" cx="49.9" cy="50.7" r="1.9" />
                <circle class="circle circle3" r="1.9" cy="50.7" cx="57.3" />
            </svg>
        </div>
    </a>

    @endrole
    @endauth
</section>


@if (count($similarProject))
<section class="similar-project">
    <div class="container">
        <h4>{{translate('Similar Projects')}}</h4>
        <div class="row">
            @foreach ($similarProject as $project)
            <div class="col-md-4 wow fadeInUp col-box">
                @include('project.project_box')
            </div>
            @endforeach
        </div>
    </div>
    <div class="text-center mrt20">
        <a class="btn btn-default  btn-primary" href="{{route('searchProject')}}"><span>{{translate('View More
                Pitches')}}</span></a>
    </div>
</section>


@endif


@if ($findProject->token)
<!-- Modal -->
<div class="modal fade" id="buyToken" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{translate('Invest Now')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg viewPort="0 0 12 12" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <line x1="1" y1="11" x2="11" y2="1" stroke="black" stroke-width="2" />
                        <line x1="1" y1="1" x2="11" y2="11" stroke="black" stroke-width="2" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="token-info">
                    <h5>{{$findProject->token->name}}</h5>
                    <p style="font-size: 20px"> <span class="number-token">1</span> {{$findProject->token->token_symbol}} = <span
                            class="sum-token">{{$findProject->token->token_price ? $findProject->token->token_price :
                            1}}</span> <span>{{config('basic.currency_symbol')}}</span></p>
                    <div class="token-desc">
                        <label>{{translate('Invest')}}: <span class="from">{{$findProject->token->min_buy_amount ??
                                1}}</span> <span>{{$findProject->token->token_symbol}}</span> - <span
                                class="to">{{$findProject->token->fixed_amount - $tokenBuy}}</span>
                            <span>{{$findProject->token->token_symbol}}</span></label>

                        <div class="form-group col-md-12">
                            <div class="input-group mb-3">
                                <input min="{{$findProject->token->min_buy_amount ?? 1}}" id="max_token_input"
                                    onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"
                                    type="number" name="amount" max="{{$findProject->token->fixed_amount - $tokenBuy}}"
                                    value="" class="form-control" placeholder="0.00">


                            </div>
                            <div id="error-message" style="color: red;"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{translate('Close')}}</button>
                <a id="invest_button" href="javascript:void(0)" class="btn btn-primary">{{translate('Invest Now')}}</a>
            </div>
        </div>
    </div>
</div>
@endif



@endsection

@push('script')
<script src="{{asset('public/assets/js/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="{{asset('public/assets/js/simplePagination.js')}}"></script>
<script>
    var maxInput = 0 ;
        var minInput = 1 ;
        var buyToken = 0 ;

        @if ($findProject->token)
            maxInput = '{{$findProject->token->fixed_amount - $tokenBuy}}';
            minInput = '{{$findProject->token->min_buy_amount ?? 1}}';
        @endif



        var home = '{{url("/")}}';
        // Display a success toast, with a title
        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "2000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }

        Fancybox.bind('[data-fancybox="gallery"]', {});

        function maxInputFunc(maxInput) {
            $('input#max_token_input').on('input', function () {

                var value = $(this).val();
                let price = '{{$findProject->token->token_price ?? 1}}';
                buyToken = value = value.replace(/e|\+|\-/gi, '');
                if ((value !== '') && (value.indexOf('.') === -1)) {
                    $(this).val(Math.max(Math.min(value, maxInput), - maxInput));

                    let fn = Math.max(Math.min(value, maxInput), - maxInput);

                    $('.sum-token').text(price*(parseInt(fn)));
                    $('.number-token').text(fn);
                }
                else {
                    setTimeout(() => {
                        $('.number-token').text(value);
                        $('.sum-token').text(price*(parseInt(value)));
                    }, 1000);
                }


            });
        }
        maxInputFunc(maxInput);

        $("#invest_button").click(function () {
            var errorMessage = document.getElementById("error-message");

            if (parseFloat(buyToken) < parseFloat(minInput) || parseFloat(buyToken) > parseFloat(maxInput)) {
                errorMessage.textContent = "Value must be in the range from "+minInput+" to "+maxInput+".";
                return;
            } else {
                errorMessage.textContent = "";
            }
            if($.trim($('#max_token_input').val()) == '') {
                toastr.warning('Token number can not be left blank');
                return;
            }
            $.ajax({
                type: 'post',
                url: "{{ route('checkNumberToken') }}",
                data: {
                    'project_id' : "{{$findProject->id}}",
                    '_token' : $('meta[name="csrf-token"]').attr('content'),

                },
                beforeSend: function(){
                    toastr.success('Sending data...');
                },
                complete: function(){

                },
                success:function(data){
                    if(data.code == 200) {
                      // console.log(data);
                        maxInputFunc(data.tokenExist);
                        if($('#max_token_input').val() > data.tokenExist) {
                            //alert('The number of tokens purchased is greater than the remaining tokens');
                            toastr.warning('The number of tokens purchased is greater than the remaining tokens', 'Warning');
                            $('.token-desc span.to').val(data.tokenExist);
                            $('#max_token_input').val('');
                        }
                        else {
                            // /paymoney/{slug}/{price}
                            location.replace(home + '/paymoney/' + data.slug + '/' + $('#max_token_input').val() + '/{{$client}}' + '/{{$secret}}') ;
                        }

                    }
                    else {
                        toastr.error('Error get token', 'Error')

                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    toastr.error('Error get token ', 'Error')
                }

            });
        });

        //galleries
        function ajaxCall($page = 1, $updatePagination = true) {
			$.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '{{route("imagePagination")}}',
		        data: {
		            'page' : $page,
		            'id' : {{$findProject->id ?? 0}},
                    "_token": "{{ csrf_token() }}",
		        },
				beforeSend: function(){
					$('.loading-spin').html('<div class="loader">Loading...</div>');
			    },
			    complete: function(){
					$('.loading-spin').html('');
			    },
		        success: function(data) {

		           $('.gallery-row').html(data.view);

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
					$('html, body').animate({scrollTop: $('#tab-7').offset().top - 200}, 500);
					console.log(pageNumber);
	                ajaxCall(pageNumber, false);



	            }
	        });
	    }
        pagination({{$totalItem}}, true);

        // video
        function ajaxVideoCall($page = 1, $updatePagination = true) {
			$.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '{{route("videoPagination")}}',
		        data: {
		            'page' : $page,
		            'id' : {{$findProject->id ?? 0}},
		            "_token": "{{ csrf_token() }}",
		        },
				beforeSend: function(){
					$('.loading-spin').html('<div class="loader">Loading...</div>');
			    },
			    complete: function(){
					$('.loading-spin').html('');
			    },
		        success: function(data) {

		           $('#video-wrap').html(data.view);

		            if($updatePagination) {
		                if(data.total > 12) {
			                // append pagenation
			                $('.theme-video-nav').remove();
			                $('#pagination-video').append('<nav class="theme-video-nav"></nav>');
							pagination(data.total);
			            }
			            else {
			                $('#pagination-video').html('');
			            }
		            }


		        }
		    });
		}
	    function videoPagination($total, $updatePagination = true){
	        $('.theme-video-nav').pagination({
	            items: $total,
	            itemsOnPage: 12,
	            listStyle: 'pagination',
	            cssStyle: 'light-theme',

	            onPageClick: function(pageNumber) {
					$('html, body').animate({scrollTop: $('#tab-6').offset().top - 200}, 500);
					console.log(pageNumber);
	                ajaxVideoCall(pageNumber, false);



	            }
	        });
	    }
        videoPagination({{$totalVideoItem}}, true);

        let videoClick = false;
        let galleryClick = false;

        function loadVideoSpeed(event) {
            if (!videoClick)  {
                $.ajax({
    		        type: "POST",
    				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    		        url: '{{route("ajaxLoadSpeed")}}',
    		        data: {
    		            'page' : 1,
    		            'project_id' : {{$findProject->id ?? 0}},
    		            "_token": "{{ csrf_token() }}",
    		            'type' : 'video'
    		        },
    				beforeSend: function(){
    					//$('.loading-spin').html('<div class="loader">Loading...</div>');
    			    },
    			    complete: function(){
    					//$('.loading-spin').html('');
    			    },
    		        success: function(data) {

                        videoClick = true;
        		        $('#load-video-wrap').html(data.html);
        		        if( $('#pagination-video').length )  {
                            $('#pagination-video').show();
                        }



    		        }
    		    });
            }

        }
        function loadImagesSpeed(event) {
            if (!galleryClick)  {
                $.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '{{route("ajaxLoadSpeed")}}',
		        data: {
		            'page' : 1,
		            'project_id' : {{$findProject->id ?? 0}},
		            "_token": "{{ csrf_token() }}",
		        },
				beforeSend: function(){

			    },
			    complete: function(){

			    },
		        success: function(data) {

                    galleryClick = true;
    		        $('#load-gallery-wrap').html(data.html);
    		        if( $('#pagination-wrap').length )  {
                        $('#pagination-wrap').show();
                    }



		        }
		    });

            }

        }

</script>
@endpush
