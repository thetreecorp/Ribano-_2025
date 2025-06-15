<div class="chat-box-wrap h-100">
    <div class="attached-top bg-white border-bottom chat-header d-flex justify-content-between align-items-center p-3 shadow-sm">
        <div class="media align-items-center">
            @if ($chat_thread->sender_user_id ==  Auth::user()->id)
                <span class="avatar avatar-sm mr-3 flex-shrink-0">
                    @if ($chat_thread->receiver->image != null)
                        <img src="{{ getFile(config('location.user.path').$chat_thread->receiver->image) }}">
                    @else
                        <img src="{{ url('assets/admin/images/default.png') }}">
                    @endif
                </span>
                <div class="media-body">
                    <h6 class="fs-15 mb-1">
                        {{ $chat_thread->receiver->firstname }} {{ $chat_thread->receiver->lastname }}
                        @if(Cache::has('user-is-online-' . $chat_thread->receiver->id))
                            <span class="badge badge-dot badge-success badge-circle"></span>
                        @else
                            <span class="badge badge-dot badge-secondary badge-circle"></span>
                        @endif
                    </h6>
                </div>
            @else
                <span class="avatar avatar-sm mr-3 flex-shrink-0">
                    @if ($chat_thread->sender->image != null)
                        <img src="{{ getFile(config('location.user.path').$chat_thread->sender->image) }}">
                    @else
                        <img src="{{ url('assets/admin/images/default.png') }}">
                    @endif
                </span>
                <div class="media-body">
                    <h6 class="fs-15 mb-1">
                        {{ $chat_thread->sender->firstname }} {{ $chat_thread->sender->lastname }}
                        @if(Cache::has('user-is-online-' . $chat_thread->sender->id))
                            <span class="badge badge-dot badge-success badge-circle"></span>
                        @else
                            <span class="badge badge-dot badge-secondary badge-circle"></span>
                        @endif
                    </h6>
                </div>
                
            @endif
           
            {{-- @if (isInvestor())
                <span class="avatar avatar-sm mr-3 flex-shrink-0">
                    @if ($chat_thread->receiver->image != null)
                        <img src="{{ getFile(config('location.user.path').$chat_thread->receiver->image) }}">
                    @else
                        <img src="{{ url('assets/admin/images/default.png') }}">
                    @endif
                </span>
                <div class="media-body">
                    <h6 class="fs-15 mb-1">
                        {{ $chat_thread->receiver->firstname }} {{ $chat_thread->receiver->lastname }}
                        @if(Cache::has('user-is-online-' . $chat_thread->receiver->id))
                            <span class="badge badge-dot badge-success badge-circle"></span>
                        @else
                            <span class="badge badge-dot badge-secondary badge-circle"></span>
                        @endif
                    </h6>
                </div>
            @else
                <span class="avatar avatar-sm mr-3 flex-shrink-0">
                    @if ($chat_thread->sender->image != null)
                    <img src="{{ getFile(config('location.user.path').$chat_thread->sender->image) }}">
                    @else
                        <img src="{{ url('assets/admin/images/default.png') }}">
                    @endif
                </span>
                <div class="media-body">
                    <h6 class="fs-15 mb-1">
                        {{ $chat_thread->sender->firstname }}  {{ $chat_thread->sender->lastname }}
                        @if(Cache::has('user-is-online-' . $chat_thread->sender->id))
                            <span class="badge badge-dot badge-success badge-circle"></span>
                        @else
                            <span class="badge badge-dot badge-secondary badge-circle"></span>
                        @endif
                    </h6>
                </div>
            @endif --}}
        </div>
        <div class="d-flex align-items-center">
            <button class="aiz-mobile-toggler d-lg-none aiz-all-chat-toggler mr-2" data-toggle="class-toggle" data-target=".chat-user-list-wrap">
                <span></span>
            </button>
            <button class="btn btn-icon btn-circle btn-soft-primary chat-info" data-toggle="class-toggle" data-target=".chat-info-wrap"><i class="las la-info-circle"></i></button>
        </div>
    </div>
    <div class="chat-list-wrap c-scrollbar-light scroll-to-btm" id="parentDiv">
        @if (count($chats) > 0)
            <div class="chat-coversation-load text-center">
                <button class="btn btn-link load-more-btn" data-first="{{ $chats->last()->id }}" type="button">{{ translate('Load More') }}</button>
            </div>
        @endif
        <div class="chat-list px-4" id="chat-messages">
            @include('frontend.default.partials.chat-messages-part',['chats' => $chats])
        </div>
    </div>
    <div class="chat-footer border-top p-3 attached-bottom bg-white">
        <form id="send-mesaage">
            <div class="input-group">
                <input type="hidden" id="chat_thread_id" name="chat_thread_id" value="{{ $chat_thread->id }}">
                <input type="text" class="form-control" name="message" id="message" placeholder="{{ translate('Your Message..') }}" autocomplete="off">
                <input type="hidden" class="" name="attachment" id="attachment">
                <div class="input-group-append">
                    <button class="btn btn-circle btn-icon chat-attachment" type="button">
                        <i class="las la-paperclip"></i>
                    </button>
                    <button class="btn btn-primary btn-circle btn-icon" onclick="send_reply()" type="button">
                        <i class="las la-paper-plane"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="chat-info-wrap">
        <div class="overlay dark c-pointer" data-toggle="class-toggle" data-target=".chat-info-wrap" data-same=".chat-info"></div>
        @if (isInvestor())
            <div class="chat-info c-scrollbar-light p-4 z-1">
                <div class="px-4 text-center mb-3">
                    <span class="avatar avatar-md mb-3">
                        @if ($chat_thread->receiver->image != null)
                        <img src="{{ getFile(config('location.user.path').$chat_thread->receiver->image) }}">
                        @else
                        <img src="{{ url('assets/admin/images/default.png') }}">
                        @endif
                        <span class="badge badge-dot badge-success badge-circle badge-status"></span>
                    </span>
                    
                    <h4 class="h5 mb-2 fw-600">{{ $chat_thread->receiver->firstname }} {{ $chat_thread->receiver->lastname }}</h4>
                    <div class="text-center">
                        @if ($chat_thread->receiver->badges)
                            @foreach ($chat_thread->receiver->badges as $key => $user_badge)
                                @if ($user_badge->badge != null)
                                    <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ my_asset($user_badge->badge->icon) }}"></span>
                                @endif
                            @endforeach   
                        @endif
                        
                    </div>
                </div>
                
                
                
                
                
            </div>
        @else
            <div class="chat-info c-scrollbar-light p-4 z-1">
                <div class="px-4 text-center mb-3">
                    <span class="avatar avatar-md mb-3">
                        @if ($chat_thread->sender->image != null)
                        <img src="{{ getFile(config('location.user.path').$chat_thread->sender->image) }}">
                        @else
                        <img src="{{ url('assets/admin/images/default.png') }}">
                        @endif
                        <span class="badge badge-dot badge-success badge-circle badge-status"></span>
                    </span>
                    
                    <h4 class="h5 mb-2 fw-600">{{ $chat_thread->sender->firstname }} {{ $chat_thread->sender->lastname }}</h4>
                    <div class="text-center">
                        @if ($chat_thread->sender->badges)
                            @foreach ($chat_thread->sender->badges as $key => $user_badge)
                                @if ($user_badge->badge != null)
                                    <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ my_asset($user_badge->badge->icon) }}"></span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                
                
            </div>
        @endif
    </div>
</div>
