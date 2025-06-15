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
use App\Models\Template;
use App\Models\PayMoney;
use Illuminate\Support\Facades\Auth;
class PayMoneyController extends Controller
{
    use Notify, Upload;
    public function __construct() {
		$this->successUrl = env('SUCCESS_URL');
		$this->cancelUrl = env('CANCEL_URL');
		$this->clientId = env('PAYMONEY_CLIENTID');
		$this->clientSecret = env('PAYMONEY_CLIENTSECRET');
        $this->theme = template();
	}
    public function payMoneyPayment($slug, $price)
    {
        
       //dd($cancel);
        $findProject = Project::where('slug', $slug)->first();
        if(!$findProject || !$findProject->token)
            return abort(404);

        $cancelUrl = url('failed');
        $successUrl =  url('done-payment/success/'.$findProject->id);
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
        $payment->setCredentials([ //client id & client secret, see merchants->setting(gear icon)
            'client_id' => $this->clientId, //must provide correct client id of an express merchant
            'client_secret' => $this->clientSecret //must provide correct client secret of an express merchant
        ])->setRedirectUrls($urls)
        ->setPayer($payer)
        ->setTransaction($trans);
        
        try {
            $payment->create(); //create payment
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
    public function payMoneySuccess($id) {
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
                if($status)
                    return redirect()->route('success');
                else
                    return redirect()->route('failed');
                
            }
            else {
                return redirect()->route('failed');
            }
        }
        return redirect()->route('failed');
    }
    
}
