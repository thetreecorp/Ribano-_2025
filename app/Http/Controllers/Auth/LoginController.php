<?php

namespace App\Http\Controllers\Auth;

use App\Models\Ranking;
use App\Template;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Traits\Notify;
// use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
class LoginController extends Controller
{
    use Notify;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        // $this->handleRedirectUri();

        $this->theme = template();
        $this->middleware('guest')->except('logout');
    }

    /**
     * process redirect_uri from query string.
     *
     * @return void
    */
    // protected function handleRedirectUri()
    // {
        
    //     $redirectUri = Request::query('redirect_uri');

    //     if ($redirectUri) {
           
    //         $decodedRedirectUri = base64_decode($redirectUri);

            
    //         if (filter_var($decodedRedirectUri, FILTER_VALIDATE_URL)) {
    //             $this->redirectTo = $decodedRedirectUri;
    //         }
    //     }
    // }


    public function loginModal(Request $request)
    {
        $this->validateLogin($request);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if($this->guard()->validate($this->credentials($request))){
            if(Auth::attempt([$this->username() => $request->username, 'password' =>  $request->password, 'status' =>  1])){
                $user = Auth::user();
                $user->last_login = Carbon::now();
                $user->save();
                $request->session()->regenerate();
                return route('user.home');
            }else{
                return response()->json('You are banned from this application. Please contact with system Adminstrator.',401);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }



    public function login(Request $request)
    {

        $this->validateLogin($request);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->guard()->validate($this->credentials($request))) {
            if (Auth::attempt([$this->username() => $request->username, 'password' => $request->password,'status'=>1])) {

                // custom sso login
                $customParameter = array();
                $customParameter['role'] = auth()->user()->roles->pluck('name')[0] ?? '' ;
                $customParameter['phone'] =  auth()->user()->phone;
                $customParameter['email'] =  auth()->user()->email;
                $customParameter['photo'] =  auth()->user()->image;
                $customParameter['first_name']  = auth()->user()->firstname;
                $customParameter['last_name']  = auth()->user()->lastname;
                $customParameter['full_name']  = $customParameter['first_name'] . ' ' . $customParameter['last_name'];
                $customParameter['id']  = auth()->user()->id;
                $credentials = [$this->username() => $request->username, 'password' => $request->password,'status'=>1];
                $token = JWTAuth::claims($customParameter)->attempt($credentials);
                if(encryptToken($token)) {
                    $customParameter['encryptToken'] = 1;
                    $token = encryptToken($token);
                }

                
               
                //$redirectUri = request()->input('redirect_uri');
                
                $redirectUri = '';
                if (request()->has('redirect_uri') && request()->input('redirect_uri')) {
                    $redirectUri = request()->input('redirect_uri');
                    Cache::put('redirect_uri', $redirectUri, now()->addMinutes(5));
                } 
       
                elseif (Cache::has('redirect_uri')) {
                    $redirectUri = Cache::get('redirect_uri');
                }

                if ($redirectUri) {
                    
                    $decodedRedirectUri = base64_decode($redirectUri);

                    
                    if (filter_var($decodedRedirectUri, FILTER_VALIDATE_URL)) {
                        
                        $redirectUriWithToken = $decodedRedirectUri . (parse_url($decodedRedirectUri, PHP_URL_QUERY) ? '&' : '?') . 'token=' . urlencode($token);

                        
                        return Redirect::to($redirectUriWithToken);
                    }
                }


                return $this->sendLoginResponse($request);
            } else {
                return back()->with('error', 'You are banned from this application. Please contact with system Administrator.');
            }
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }



    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {

        $validateData = [
			$this->username() => 'required|string',
			'password' => 'required|string',
		];

		if (basicControl()->reCaptcha_status_login) {
			$validateData['g-recaptcha-response'] = 'sometimes|required|captcha';
		}

		$request->validate($validateData, [
            'g-recaptcha-response.required' => 'The reCAPTCHA field is required.',
        ]);
    }

    public function username()
    {
        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);
        return $field;
    }

    public function showLoginForm(Request $request)
    {
        if (Auth::check() && $request->has('redirect_uri') && Auth::user()->roles->pluck('name')[0] !== 'admin') {
            return $this->handleRedirectForLoggedInUser($request);
        }
        
        if( $request->has('redirect_uri') ) {
            //Session::put('redirect_uri', $request->input('redirect_uri'));
            Cache::put('redirect_uri', $request->input('redirect_uri'), now()->addMinutes(5));
        }

        return view($this->theme . 'auth.login');
        
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/login');
    }



    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->last_login = Carbon::now();
        $user->two_fa_verify = ($user->two_fa == 1) ? 0 : 1;
        $user->save();

        if ($user) {

            $interestBalance = $user->total_interest_balance; //5
            $investBalance = $user->total_invest; //50
            $depositBalance = $user->total_deposit; //5.0

            $badges = Ranking::where([
                ['min_invest', '<=', $investBalance],
                ['min_deposit', '<=', $depositBalance],
                ['min_earning', '<=', $interestBalance]])->where('status', 1)->get();



            if ($badges) {
                foreach ($badges as $badge) {
                    if (($user->total_invest >= $badge->min_invest) && ($user->total_deposit >= $badge->min_deposit) && ($user->total_interest_balance >= $badge->min_earning)) {
                        $user->last_lavel = $badge->rank_lavel;
                        $user->save();
                        $userBadge = $badge;
                    }
                }



                if (isset($userBadge) && ($user->last_lavel == NULL ||  $userBadge->rank_lavel != $user->last_lavel) ) {
                    $user->last_lavel = $userBadge->rank_lavel;
                    $user->save();

                    $msg = [
                        'user' => $user->fullname,
                        'badge' => $userBadge->rank_lavel,
                    ];

                    $adminAction = [
                        "link" => route('admin.users'),
                        "icon" => "fa fa-user text-white"
                    ];

                    $userAction = [
                        "link" => route('user.profile'),
                        "icon" => "fa fa-user text-white"
                    ];

                    $user->userPushNotification($user, 'BADGE_NOTIFY_TO_USER', $msg, $userAction);
                    $user->adminPushNotification('BADGE_NOTIFY_TO_ADMIN', $msg, $adminAction);

                    $currentDate = Carbon::now();
                    $user->sendMailSms($user, $type = 'BADGE_MAIL_TO_USER', [
                        'user' => $user->fullname,
                        'badge' => $userBadge->rank_lavel,
                        'date' => $currentDate
                    ]);

                    $user->mailToAdmin($type = 'BADGE_MAIL_TO_ADMIN', [
                        'user' => $user->fullname,
                        'badge' => $userBadge->rank_lavel,
                        'date' => $currentDate
                    ]);
                }

            }
        }


        $currentDate = dateTime(Carbon::now());
        $msg = [
            'name' => $user->fullname,
        ];

        $action = [
            "link" => "#",
            "icon" => "fas fa-user text-white"
        ];

        $this->userPushNotification($user, 'LOGIN_NOTIFY_TO_USER', $msg, $action);

        $this->sendMailSms($user, $type = 'LOGIN_MAIL_TO_USER', [
            'name'          => $user->fullname,
            'last_login_time' => $currentDate
        ]);

    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Illuminate\Support\Facades\Auth::guard();
    }

    // Added by Ihtesham
    /**
     * Handle redirect for already logged in users with redirect_uri parameter
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleRedirectForLoggedInUser(Request $request)
    {
        $redirectUri = $request->input('redirect_uri');
        
        if ($redirectUri) {
            $redirect = $this->redirectWithToken($redirectUri);
            if ($redirect) {
                return $redirect;
            }
        }
        
        // Default redirect if no valid redirect_uri
        return redirect()->route('user.home');
    }

}
