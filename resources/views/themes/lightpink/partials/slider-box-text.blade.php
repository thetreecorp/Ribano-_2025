<div data-swiper-parallax="400" class="slide-text">
    @if (isset($desc) && $desc)
        <div>{!! @$data->description->description !!}</div>
        @else
            <p>{{@translate("Partnership with investors is not just about securing funding, it's about building trust, aligning
            goals, and working together to achieve success. The right investors can bring valuable expertise, networks, and
            resources to the table, and can help take your business to new heights", null, false)}}.</p>
        
    @endif
    

    <div class="d-flex justify-content-center mt-4">


        <div class="p-2 bd-highlight text-center">

            <div style="font-weight: bolder; font-size: 28px; color: white">{{translate("I'm looking to", null, false)}}...</div>

        </div>


        <div class="p-2 bd-highlight text-center select-slider">

            <select class="form-select form-select-lg">
                <option selected="" value="">{{translate("Fundraise")}}</option>
                <option value="">{{translate("Invest")}}</option>
            </select>

        </div>

    </div>
    @if (Auth::guest())
        <a href="{{url('/register')}}" class="btn btn-success mt-4 text-white-hover">{{translate("Get Started")}}</a>
    @else
        <a class="btn btn-success mt-4 text-white-hover" href="{{ route('user.home') }}">{{translate("Get Started")}}</a>
    @endif
    
</div>