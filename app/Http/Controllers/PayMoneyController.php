<?php

namespace App\Http\Controllers;

use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\ManagePlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Facades\App\Services\BasicService;

use PayMoney\Api\Payer;
use PayMoney\Api\Amount;
use PayMoney\Api\Transaction;
use PayMoney\Api\RedirectUrls;
use PayMoney\Api\Payment;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Project;
use App\Models\UserWallet;
use App\Models\Template;
use App\Models\PayMoney;
use App\Models\NearAccountKey;
use App\Models\SendTokenLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PayMoneyController extends Controller
{
    use Notify, Upload;
    public function __construct() {
		$this->successUrl = config('constants.options.success_url');
		$this->cancelUrl = config('constants.options.cancel_url');
		$this->clientId = config('constants.options.paymoney_client_id');
		$this->clientSecret = config('constants.options.paymoney_client_secret');
		$this->explorerUrl = config('constants.options.explorer_url');
		$this->masterAccount = config('constants.options.master_account_id');
        $this->theme = template();
	}
	
    public function payMoneyPayment($slug, $price, $client, $secret)
    {
        
        $findProject = Project::where('slug', $slug)->first();
        if(!$findProject || !$findProject->token)
            return abort(404);

        $cancelUrl = url('failed');
        $successUrl =  url('done-payment/success/'.$findProject->id . '/' . $price);
        $payer = new Payer();
        $payer->setPaymentMethod('PayMoney');
        
        $getPriceToken = $findProject->token->token_price ? $findProject->token->token_price : 1;
        //Amount Object
        $amountIns = new Amount();
        $amountIns->setTotal((float)$price*(float)$getPriceToken)->setCurrency('USD'); //must give a valid currency code and must exist in merchant wallet list
    
        //Transaction Object
        $trans = new Transaction();
        $trans->setAmount($amountIns);
    
        //RedirectUrls Object
        $urls = new RedirectUrls();

        $urls->setSuccessUrl($successUrl) //success url - the merchant domain page,
        // to redirect after successful payment, see sample example-success.php file in sdk root,
        //example - http://techvill.net/PayMoney_sdk/example-success.php
        ->setCancelUrl($cancelUrl); //cancel url - the merchant domain page, to redirect after
        // cancellation of payment, example -  http://techvill.net/PayMoney_sdk/
        
        //Payment Object
        $payment = new Payment();
        
        
        if(isset($client) && $client) {
            $this->clientId =   $client;
        }
        if(isset($secret) && $secret) {
            $this->clientSecret =   $secret;
        }
        
        $payment->setCredentials([ //client id & client secret, see merchants->setting(gear icon)
            'client_id' => $this->clientId, //must provide correct client id of an express merchant
            'client_secret' => $this->clientSecret //must provide correct client secret of an express merchant
        ])->setRedirectUrls($urls)
        ->setPayer($payer)
        ->setTransaction($trans);
        

        

        try {
            $payment->create(); //create payment
            //dd($payment);

            header("Location: ".$payment->getApprovedUrl()); //checkout url
            exit();
        } catch (Exception $ex) {
            print $ex;
            exit;
        }
    }

    public function payMoneyCancel() {
        $theme = $this->theme;
        return view('errors.cancel', compact('theme'));
    
    }
    public function payMoneySuccess($id, $amount) {
        $theme = $this->theme;
        if ($_GET){
            $encoded = json_encode($_GET);
            $decoded = json_decode(base64_decode($encoded), TRUE);
            
            if ($decoded["status"] == 200)
            {
                // do anything here, i.e. display to merchant domain pages or insert data into merchant domain's  database
                // echo "Status => " . $decoded["status"] . "<br/>";
                // echo "Transaction ID => " . $decoded["transaction_id"] . "<br/>";
                // echo "Merchant => " . $decoded["merchant"] . "<br/>";
                // echo "Currency => " . $decoded["currency"] . "<br/>";
                // echo "Amount => " . $decoded["amount"] . "<br/>";
                // echo "Fee => " . $decoded["fee"] . "<br/>";
                // echo "Total => " . $decoded["total"] . "<br/>";
                
                $decoded['user_id'] = Auth::user()->id ?? 0;
                $decoded['project_id'] = $id;
                unset($decoded['status']);
                // insert data here
                $status = PayMoney::create($decoded);
                // check and create wallet and send the token to wallet

                $randomString = Str::random(11, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                

                if(Auth::user()->id) {
                    $find_wallet = UserWallet::where('user_id', Auth::user()->id)->first();
                    $findToken = ManagePlan::where('project_id', $id)->first();

                    //dd($find_wallet);

                    if($find_wallet) {
                        // send token
                        if($findToken) {
                            // send token to user
                            $findAccount = NearAccountKey::where("token_id", $findToken->id)->first();
                            $email = str_replace(['@', '.'], '', Auth::user()->email);
                            
                            
                                    
                            if($findAccount) {
                                $arr = array(
                                    'owner_id' => $findAccount['name'],
                                    //'account_id' => strtolower($email) . '.' . $this->masterAccount,
                                    'account_id' => $find_wallet->wallet_address,
                                    'contract' => $findAccount['name'],
                                    'private_key' => $findAccount['private_key'],
                                    'old_owner_id' => $findAccount['name'],
                                    //'receiver_id' => strtolower($email) . '.' . $this->masterAccount,
                                    'receiver_id' => $find_wallet->wallet_address,
                                    'memo' => 'Token send from Ribano',
                                    'amount' => (string) $amount,
                                );
                                
                                
                                $send_token = depositAndSendToken($arr);
                                
                                if($send_token) {
                                
                                    
                                    $hash = !empty($send_token) && is_array($send_token) ? json_encode($send_token) : null;

                                    SendTokenLog::create([
                                        'user_id' => Auth::user()->id,
                                        'number_token' => $amount,
                                        'fee' => $decoded["fee"],
                                        'total_amount' => $decoded["total"],
                                        'token_id' => $findToken->id,
                                        'hash' => $hash
                                    ]);
                                
                                    return redirect()->route('success')->with([
                                        'message' => 'Token sent to your near account',
                                       // 'hash' => $this->explorerUrl . 'transactions/' .$send_token,
                                    ]);

                                   // return redirect()->route('success')->with('message', 'Token sent to your near account');
                                }
                                else {
                                    return redirect()->route('failed')->with('message', "Can't send the token");
                                }
                            }
                            else {
                                return redirect()->route('failed')->with('message', 'Near account not found');
                            }
                        }
                    }
                    else {
                        // create wallet and sent token
                        //$email = str_replace(['@', '.'], '', Auth::user()->email);
                        $randomN = Str::random(3, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                        $email = $randomString;
                        if(Auth::user()->username)
                            $email = str_replace(['@', '.'], '', Auth::user()->username);
                        // find token symbol
                        if($findToken) {

                            $token_symbol = strtoupper($findToken['token_symbol']);
                        
                            // call api and create wallet
                            $create_sub_account_url = config('constants.options.create_normal_sub_account');
                            $response = Http::withHeaders([
                                'Accept' =>  'application/json',


                                
                                'Content-Type' => 'application/json'
                            ])->post($create_sub_account_url, [
                                'name' => strtolower($email),
                            ]);

                            $create_account = $response->json();
                            
                            if($create_account['status'] == 400) { 
                                return redirect()->route('failed')->with('message', 'Create sub account failed');
                            }
                            else {
                                $data = $response->json();
                                
                                $create_wallet = UserWallet::create([
                                    'wallet_address' => strtolower($email) . '.' . $this->masterAccount,
                                    'user_id' => Auth::user()->id,
                                    'type' => 'near',
                                    'status' => 'active',
                                    'private_key' => $data['private_key']
                                    
                                ]);
                                
                                if($create_wallet) {
                                    // Send token

                                    $findAccount = NearAccountKey::where("token_id", $findToken->id)->first();
                                    
                                    if($findAccount) {
                                        $arr = array(
                                            'owner_id' => $findAccount['name'],
                                            'account_id' => strtolower($email) . '.' . $this->masterAccount,
                                            'contract' => $findAccount['name'],
                                            'private_key' => $findAccount['private_key'],
                                            'old_owner_id' => $findAccount['name'],
                                            'receiver_id' => strtolower($email) . '.' . $this->masterAccount,
                                            'memo' => 'Token send from Ribano',
                                            'amount' => (string) $amount,
                                        );
                                        
                                        $send_token = depositAndSendToken($arr);
                                        
                                        if($send_token) {
                                            // save log
                                            // $log = SendTokenLog::where(['user_id' => Auth::user()->id, 'token_id' => $findToken->id])->first();
                                    
                                            // if($log) {
                                            //     $old_token = (float)($log->number_token);
                                            //     SendTokenLog::where(['user_id' => Auth::user()->id, 'token_id' => $findToken->id])->update([
                                            //         'number_token' =>  (float)$decoded["total"] + $old_token,
                                            //     ]);
                                            // }
                                            // else {
                                            //     // save log
                                            //     SendTokenLog::create([
                                            //         'user_id' => Auth::user()->id,
                                            //         'number_token' => $decoded["total"],
                                            //         'token_id' => $findToken->id,
                                            //     ]);
                                            // }
                                            $hash = !empty($send_token) && is_array($send_token) ? json_encode($send_token) : null;
                                            
                                            SendTokenLog::create([
                                                'user_id' => Auth::user()->id,
                                                'number_token' => $amount,
                                                'fee' => $decoded["fee"],
                                                'total_amount' => $decoded["total"],
                                                'token_id' => $findToken->id,
                                                'hash' => $hash
                                            ]);
                                            return redirect()->route('success')->with([
                                                'message' => 'Token sent to your near account',
                                                //'hash' => $this->explorerUrl . 'transactions/' .$send_token,
                                            ]);
                                        }
                                        else {
                                            return redirect()->route('failed')->with('message', "Can't send the token");
                                        }
                                    }
                                    else {
                                        return redirect()->route('failed')->with('message', 'Near account not found');
                                    }

                                    
                                    
                                }
                                else {
                                    return redirect()->route('failed')->with('message', 'Insert wallet error');
                                }

                                
                            }
                        }
                        else {
                            // token not found
                            return redirect()->route('failed')->with('message', 'Token not found');
                        }
                       
                    }
                }
                
                if($status)
                    return redirect()->route('success')->with('message', 'Token sent');
                else
                    return redirect()->route('failed')->with('message', 'Insert data failed');
                
            }
            else {
                return redirect()->route('failed')->with('message', 'Payment xwallet failed');
            }
        }
        return redirect()->route('failed')->with('message', 'Payment failed');
    }
    
}
