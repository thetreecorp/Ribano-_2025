<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Http\Traits\CommonFunctionTrait;
class SocialController extends Controller
{
    use CommonFunctionTrait;
    
    public function redirectTwitterToProvider()
    {
        return Socialite::driver('twitter')->redirect();        
    }
    
    public function redirectToProvider($provider)
    {
    
        
        try {
            $scopes = config("services.$provider.scopes") ?? [];
            if (count($scopes) === 0) {
                return Socialite::driver($provider)->redirect();
            } else {
                return Socialite::driver($provider)->scopes($scopes)->redirect();
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }


    
    public function handleProviderCallback(string $provider)
    {
       
        $session = new Session();
        if ($session->get('redirect_uri')) {
           
            $redirect_uri = $session->get('redirect_uri');
            if(isset($_GET['redirect_uri']) && $_GET['redirect_uri']) {
                $redirect_uri = $_GET['redirect_uri'];
                $session->set('redirect_uri', $redirect_uri);
            }
                
        } else {
            $redirect_uri = url('/');
            if(isset($_GET['redirect_uri']) && $_GET['redirect_uri']) {
                $redirect_uri = $_GET['redirect_uri'];
                $session->set('redirect_uri', $redirect_uri);
            }
                
        }
        
        
        try {
            $data = Socialite::driver($provider)->user();
            
            //dd( $data );
            
            
            if(($data)) {
                
                $user = User::where([
                    "email" => $data->email,
                ])->first();
                
                if (!$user) {
                    
                    $name = trim($data->name);
                    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
                    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
                    
                    $userCreate = User::create([
                        'firstname' => $first_name ?? '',
                        'lastname' => $last_name ?? '',
                        'email' => $data->email,
                        'email_verification' => 1,
                        'status' => 1,
                    ]);
                    
                    if($userCreate) {
                    
                        $role = Str::slug('investor');
                        $checkRole = Role::where('name', $role)->count();
                        if(!$checkRole)
                            Role::create(['name' => $role]);
                        
                        $userCreate->assignRole($role);
                       
                        
                        auth()->login($userCreate, true);

                        return redirect()->to(url('/'));
                        
                    }
                    else {
                        return back()->withErrors(['authentication_deny' => 'Login with '.ucfirst($provider).' failed. Error with create user.']);
                    }
                    
                    
                }
                else {
                    // Login return token
                    
                    auth()->login($user, true);
                    return redirect()->to(url('/'));
                }
                
            }
           
            
            return back()->withErrors(['authentication_deny' => 'Login with '.ucfirst($provider).' failed. Please try again.']);
            
            
           // return $this->handleSocialUser($provider, $data);
        } catch (\Exception $e) {
            // dd($e->getMessage());
            // exit();
            return back()->withErrors(['authentication_deny' => 'Login with '.ucfirst($provider).' failed. Please try again.']);
        }
    }

    public function handleTwitterCallback()
    {
       
        $session = new Session();
        if ($session->get('redirect_uri')) {
           
            $redirect_uri = $session->get('redirect_uri');
            if(isset($_GET['redirect_uri']) && $_GET['redirect_uri']) {
                $redirect_uri = $_GET['redirect_uri'];
                $session->set('redirect_uri', $redirect_uri);
            }
                
        } else {
            $redirect_uri = url('/');
            if(isset($_GET['redirect_uri']) && $_GET['redirect_uri']) {
                $redirect_uri = $_GET['redirect_uri'];
                $session->set('redirect_uri', $redirect_uri);
            }
                
        }
        
        try {
            $data = Socialite::driver('twitter')->user();
            
            if(($data)) {

                //dd( $data );
                
                $user = User::where([
                    "email" => $data->email,
                ])->first();
                
                if (!$user) {
                    
                    
                    $name = trim($data->name);
                    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
                    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
                    
                    $userCreate = User::create([
                        'firstname' => $first_name ?? '',
                        'lastname' => $last_name ?? '',
                        'email' => $data->email,
                        'email_verification' => 1,
                        'status' => 1,
                    ]);
                    
                    if($userCreate) {
                    
                        $role = Str::slug('investor');

                        $checkRole = Role::where('name', $role)->count();
                        if(!$checkRole)
                            Role::create(['name' => $role]);
                        
                        $userCreate->assignRole($role);

                        
                        auth()->login($userCreate, true);
                        return redirect()->to(url('/'));
                        
                    }
                    else {
                        return back()->withErrors(['authentication_deny' => 'Login with twitter failed. Error with create user.']);
                    }
                    
                    
                }
                else {
                    // Login return token
                    
                    auth()->login($user, true);
                    return redirect()->to(url('/'));
                }
                
            }
           
            
            return back()->withErrors(['authentication_deny' => 'Login with twitter failed. Please try again.']);
            
            
           // return $this->handleSocialUser($provider, $data);
        } catch (\Exception $e) {
            dd($e->getMessage());
            
            exit();
            return back()->withErrors(['authentication_deny' => 'Login with twitter failed. Please try again.']);
        }
    }

    
    
   
    
   
}
