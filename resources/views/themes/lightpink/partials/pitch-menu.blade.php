<div class="nav--secondary">
    <div class="o-wrap">
        <div class="u-pull-left">
            <ul class="nav__items">
                @if (Auth::check())
                    <li class="nav__item {{Request::routeIs('myList') ? 'active' : ''}}"><a class="nav__link-accent"
                        href="{{route('myList')}}">{{translate("My Portfolio")}}</a></li>
                @endif
                
                <li class="nav__item {{Request::routeIs('founder.fundDashboard') ? 'active' : ''}}"><a class="nav__link-accent"
                        href="{{route('founder.fundDashboard')}}">{{translate("My Pitches")}}</a></li>
                <li class="nav__item {{Request::routeIs('founder.myInvestors') ? 'active' : ''}}"><a
                        class="c-nav__link-accent"
                        href="{{route('founder.myInvestors')}}">{{translate("My Investors")}}</a>
                </li>
                <li class="nav__item {{Request::routeIs('investorSearch') ? 'active' : ''}}"><a class="nav__link-accent"
                        href="{{route('investorSearch')}}">{{translate("Investor Search")}}</a></li>
                {{-- <li class="nav__item {{Request::routeIs('newsFeed') ? 'active' : ''}} "><a class="nav__link-accent"
                        href="{{route('newsFeed')}}">{{translate("Newsfeed")}}</a></li> --}}
            </ul>
        </div>
    </div>
</div>