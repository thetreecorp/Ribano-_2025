@if (count($data))
    @foreach ($data as $user)
        @include('fundraising.investor_box' , compact('user'))
    @endforeach
@else
    <div class="w-full md:max-w-md mx-auto rounded-md flex flex-col py-6 px-4">
        <p class="no-result">{{translate('No investor found')}}</p>
    </div> 
@endif