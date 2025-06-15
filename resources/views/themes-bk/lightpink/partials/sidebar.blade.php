
@inject('common', 'App\Http\Controllers\ProjectController')
<div id="sidebar" class="">
    <div class="sidebar-top">
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}"
                 alt="{{config('basic.site_title')}}">
        </a>
        <button
            class="sidebar-toggler d-md-none"
            onclick="toggleSideMenu()"
        >
            <i class="fal fa-times"></i>
        </button>
    </div>
    @php
        $user = \Illuminate\Support\Facades\Auth::user();
        $user_rankings = \App\Models\Ranking::where('rank_lavel', $user->last_lavel)->first();
    @endphp

    @if($user->last_lavel != null && $user_rankings)
        <div class="level-box">
            <h4>@lang(@$user->rank->rank_lavel)</h4>
            <p>@lang(@$user->rank->rank_name)</p>
            <img src="{{ getFile(config('location.rank.path').@$user->rank->rank_icon) }}" alt="" class="level-badge"/>
        </div>
    @endif

    <div class="wallet-wrapper">
        <div class="wallet-box d-none d-lg-block">
            <h4>@lang('Account Balance')</h4>
            <h5> @lang('Main Balance') <span>{{ $basic->currency_symbol }}{{ @$user->balance }}</span></h5>
            <h5 class="mb-0"> @lang('Interest Balance') <span>{{ $basic->currency_symbol }}{{ @$user->interest_balance }}</span></h5>
            <span class="tag">{{ $basic->currency }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <a class="btn-custom" href="{{ route('user.addFund') }}"><i class="fal fa-wallet"></i> @lang('Deposit')</a>
            <a class="btn-custom" href="{{ route('plan') }}"><i class="fal fa-usd-circle"></i> @lang('Invest')</a>
        </div>
    </div>
    <nav class="sidebar-nav">
        <ul class="main tabScroll" id="sidebarnav">
            <li>
                <a class="{{menuActive('user.home')}}" href="{{route('user.home')}}"> <i class="fal fa-border-all"></i> 
                    {{trans("Dashboard")}}</a>
            </li>
            <hr></hr>
            <li>
                <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fas fa-cubes text-success"></i>
                    <span class="hide-menu">{{trans("Pitches")}}</span>
                </a>
            </li>
    
            <li class="sidebar-item">
                {{-- <a href="{{route('admin.typeUsers', 'investors')}}" class="sidebar-link">
                    <span class="hide-menu">{{trans("My Pitches")}}</span>
                </a> --}}
                <a href="{{route('user.projects')}}" class="sidebar-link {{menuActive(['user.projects'])}}">
                    <i class="fal fa-layer-group"></i> {{trans("My Pitches")}}
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{route('user.pending.projects')}}" class="sidebar-link {{menuActive(['user.pending.projects'])}}">
                    <span class="hide-menu">{{trans("Pending Pitches")}} </span>
                </a>
            </li>
            <li class="sidebar-item">
                <a target="_blank" href="{{ route('user.createProject') }}" class="sidebar-link">
                    <span class="hide-menu">{{trans("Add New Pitch")}} </span>
                </a>
            </li>

            <hr></hr>
            <li>
                <a  class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fas fa-credit-card text-warning"></i>
                    <span class="hide-menu">{{trans("Investors")}}</span>
                </a>
            </li>
    
            <li>
                <a target="_blank" href="{{route('founder.myInvestors')}}" class="sidebar-link">
                    <span class="hide-menu">{{trans("My Investors")}}</span>
                </a>
            </li>
            <li>
                <a target="_blank" href="{{route('investorSearch')}}" class="sidebar-link">
                    <span class="hide-menu">{{trans("Search Investors")}} </span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-link">
                    <span class="hide-menu">{{trans("Investments in")}} </span>
                </a>
            </li>
            <hr></hr>
            {{-- <li>
                <a href="{{route('plan')}}" class="sidebar-link {{menuActive(['plan'])}}">
                    <i class="fal fa-layer-group"></i> @lang('Plan')
                </a>
            </li> --}}
            <li>
                <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fas fa-exchange-alt text-warning"></i>
                    <span class="hide-menu">{{trans("My Investments & Money")}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('user.invest-history')}}" class="sidebar-link {{menuActive(['user.invest-history'])}}">
                    <i class="fal fa-file-medical-alt"></i> {{trans('Invest history')}}
                </a>
            </li>
            <li>
                <a href="{{route('user.addFund')}}" class="sidebar-link {{menuActive(['user.addFund', 'user.addFund.confirm'])}}">
                    <i class="far fa-funnel-dollar"></i> {{trans('Add Fund')}}
                </a>
            </li>
            <li>
                <a href="{{route('user.fund-history')}}" class="sidebar-link {{menuActive(['user.fund-history', 'user.fund-history.search'])}}">
                    <i class="far fa-search-dollar"></i> {{trans('Fund History')}}
                </a>
            </li>
            <li >
                <a href="{{route('user.money-transfer')}}" class="sidebar-link {{menuActive(['user.money-transfer'])}}">
                    <i class="far fa-money-check-alt"></i> {{trans('Transfer')}}
                </a>
            </li>
            <li>
                <a href="{{route('user.transaction')}}" class="sidebar-link {{menuActive(['user.transaction', 'user.transaction.search'])}}">
                    <i class="far fa-sack-dollar"></i> {{trans('Transactions history')}}
                </a>
            </li>
            <li>
                <a href="{{route('user.payout.money')}}" class="sidebar-link {{menuActive(['user.payout.money','user.payout.preview'])}}">
                    <i class="fal fa-hand-holding-usd"></i>{{trans('Payout')}}
                </a>
            </li>
            <li>
                <a href="{{route('user.payout.history')}}" class="sidebar-link {{menuActive(['user.payout.history','user.payout.history.search'])}}">
                    <i class="far fa-badge-dollar"></i>{{trans('Payout history')}}
                </a>
            </li>
            <hr></hr>
            <li>
                <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fas fa-ticket-alt text-cyan"></i>
                    <span class="hide-menu">{{trans("Communications")}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.typeUsers', 'investors')}}" class="sidebar-link">
                    <span class="hide-menu">{{trans("My Inbox")}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('user.ticket.list')}}" class="sidebar-link {{menuActive(['user.ticket.list', 'user.ticket.create', 'user.ticket.view'])}}">
                    <i class="fal fa-user-headset"></i> @lang('support ticket')
                </a>
            </li>
            
            <hr></hr>
            
            {{-- @if(Auth::user()->hasRole('entrepreneur'))
                <li class="sidebar-item {{ menuActive(['user.projects']) }}">
                    <a href="{{route('user.projects')}}" class="sidebar-link {{menuActive(['user.projects'])}}">
                        <i class="fal fa-layer-group"></i> @lang('Projects')
                    </a>
                </li>
            @endif --}}
            
            
            <li>
                <a href="{{route('user.referral')}}" class="sidebar-link {{menuActive(['user.referral'])}}">
                    <i class="fal fa-retweet-alt"></i> @lang('my referral')
                </a>
            </li>
            <li>
                <a href="{{route('user.referral.bonus')}}" class="sidebar-link {{menuActive(['user.referral.bonus', 'user.referral.bonus.search'])}}">
                    <i class="fal fa-box-usd"></i> @lang('referral bonus')
                </a>
            </li>
            <li>
                <a href="{{route('user.badges')}}" class="sidebar-link {{menuActive(['user.badges'])}}">
                    <i class="fal fa-badge"></i> @lang('Badges')
                </a>
            </li>
            <li>
                <a href="{{route('user.profile')}}" class="sidebar-link {{menuActive(['user.profile'])}}">
                    <i class="fal fa-user"></i> @lang('profile settings')
                </a>
            </li>
            
        </ul>
    </nav>
    
</div>
