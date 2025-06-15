<section class="how_it_work_area shape3">
    <div class="container">
        <div class="row_it_work">
            <div class="section_header mb-50 text-center">
                <h1>@lang('How It Works?')</h1>
                <h5>@lang('Investment options')</h5>

            </div>
            <div class="row">
                <div class="why-item col-lg-4 col-md-4 text-center">
                    <img src="{{asset('assets/images')}}/register.svg"
                        style="width:100px; margin-bottom: 10px">
                    <p>@lang('There are two ways in which an investor can invest')</p>
                </div>
                <div class="why-item col-lg-4 col-md-4 text-center">
                    <img src="{{asset('/assets/images')}}/connect.svg"
                        style="width:100px; margin-bottom: 10px">
                    <p>@lang('Buy shares in a specific project on the platform')</p>
                </div>
                <div class="why-item col-lg-4 col-md-4 text-center">
                    <img src="{{asset('/assets/images')}}/earn.svg"
                        style="width:100px; margin-bottom: 10px">
                    <p>@lang('Invest in Ribano is portfolio that distributes investments according to its plan')</p>
                </div>
            </div>
            {{-- <div class="how_it_work">
                <p>@lang('There are two ways in which an investor can invest'):</p>
                <ul class="disc">
                    <li>@lang('Buy shares in a specific project on the platform')</li>
                    <li>@lang('Invest in Ribano is portfolio that distributes investments according to its plan')</li>
                </ul>
            </div> --}}
        </div>
    </div>
    <div class="wrapper work-tab">
        <div class="tab-wrapper">
            <ul class="tabs">
                <li class="tab-link active" data-tab="1"><h4>@lang('Option One')</h4></li>
                <li class="tab-link" data-tab="2"><h4>@lang('Option Two')</h4></li>
            </ul>
        </div>

        <div class="content-wrapper">
            <div id="tab-1" class="tab-content active">
                <div class="container">
                    <?php // var_dump($templates['how-it-work'][0]) ?>
                    <div class="row align-items-center">
                        <div class="col-lg-7 order-2 order-lg-1">
                            <div class="seciton_right cmn_scroll">
                                @if(isset($contentDetails['how-it-work'])) @foreach($contentDetails['how-it-work'] as $k => $item)
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">{{++$k}}</span>
                                    <div class="text_area">
                                        <h5>@lang(@$item->description->title)</h5>
                                        <p>@lang(@$item->description->short_description)</p>

                                    </div>
                                </div>
                                @endforeach @endif
                            </div>
                        </div>
                        <div class="col-lg-5 order-1 order-lg-2 flex-column flex-sm-row">
                            <div class="section_left">
                                <div class="image_area">
                                    @if($how_it_work->description->image)
                                        <img src="{{ url("/assets/uploads/content/") . "/" .$how_it_work->description->image }}" alt="how it work"/>
                                    @else
                                        <img alt="how it work" src="{{ asset($themeTrue.'img/how_it_work/team work brainstorming vector presentation_5204715.png') }}" />
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php //dd(url("/assets/uploads/content/") .$how_it_work->description->image); ?>

            <div id="tab-2" class="tab-content">
                <div class="container">

                    <div class="row align-items-center">
                        <div class="col-lg-7 order-2 order-lg-1">
                            <div class="seciton_right cmn_scroll">
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">1</span>
                                    <div class="text_area">
                                        <p>@lang('The investor invests in a portfolio managed by Ribano')</p>
                                    </div>
                                </div>
                                    <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">2</span>
                                    <div class="text_area">
                                        <p>@lang('After reading all the details, the investor determines the amount of investment he wants to invest')</p>
                                    </div>
                                </div>
                                    <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">3</span>
                                    <div class="text_area">
                                        <p>@lang('The investor pays the value of the contribution and the investment amount through the payment platform and through various payment methods')</p>
                                    </div>
                                </div>
                                    <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">4</span>
                                    <div class="text_area">
                                        <h5>@lang('Enjoy Super Results')</h5>
                                        <p>@lang('The wallet has two NFT glands that represent the total projects under it and secures the investor’s share through blockchain technology and takes its own NFT or token')</p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">5</span>
                                    <div class="text_area">
                                        <h5>@lang('Register &amp; Log in')</h5>
                                        <p>@lang('Ribano manages the investment process and directs investment to various projects to achieve maximum investment safety and reduce risk').</p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">6</span>
                                    <div class="text_area">
                                        <h5>6</h5>
                                        <p>@lang('Ribano gives powers to the investor to monitor the administrative systems of the projects that have been invested in')</p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">7</span>
                                    <div class="text_area">
                                        <h5>7</h5>
                                        <p>@lang("Ribano will act as the company's financial manager to ensure rational investment and spending operations")</p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">8</span>
                                    <div class="text_area">
                                        <h5>8</h5>
                                        <p>@lang("Investment funds are gradually disbursed from Ribano's account to the company's account, according to the needs of the company's operations and based on spending requests in the administrative system").</p>
                                    </div>
                                </div>
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">9</span>
                                    <div class="text_area">
                                        <h5>9</h5>
                                        <p>@lang("At the end of the fiscal year, profits are calculated and placed in the investor's portfolio in Ribano")</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 order-1 order-lg-2 flex-column flex-sm-row">
                            <div class="section_left">
                                <div class="image_area">
                                    @if($how_it_work->image_2_option)
                                        <img src="{{ url("/assets/uploads/content/") . "/" .$how_it_work->image_2_option }}" alt="how it work"/>
                                    @else
                                    <img alt="how it work"
                                        src="{{ asset($themeTrue.'img/how_it_work/team work brainstorming vector presentation_5204715.png') }}" />
                                    @endif
                                    {{-- <img src="http://localhost/investment_portal/assets/themes/lightpink/img/how_it_work/team work brainstorming vector presentation_5204715.png"> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
