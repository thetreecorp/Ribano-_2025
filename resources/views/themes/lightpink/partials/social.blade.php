<div class="social mt-4 custom-pd-social">
    <div class="flex gap-1 flex-center">
        <a class="btn btn-light" href="{{ route('social.login', 'linkedin') }}">
            <i class="fab fa-linkedin-in text-[#6366f1]"></i>
            LinkedIn
        </a>
        <!--<a class="btn btn-light svg-block" href="{{ route('twitter') }}">
            {{-- <i class="fab fa-twitter text-primary"></i> --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="67" height="23" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
              </svg>
            Social
        </a>
        <a class="btn btn-light" href="{{ route('social.login',  'facebook') }}">
            <i class="fab fa-facebook-f text-[#3b82f6]"></i>
            facebook
        </a> -->
        <a class="btn btn-light" href="{{ route('social.login','google') }}">
            <i class="fab fa-google text-danger"></i>
            Google
        </a>
    </div>
    
</div>