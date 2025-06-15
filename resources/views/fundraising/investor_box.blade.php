<div class="w-full md:max-w-md mx-auto rounded-md flex flex-col py-6 px-4">
    <div class="text-center bg-white border-2 border-blue-50 rounded-xl h-full flex flex-col">
        <div class="w-full h-28 py-10 bg-gray-1500 bg-cover bg-center bg-no-repeat rounded-t-xl relative mb-14">
            <div class="absolute w-full flex flex-col items-center"><span class="text-white rounded-full align-middle
        text-center items-center justify-center w-28 h-28 inline-flex bg-avatar">
            {{strtoupper(substr($user->firstname, 0, 1))}}{{strtoupper(substr($user->lastname, 0, 1))}} 
        </span>
            <span class="relative -top-5 bg-blue-500 py-2 px-6 text-white rounded-full font-bold text-sm">${{getTotalInvest($user->id)}}</span>
            </div>
            
        </div>
        <div class="p-6 mt-4 flex flex-col h-full">
            <p class="text-base text-ain-socials-gray flex items-center justify-center"><svg
                    class="inline-block fill-current text-blue-500 w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5 9C5 5.13 8.13 2 12 2C15.87 2 19 5.13 19 9C19 14.25 12 22 12 22C12 22 5 14.25 5 9ZM9.5 9C9.5 10.38 10.62 11.5 12 11.5C13.38 11.5 14.5 10.38 14.5 9C14.5 7.62 13.38 6.5 12 6.5C10.62 6.5 9.5 7.62 9.5 9Z">
                    </path>
                </svg>{{$user->address ? $user->address : 'N/A'}}</p>
            <p class="text-sm text-ain-socials-gray pt-4 mb-4 flex-1">{{$user->about}}</p>
            <h4 class="text-lg font-medium title-font mb-2 text-gray-900">{{translate("Areas of Expertise")}}</h4>
            <p class="text-sm capitalize flex-1">{{$user->my_area}}</p><br>
            <div class="flex flex-wrap items-center gap-2 justify-center mt-auto">
                @if (Auth::check())
                    <div class="has-tooltip">
                        <form method="post" action="{{route('addInvestorToList')}}">
                            <span data-type="shortlist" class="shortlist-investor" target-user="{{$user->id}}" type="button" class=""><i
                                    class="fa-solid fa-star"></i></span>
                        </form>
                        
                    </div>
                @endif
                
                <a href="{{route('viewInvestor', $user->id)}}" target="_blank"
                    class=" bg-transparent py-2 px-3 text-gray-400 border border-gray-400 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-200 text-sm rounded-md whitespace-nowrap ">
                    {{translate("More Details")}}</a>
            </div>
        </div>
    </div>
</div>