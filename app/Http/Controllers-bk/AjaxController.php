<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\Template;
use App\Models\ManagePlan;
use App\Models\PayMoney;
use App\Models\Subscriber;
use App\Models\User;
use App\Http\Traits\Notify;
use Illuminate\Http\Request;
use App\Models\ContentDetails;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use App\Console\Commands\UpdateBadgeCron;
use App\Models\Project;
use App\Models\ShortListProject;
use App\Models\ShortListInvestor;
use App\Mail\EmailOtp;
use App\Mail\ResetPassword;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CheckMobiController;
class AjaxController extends Controller
{
    use Notify;

    public function __construct()
    {
        $this->theme = template();
    }


    // Shortlist investor
    public function addListInvestor(Request $request)
    {
        try {  
            $user_id = auth()->user()->id;
            
            $investor_id = $request->investor_id;
            
            $check_shortlist = ShortListInvestor::where(['user_id' => $user_id, 'investor_id' => $investor_id, 'type' => $request->type])->first();
            
            if($check_shortlist) {
                // delete
               ShortListInvestor::where(['user_id' => $user_id, 'investor_id' => $investor_id, 'type' => $request->type])->delete();
                $data['message'] = trans('Shortlist deleted');
                $data['code'] = 200;
                return response()->json($data, 200);
            }
            else {
                // create new
                $status =  ShortListInvestor::create([
                    'user_id' => $user_id, 
                    'investor_id' => $investor_id,
                    'type' => $request->type
                ]);
                $data['message'] = trans('Shortlist created');
                $data['code'] = 200;
                return response()->json($data, 200);
                
            }
            
        } 
        catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['code'] = 400;
            return response()->json($data, 200);
        }
    }

    // Shortlist Project
    public function addListProject(Request $request)
    {
        try {  
            $user_id = auth()->user()->id;
            
            $project_id = $request->project_id;
            
            $check_shortlist = ShortListProject::where(['user_id' => $user_id, 'project_id' => $project_id, 'type' => $request->type])->first();
            
            if($check_shortlist) {
                // delete
                ShortListProject::where(['user_id' => $user_id, 'project_id' => $project_id, 'type' => $request->type])->delete();
                    if($request->type == 'shortlist') 
                        $data['message'] = trans('Shortlist deleted');
                    else
                        $data['message'] = trans('interest removed');
                $data['code'] = 200;
                return response()->json($data, 200);
            }
            else {
                // create new
                $status =  ShortListProject::create([
                    'user_id' => $user_id, 
                    'project_id' => $project_id,
                    'type' => $request->type
                ]);
                if($request->type == 'shortlist') 
                    $data['message'] = trans('Shortlist created');
                else 
                    $data['message'] = trans('Project interested');
                $data['code'] = 200;
                return response()->json($data, 200);
                
            }
        } 
        catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['code'] = 400;
            return response()->json($data, 200);
        }
    }

    public function deleteProjectRow(Request $request)
    {
        try {
            
            Project::where('id', $request->id)->delete();
            
            // delete project in plan
            
            ManagePlan::where('project_id', $request->id)->update([
                'project_id' => 0
            ]);
            
            $data['message'] = trans('Project deleted');
            $data['code'] = 200;
            return response()->json($data, 200);
        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['code'] = 400;
            return response()->json($data, 200);
        }
    }
    
    public function deleteUserProjectRow(Request $request)
    {
        try {
            $user_id = auth()->user()->id ?? 0;
            
            if($user_id) {
                $findProject = Project::where('id',  $request->id)->first();
                if($findProject) {
                    if($user_id != $findProject->user_id) {
                        $data['message'] = trans('You need admin role to deleted');
                        $data['code'] = 200;
                    }
                    else {
                        Project::where('id', $request->id)->delete();
                        ManagePlan::where('project_id', $request->id)->update([
                            'project_id' => 0
                        ]);
                        $data['message'] = trans('Project deleted');
                        $data['code'] = 200;
                    }
                    
                }
                
            }
            else {
                $data['message'] = trans('Permission denied');
                $data['code'] = 400;
            }

            return response()->json($data, 200);
        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['code'] = 400;
            return response()->json($data, 200);
        }
    }
    
    public function checkNumberToken(Request $request)
    {
        try {
            $findProject = Project::where('id', $request->project_id)->first();
            $tokenBuy = Paymoney::where('project_id', $findProject->id)->sum('total');
            
            $tokenExist = $findProject->token->fixed_amount - $tokenBuy;
            $tokenStatus = 1;
            if($tokenExist <= 0)
                $tokenStatus = $tokenExist = 0;
                
            $data['message'] = trans('Get number token');
            $data['tokenStatus'] = $tokenStatus;
            $data['tokenExist'] = $tokenExist;
            $data['slug'] = $findProject->slug;
            $data['code'] = 200;
            return response()->json($data, 200);
        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['code'] = 400;
            return response()->json($data, 200);
        }
    }
    
    // send active otp to email
    

    // send email otp
    public function sendOtpEmailVerify(Request $request)
    { 
        try {
            
            
            $user  = User::where('email', $request->email)->whereNotNull('email')->first();

            if($user) {
                if($user->email_verification == 1) {
                    return response()->json([
                        'code' => 410,
                        'message' => trans('Your email was verified'),
                    ]);
                }
                User::where('id', $user->id)->update([
                    'verify_code' => rand(10000,99999)
                ]);

                try {
                
                    Mail::to($request->email)->send(new EmailOtp($request->email));
                   
                } catch (\Exception $error) {
                    return response()->json([
                        'code' => 409,
                        'message' => $error->getMessage(),
                    ]);
                }
            }
            else {
                return response()->json([
                    'code' => 404,
                    'message' => trans("User not found"),
                    
                ]);
            }
            
            
            return response()->json([
                'code' => 200,
                'message' => trans("Please check your inbox to confirm your email"),
                
            ]);
            
        } catch (\Exception $error) {
            return response()->json([
                'code' => 409,
                'message' => $error->getMessage(),
            ]);
        }
    }
    
    // Send active to phone
    public function sendCodeToPhone(Request $request) {

        $user  = User::where('phone', $request->phone)->whereNotNull('phone')->first();
       
        try {
                
            if($user) {
                // update
                $check_mobil = new CheckMobiController();
                
                if($request->type == 'send-otp-reset-to-phone') {
                    
                    $is_send_phone_token = $check_mobil->sendResetPasswordToPhone($request->phone, $user);
                }
                else {
                    //dd($user->phone_verification );
                    if($user->phone_verification == 1) {
                        return response()->json([
                            'code' => 410,
                            'message' => trans('Your phone was verified'),
                        ]);
                    }
                    $is_send_phone_token = $check_mobil->sendCodeToPhone($request->phone, $user);
                }
                    
                if($is_send_phone_token == 1)
                    return response()->json([
                        'code' => 200,
                        'message' => trans("The otp was sent"),
                        
                    ]);
                else
                    return response()->json([
                        'code' => 400,
                        'message' => trans("The otp not sent"),
                        
                    ]);
            }
           else
                return response()->json([
                    'code' => 400,
                    'message' => trans("The phone not found"),
                    
                ]);

        } catch (\Exception $error) {
            return response()->json([
                'code' => 409,
                'message' => trans('error_phone_data'),
            ]);
        }
    }

    // Send email welcome
    public function sendWelcomeEmail(Request $request) { 
        $user  = User::where('email', $request->email)->whereNotNull('email')->first();
        if($user) { 
            try {
            
                Mail::to($request->email)->send(new Welcome($request->email));
                return response()->json([
                    'code' => 200,
                    'message' => trans("The email sent"),
                    
                ]);
               
            } catch (\Exception $error) {
                return response()->json([
                    'code' => 409,
                    'message' => $error->getMessage(),
                ]);
            }
        
        }
        else {
            return response()->json([
                'code' => 404,
                'message' => trans("User not found"),
                
            ]);
        }
        
    }

    // Active account
	public function activeAccount(Request $request) {
    
        if($request->type == 'email') {
            $user  = User::where('email', $request->email)->whereNotNull('email')->first();
            if($user) {
                $token  = User::where('verify_code', $request->otp_code)->whereNotNull('verify_code')->first();
	            try {
	                //  dd($token);  
	                if($token) {
	                    // update
	                    User::where(['verify_code' => $request->otp_code, 'email' => $request->email])->update([
	                        'verify_code' => NULL,
	                        'email_verification' => 1,
	                    ]);
	                    return response()->json([
	                        'code' => 200,
	                        'message' => trans("Your email verified"),
	                        
	                    ]);
	                }
	               else
		               return response()->json([
		                'code' => 400,
		                'message' => trans("Code not found"),
		                
		            ]);
	    
	            } catch (\Exception $error) {
	                return response()->json([
	                    'code' => 409,
	                    'message' => trans('error_update_data'),
	                ]);
	            }
            }
            else {
                return response()->json([
                    'code' => 400,
                    'message' => trans('User not found'),
                ]);
            }
			
        }
        else {
        
            $user  = User::where('phone', $request->phone)->whereNotNull('phone')->first();
            $mobile = new CheckMobiController();
            if($user) {
                if(!$user->verify_code) {
                    return response()->json([
                        'code' => 422,
                        'message' => trans('Your phone is verified'),
                    ]);
                }
                else {
                    $request->merge(['id' => $user->verify_code, 'pin' => $request->otp_code]);
                    $token = $mobile->returnVerifyPin($request);
                    //dd($token);
    	            try {
    	                    
    	                if($token) {
    	                    // update
    	                    User::where(['id' => $user->id])->update([
    	                        'phone_verification' => 1,
    	                        'verify_code' => null,
    	                    ]);
    	                    return response()->json([
    	                        'code' => 200,
    	                        'message' => trans("Verify your number successfully"),
    	                        
    	                    ]);
    	                }
    	               else if($token == 0)
    	                    return response()->json([
    	                        'code' => 400,
    	                        'message' => trans("Otp not found"),
    	                        
    	                    ]);
    	                else
                            return response()->json([
                                'code' => 409,
                                'message' => trans("Many request, please try later"),
                                
                            ]);
    	    
    	            } catch (\Exception $error) {
    	                return response()->json([
    	                    'code' => 409,
    	                    'message' => trans('error_update_data'),
    	                ]);
    	            }
                }
                
            }
            else {
                return response()->json([
                    'code' => 400,
                    'message' => trans('User not found'),
                ]);
            }
            
        }
        
    }





}
