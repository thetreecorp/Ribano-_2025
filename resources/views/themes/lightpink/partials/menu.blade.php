<li class="nav-item">
    <a class="nav-link" href="{{ route('home') }}"> {{@translate('Home')}}</a>
</li>
<li class="nav-item dropdown">
    {{-- <a class="nav-link {{Request::routeIs('contact') ? 'active' : ''}}"
        href="{{route('contact')}}">@translate('Invest')</a> --}}
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
        data-bs-auto-close="outside">{{@translate('Invest')}}
        <i class="fas fa-comments-dollar"></i>
    </a>
    <ul class="dropdown-menu shadow">
        <li>
            <a class="dropdown-item{{Request::routeIs('investmentStrategies') ? ' active' : ''}}"
                href="{{route('investmentStrategies')}}">{{@translate('Investment Strategies')}}</a>
        </li>
        <li>
            <a class="dropdown-item{{Request::routeIs('investMethod') ? ' active' : ''}}"
                href="{{route('investMethod')}}">{{@translate('Invest Method')}}</a>
        </li>
        <li>
            <a class="dropdown-item{{Request::routeIs('investorTerms') ? ' active' : ''}}"
                href="{{route('investorTerms')}}">{{@translate('Investor Terms')}}</a>
        </li>
        {{-- <li>
            <a class="dropdown-item {{Request::routeIs('contact') ? ' active' : ''}}"
                href="#">{{@translate('Explore Projects')}}</a>
        </li> --}}
        <li>
            <a class="dropdown-item {{Request::routeIs('searchProject') ? 'active' : ''}}"
                href="{{route('searchProject')}}">{{@translate('Search Projects')}}</a>
        </li>

    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
        data-bs-auto-close="outside">{{@translate('Fundraising')}}
        <i class="fas fa-hand-holding-usd"></i>
    </a>
    <ul class="dropdown-menu shadow">
        @role('founder')
            <li>
                <a class="dropdown-item {{Request::routeIs('fundDashboard') ? 'active' : ''}}"
                    href="{{route('founder.fundDashboard')}}">{{@translate('My Pitches')}}</a>
            </li>
            <li>
                <a class="dropdown-item {{Request::routeIs('createProject') ? 'active' : ''}}"
                    href="{{route('founder.myInvestors')}}">{{@translate('My Investors')}}</a>
            </li>
            <li>
                <a class="dropdown-item {{Request::routeIs('contact') ? 'active' : ''}}"
                    href="{{route('investorSearch')}}">{{@translate('Investor Search')}}</a>
            </li>
        {{-- <li>
            <a class="dropdown-item {{Request::routeIs('createProject') ? 'active' : ''}}"
                href="{{route('user.createProject')}}">{{@translate('Newsfeed')}}</a>
        </li> --}}

        @else
            <li>
                <a class="dropdown-item {{Request::routeIs('contact') ? 'active' : ''}}"
                    href="#">{{@translate('How to apply')}}</a>
            </li>
            <li>
                <a class="dropdown-item {{Request::routeIs('createProject') ? 'active' : ''}}"
                    href="{{route('user.createProject')}}">{{@translate('Add a pitch')}}</a>
            </li>
        @endrole


    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
        data-bs-auto-close="outside">{{@translate('Help')}}
        <i class="fas fa-info-circle"></i>
    </a>
    <ul class="dropdown-menu shadow ">
        <li>
            <a class="dropdown-item {{Request::routeIs('contact') ? 'active' : ''}}"
                href="#">{{@translate('How it works')}}</a>
        </li>
        {{-- <li>
            <a class="dropdown-item {{Request::routeIs('entrepreneursFaqsPage') ? 'active' : ''}}"
                href="{{route('entrepreneursFaqsPage')}}">{{@translate('Fundraise FAQ')}}</a>
        </li> --}}
        <li>
            <a class="dropdown-item {{Request::routeIs('faqsPage') ? 'active' : ''}}"
                href="{{route('faqsPage')}}">{{@translate('FAQ Page')}}</a>
        </li>
        <li>
            <a class="dropdown-item {{Request::routeIs('privacy') ? 'active' : ''}}"
                href="{{route('privacy')}}">{{@translate('Privacy Policy')}}</a>
        </li>
        <li>
            <a class="dropdown-item {{Request::routeIs('termPolicies') ? 'active' : ''}}"
                href="{{route('termPolicies')}}">{{@translate('Term Policies')}}</a>
        </li>
        <li>
            <a class="dropdown-item {{Request::routeIs('aboutUs') ? 'active' : ''}}"
                href="{{route('aboutUs')}}">{{@translate('About Us')}}</a>
        </li>
        

    </ul>
</li>
@guest
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}"> {{@translate('Sign in')}}</a>
     
    </li>
    <li class="nav-item">
        <a class="login_btn" href="{{ route('register') }}"> {{@translate('Sign up')}}</a>
    </li>
@else
    <li class="nav-item">
        <a class="" href="{{ route('user.home') }}"> {{@translate('Dashboard')}}</a>
    </li>
@endguest

