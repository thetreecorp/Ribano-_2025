@if(isset($templates['how-it-work'][0]) && $howItWork = $templates['how-it-work'][0])
    <section class="how_it_work_area shape3">
        <div class="container">
            <div class="row">
                <div class="section_header mb-50 text-center">
                    <h1>@lang('How It Works?')</h1>
                    <h5>@lang('Investment options')</h5>
                </div>
                <div class="how_it_work">
                    <p>There are two ways in which an investor can invest:</p>
                    <ul class="disc">
                        <li>Buy shares in a specific project on the platform</li>
                        <li>Invest in Ribano's portfolio that distributes investments according to its plan</li>
                    </ul>
                    <h3>@lang('Option One')</h3>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-7 order-2 order-lg-1">
                    <div class="seciton_right cmn_scroll">
                        @if(isset($contentDetails['how-it-work']))
                            @foreach($contentDetails['how-it-work'] as $k =>  $item)
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">{{++$k}}</span>
                                    <div class="text_area">
                                        <h5>@lang(@$item->description->title)</h5>
                                        <p>@lang(@$item->description->short_description)</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 flex-column flex-sm-row">
                    <div class="section_left">
                        <div class="image_area">
                            <img
                                src="{{ asset($themeTrue.'img/how_it_work/team work brainstorming vector presentation_5204715.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- section 2 -->
        <div class="container">
            <div class="row">
               
                <div class="how_it_work">
                   
                    <h3>Option Two</h3>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-7 order-2 order-lg-1">
                    <div class="seciton_right cmn_scroll">
                                <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">1</span>
                                    <div class="text_area">
                                        <p>The investor invests in a portfolio managed by Ribano</p>
                                    </div>
                                </div>
                                    <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">2</span>
                                    <div class="text_area">
                                        <p>After reading all the details, the investor determines the amount of investment he wants to invest</p>
                                    </div>
                                </div>
                                                            <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">3</span>
                                    <div class="text_area">
                                        <p>The investor pays the value of the contribution and the investment amount through the payment platform and through various payment methods</p>
                                    </div>
                                </div>
                                                            <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">4</span>
                                    <div class="text_area">
                                        <h5>Enjoy Super Results</h5>
                                        <p>The wallet has two NFT glands that represent the total projects under it and secures the investor’s share through blockchain technology and takes its own NFT or token</p>
                                    </div>
                                </div>
                                                            <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">5</span>
                                    <div class="text_area">
                                        <h5>Register &amp; Log in</h5>
                                        <p>Ribano manages the investment process and directs investment to various projects to achieve maximum investment safety and reduce risk.</p>
                                    </div>
                                </div>
                                                            <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">6</span>
                                    <div class="text_area">
                                        <h5>6</h5>
                                        <p>Ribano gives powers to the investor to monitor the administrative systems of the projects that have been invested in</p>
                                    </div>
                                </div>
                                                            <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">7</span>
                                    <div class="text_area">
                                        <h5>7</h5>
                                        <p>Ribano will act as the company's financial manager to ensure rational investment and spending operations</p>
                                    </div>
                                </div>
                                                            <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">8</span>
                                    <div class="text_area">
                                        <h5>8</h5>
                                        <p>Investment funds are gradually disbursed from Ribano's account to the company's account, according to the needs of the company's operations and based on spending requests in the administrative system.</p>
                                    </div>
                                </div>
                                                            <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                                    <span class="number">9</span>
                                    <div class="text_area">
                                        <h5>9</h5>
                                        <p>At the end of the fiscal year, profits are calculated and placed in the investor's portfolio in Ribano</p>
                                    </div>
                                </div>
                                                                        </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 flex-column flex-sm-row">
                    <div class="section_left">
                        <div class="image_area">
                            <img src="http://localhost/investment_portal/assets/themes/lightpink/img/how_it_work/team work brainstorming vector presentation_5204715.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container why-invest">
            <div class="row">
                <div class="section_header mb-50 text-center">
                    <h1>@lang('Why you invest with us?')</h1>
                </div>
                <div class="how_it_work">
                    <div class="why-item">
                        <h4>Transparency</h4>
                        <p> Everything is clear in front of you. We do not hide anything. Every penny spent shown in our ERP system
                            Safety</p>
                    </div>
                    <div class="why-item">
                        <h4>Safety</h4>
                        <p>We make every efforts possible to make your investment secured. Please read steps to know what we do exactly to make safety margin is maximum</p>
                    </div>
                    <div class="why-item">
                        <h4>Partnership</h4>
                        <p> We believe our investor and founders are complete partners. That is why we are very caring about verifications and selection of them very much care</p>
                    </div>
                    
                   
                   
                    
                </div>
            </div>
            
        </div>

    </section>
@endif

<style>
    .disc {
        list-style: disc;
        padding-left: 30px;
    }
    .how_it_work, .why-invest {
        padding-top: 30px;
    }
</style>