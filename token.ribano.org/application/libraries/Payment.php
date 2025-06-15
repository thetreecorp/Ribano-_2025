<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment
{
    
    public function payment_process($sdata, $method=NULL){

        $CI =& get_instance();
        $gateway = $CI->db->select('*')->from('payment_gateway')->where('identity', $method)->where('status',1)->get()->row();
        

        if ($method=='bitcoin') {            

            /********************************
            * GoUrl Cryptocurrency Payment API
            *********************************/
            if ($gateway) {

                $coin = 'bitcoin';
                if($sdata->currency_symbol=='BCH'){
                    $coin = 'bitcoincash';
                }elseif($sdata->currency_symbol=='LTC'){
                    $coin = 'litecoin';
                }elseif($sdata->currency_symbol=='DASH'){
                    $coin = 'dash';
                }elseif($sdata->currency_symbol=='DOGE'){
                    $coin = 'dogecoin';
                }elseif($sdata->currency_symbol=='SPD'){
                    $coin = 'speedcoin';
                }elseif($sdata->currency_symbol=='RDD'){
                    $coin = 'reddcoin';
                }elseif($sdata->currency_symbol=='POT'){
                    $coin = 'potcoin';
                }elseif($sdata->currency_symbol=='FTC'){
                    $coin = 'feathercoin';
                }elseif($sdata->currency_symbol=='VTC'){
                    $coin = 'vertcoin';
                }elseif($sdata->currency_symbol=='PPC'){
                    $coin = 'peercoin';
                }elseif($sdata->currency_symbol=='MUE'){
                    $coin = 'monetaryunit';
                }elseif($sdata->currency_symbol=='UNIT'){
                    $coin = 'universalcurrency';
                }else{
                    $coin = 'bitcoin';
                }


                /**
                 * @category    Main Example - Custom Payment Box ((json, bootstrap4, mobile friendly, white label product, your own logo)    
                 * @package     GoUrl Cryptocurrency Payment API
                 * copyright    (c) 2014-2018 Delta Consultants
                 * @desc        GoUrl Crypto Payment Box Example (json, bootstrap4, mobile friendly, optional - free White Label Product - Bitcoin/altcoin Payments with your own logo and all payment requests through your server, open source)
                 * @crypto      Supported Cryptocoins - Bitcoin, BitcoinCash, Litecoin, Dash, Dogecoin, Speedcoin, Reddcoin, Potcoin, Feathercoin, Vertcoin, Peercoin, MonetaryUnit, UniversalCurrency
                 * @website     https://gourl.io/bitcoin-payment-gateway-api.html#p8
                 * @live_demo   https://gourl.io/lib/examples/example_customize_box.php
                 * @note    You can delete folders - 'Examples', 'Screenshots' from this archive
                 */ 
                    

                /********************** NOTE - 2018 YEAR *******************************************************************************/ 
                /*****                                                                                                             *****/ 
                /*****     This is NEW 2018 latest Bitcoin Payment Box Example  (mobile friendly JSON payment box)                 *****/ 
                /*****                                                                                                             *****/ 
                /*****     You can generate php payment box code online - https://gourl.io/lib/examples/example_customize_box.php  *****/
                /*****         White Label Product - https://gourl.io/lib/test/example_customize_box.php?method=curl&logo=custom   *****/
                /*****         Light Theme - https://gourl.io/lib/examples/example_customize_box.php?theme=black                   *****/
                /*****         Black Theme - https://gourl.io/lib/examples/example_customize_box.php?theme=default             *****/
                /*****         Your Own Logo - https://gourl.io/lib/examples/example_customize_box.php?theme=default&logo=custom   *****/
                /*****                                                                                                             *****/ 
                /***********************************************************************************************************************/

                    
                    
                // Change path to your files
                // --------------------------------------
                DEFINE("CRYPTOBOX_PHP_FILES_PATH", base_url('/gourl/lib/'));         // path to directory with files: cryptobox.class.php / cryptobox.callback.php / cryptobox.newpayment.php; 
                                                                    // cryptobox.newpayment.php will be automatically call through ajax/php two times - payment received/confirmed
                DEFINE("CRYPTOBOX_IMG_FILES_PATH", base_url('gourl/images/'));      // path to directory with coin image files (directory 'images' by default)
                DEFINE("CRYPTOBOX_JS_FILES_PATH", base_url('gourl/js/'));           // path to directory with files: ajax.min.js/support.min.js
                
                
                // Change values below
                // --------------------------------------
                DEFINE("CRYPTOBOX_LANGUAGE_HTMLID", "alang");   // any value; customize - language selection list html id; change it to any other - for example 'aa';   default 'alang'
                DEFINE("CRYPTOBOX_COINS_HTMLID", "acoin");      // any value;  customize - coins selection list html id; change it to any other - for example 'bb'; default 'acoin'
                DEFINE("CRYPTOBOX_PREFIX_HTMLID", "acrypto_");  // any value; prefix for all html elements; change it to any other - for example 'cc';  default 'acrypto_'
                


                
                // Open Source Bitcoin Payment Library
                // ---------------------------------------------------------------
                require_once(FCPATH . "gourl/lib/cryptobox.class.php" );
                    
                    /*********************************************************/
                    /****  PAYMENT BOX CONFIGURATION VARIABLES  ****/
                    /*********************************************************/
                    
                    // IMPORTANT: Please read description of options here - https://gourl.io/api-php.html#options
                    
                    $userID         = $sdata->user_id;     // place your registered userID or md5(userID) here (user1, user7, uo43DC, etc).
                                                      // You can use php $_SESSION["userABC"] for store userID, amount, etc
                                                      // You don't need to use userID for unregistered website visitors - $userID = "";
                                                      // if userID is empty, system will autogenerate userID and save it in cookies
                    $userFormat     = "COOKIE";       // save userID in cookies (or you can use IPADDRESS, SESSION, MANUAL)
                    $orderID        = "invoice".$sdata->user_id.time();    // invoice #000383
                    $amountUSD      = (float)@$sdata->amount + (float)@$sdata->fees_amount;           // invoice amount - 0.12 USD; or you can use - $amountUSD = convert_currency_live("EUR", "USD", 22.37); // convert 22.37EUR to USD
                    
                    $period         = "NOEXPIRY";     // one time payment, not expiry
                    $def_language   = "en";           // default Language in payment box
                    $data['def_language']   = "en";
                    $def_coin       = $coin;      // default Coin in payment box
                    $data['def_coin']       = $coin;
                    
                    
                    
                    // List of coins that you accept for payments
                    //$coins = array('bitcoin', 'bitcoincash', 'litecoin', 'dash', 'dogecoin', 'speedcoin', 'reddcoin', 'potcoin', 'feathercoin', 'vertcoin', 'peercoin', 'monetaryunit', 'universalcurrency');


                    $coins = array($coin);  // for example, accept payments in bitcoin, bitcoincash, litecoin, dash, speedcoin 
                    $data['coins'] = array($coin); 

                    // Create record for each your coin - https://gourl.io/editrecord/coin_boxes/0 ; and get free gourl keys
                    // It is not bitcoin wallet private keys! Place GoUrl Public/Private keys below for all coins which you accept

                    $pub_key = unserialize($gateway->public_key);
                    $pri_key = unserialize($gateway->private_key);
                    $pub_val = '';
                    $piv_val = '';
                    foreach ($pub_key as $key => $value) { 
                        if ($coin == $key && $value!='') $pub_val = $value;

                    }
                    foreach ($pri_key as $key => $value) { 
                        if ($coin == $key && $value!='') $piv_val = $value;

                    }

                             
                    // Demo Keys; for tests (example - 5 coins)
                    $all_keys = array(  $coin => array( "public_key" => $pub_val,  
                                                        "private_key" => $piv_val));

                    //  IMPORTANT: Add in file /lib/cryptobox.config.php your database settings and your gourl.io coin private keys (need for Instant Payment Notifications) -
                    /* if you use demo keys above, please add to /lib/cryptobox.config.php - 
                        $cryptobox_private_keys = array("25654AAo79c3Bitcoin77BTCPRV0JG7w3jg0Tc5Pfi34U8o5JE", 
                                    "25656AAeOGaPBitcoincash77BCHPRV8quZcxPwfEc93ArGB6D", "25657AAOwwzoLitecoin77LTCPRV7hmp8s3ew6pwgOMgxMq81F", 
                                    "25658AAo79c3Dash77DASHPRVG7w3jg0Tc5Pfi34U8o5JEiTss", "20116AA36hi8Speedcoin77SPDPRVNOwjzYNqVn4Sn5XOwMI2c");
                        Also create table "crypto_payments" in your database, sql code - https://github.com/cryptoapi/Payment-Gateway#mysql-table
                        Instruction - https://gourl.io/api-php.html         
                    */                 
                    
                    
                    
                    
                    // Re-test - all gourl public/private keys
                    $def_coin = strtolower($def_coin);
                    if (!in_array($def_coin, $coins)) $coins[] = $def_coin;  
                    foreach($coins as $v)
                    {
                        if (!isset($all_keys[$v]["public_key"]) || !isset($all_keys[$v]["private_key"])) die("Please add your public/private keys for '$v' in \$all_keys variable");
                        elseif (!strpos($all_keys[$v]["public_key"], "PUB"))  die("Invalid public key for '$v' in \$all_keys variable");
                        elseif (!strpos($all_keys[$v]["private_key"], "PRV")) die("Invalid private key for '$v' in \$all_keys variable");
                        elseif (strpos(CRYPTOBOX_PRIVATE_KEYS, $all_keys[$v]["private_key"]) === false) 
                                die("Please add your private key for '$v' in variable \$cryptobox_private_keys, file /lib/cryptobox.config.php.");
                    }
                    
                    // Current selected coin by user
                    $coinName = cryptobox_selcoin($coins, $def_coin);
                    
                    // Current Coin public/private keys
                    $public_key  = $all_keys[$coinName]["public_key"];
                    $private_key = $all_keys[$coinName]["private_key"];
                    
                    /** PAYMENT BOX **/
                    $options = array(
                        "public_key"    => $public_key,
                        "private_key"   => $private_key,
                        "webdev_key"    => "DEV1124G19CFB313A993D68G453342148", 
                        "orderID"       => $orderID,
                        "userID"        => $userID,
                        "userFormat"    => $userFormat,
                        "amount"        => $amountUSD,
                        "amountUSD"     => 0,
                        "period"        => $period,
                        "language"      => $def_language
                    );

                    // Initialise Payment Class
                    $box = new Cryptobox ($options);

                    $data['box'] = $box;

                    // coin name
                    $coinName = $box->coin_name();


                    // php code end :)
                    // ---------------------
                    
                    // NOW PLACE IN FILE "lib/cryptobox.newpayment.php", function cryptobox_new_payment(..) YOUR ACTIONS -
                    // WHEN PAYMENT RECEIVED (update database, send confirmation email, update user membership, etc)
                    // IPN function cryptobox_new_payment(..) will automatically appear for each new payment two times - payment received and payment confirmed
                    // Read more - https://gourl.io/api-php.html#ipn

                    //require_once(FCPATH . "gourl/lib/cryptobox.newpayment.php" );    



                    $order = $box->get_json_values();
                    //print_r($box->payment_id());
                    // if ($box->is_paid()) {
                        //cryptobox_new_payment($box->payment_id(), $box->get_json_values()['order'], $box);
                    // }


                    // $data['def_coin'] = "", 
                    // $data['def_language'] = "en", 
                    // $data['custom_text'] = "", 
                    $data['coinImageSize'] = 70;
                    $data['qrcodeSize'] = 200;
                    $data['show_languages'] = true;
                    $data['logoimg_path'] = "default";
                    $data['resultimg_path'] = "default";
                    $data['resultimgSize'] = 250;
                    $data['redirect'] = base_url("payment_callback/bitcoin_confirm/".@$order['order']);
                    $data['method'] = "ajax";
                    $data['debug'] = false;

                    // Text above payment box
                    $data['custom_text']  = "";


                return $data;

            }
            else{
                return false;

            }

        }
        else if ($method=='payeer') {

            /******************************
            * Payeer Payment Gateway API
            ******************************/
            if ( $gateway ) {
                $date = new DateTime();
                $invoice = $date->getTimestamp();
                $comment = $invoice;

                $data['m_shop']     = @$gateway->public_key;
                $data['m_orderid']  = $invoice;;
                $data['m_amount']   = number_format((float)@$sdata->amount+(float)@$sdata->fees_amount, 2, '.', '');
                $data['m_curr']     = $sdata->currency_symbol;
                $data['m_desc']     = base64_encode($comment);
                $data['m_key']      = @$gateway->private_key;

                $arHash = array(
                    $data['m_shop'],
                    $data['m_orderid'],
                    $data['m_amount'],
                    $data['m_curr'],
                    $data['m_desc']
                );

                $arHash[] = $data['m_key'];

                $data['sign'] = strtoupper(hash('sha256', implode(':', $arHash)));

                return $data;
            }
            else{
                return false;
            }

        }
        else if ($method=='paypal') {

            /******************************
            * Paypal Payment Gateway API
            ******************************/
            if ( $gateway ) {

                require APPPATH.'libraries/paypal/vendor/autoload.php';

                // After Step 1
                $apiContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(
                        @$gateway->public_key,     // ClientID
                        @$gateway->private_key     // ClientSecret
                    )
                );

                // Step 2.1 : Between Step 1 and Step 2
                $apiContext->setConfig(
                    array(
                        'mode' => @$gateway->secret_key,
                        'log.LogEnabled' => true,
                        'log.FileName' => 'PayPal.log',
                        'log.LogLevel' => 'FINE'
                    )
                );

                // After Step 2
                $payer = new \PayPal\Api\Payer();
                $payer->setPaymentMethod('paypal');

                $item1 = new \PayPal\Api\Item();
                $item1->setName('setName');
                $item1->setCurrency('USD');
                $item1->setQuantity(1);
                $item1->setPrice((float)@$sdata->amount+(float)@$sdata->fees_amount);

                $itemList = new \PayPal\Api\ItemList();
                $itemList->setItems(array($item1));

                $amount = new \PayPal\Api\Amount();
                $amount->setCurrency("USD");
                $amount->setTotal((float)@$sdata->amount+(float)@$sdata->fees_amount);

                $transaction = new \PayPal\Api\Transaction();
                $transaction->setAmount($amount);
                $transaction->setItemList($itemList);
                $transaction->setDescription('Description');

                $redirectUrls = new \PayPal\Api\RedirectUrls();
                $redirectUrls->setReturnUrl(base_url('payment_callback/paypal_confirm'))->setCancelUrl(base_url('payment_callback/paypal_cancel'));

                $payment = new \PayPal\Api\Payment();
                $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions(array($transaction))
                    ->setRedirectUrls($redirectUrls);

     
                // After Step 3
                try {
                    $payment->create($apiContext);                

                    $data['payment']     =  $payment;
                    $data['approval_url']=  $payment->getApprovalLink();

                }
                catch (\PayPal\Exception\PayPalConnectionException $ex) {
                    // This will print the detailed information on the exception.
                    //REALLY HELPFUL FOR DEBUGGING
                    echo $ex->getData();
                    echo $ex->getData();
                }

                return $data;

            }
            else{
                return false;

            }

        }
        else if ($method=='ccavenue') {

            error_reporting(0);
            $user_id  = $CI->session->userdata('user_id');
            $userinfo = $CI->db->select('*')->from('dbt_user')->where('user_id',$user_id)->get()->row();
            
            //require APPPATH.'libraries/paypal/ccavenue/Crypto.php';

            //Admin Information Start
            $working_key    = @$gateway->secret_key;
            $access_code    = @$gateway->public_key;
            $merchant_id    = @$gateway->private_key;
            //Admin Information End

            //Shareholder Information Start
            $billing_name   = !empty(@$user_id->first_name)?@$user_id->first_name:"JOHN DIE";
            $bill_address   = !empty(@$user_id->address)?@$user_id->address:"ambad";
            $billing_city   = !empty(@$user_id->city)?@$user_id->city:"indore";
            $billing_email  = !empty(@$user_id->email)?@$user_id->email:"liyeplimal@gmail.com";
            $billing_phone  = !empty(@$user_id->phone)?@$user_id->phone:"9595226054";
            //Shareholder Information End

            $merchant_data  = '';
            $totalamount = round(@$sdata->amount+@$sdata->fees_amount);
            $requestdata = array(

                'merchant_id'       =>$merchant_id,
                'order_id'          =>1,
                'amount'            =>$totalamount,
                'currency'          =>$sdata->currency_symbol,
                'redirect_url'      =>base_url("payment_callback/ccavenue_confirm"),
                'cancel_url'        =>base_url("payment_callback/ccavenue_confirm"),
                'language'          =>'EN',
                'billing_name'      =>$billing_name,
                'billing_address'   =>$bill_address,
                'billing_city'      =>$billing_city,
                'billing_state'     =>'MP',
                'billing_zip'       =>'425001',
                'billing_country'   =>'cameroon',
                'billing_tel'       =>$billing_phone,
                'billing_email'     =>$billing_email,
                'delivery_name'     =>$billing_name,
                'delivery_address'  =>$bill_address,
                'delivery_city'     =>$billing_city,
                'delivery_state'    =>'MP',
                'delivery_zip'      =>'425001',
                'delivery_country'  =>'cameroon',
                'delivery_tel'      =>$billing_phone,
                'merchant_param1'   =>$user_id,
                'merchant_param2'   =>round(@$sdata->fees_amount),
                'merchant_param3'   =>'additional Info.',
                'merchant_param4'   =>'additional Info.',
                'merchant_param5'   =>'additional Info.',
                'promo_code'        =>'',
                'customer_identifier'=>'',
                'integration_type'  =>'iframe_normal',
            );
            
            

            foreach ($requestdata as $key => $value){
                $merchant_data.=$key.'='.$value.'&';
            }
            
            
            //Starting Encrypt Script
            $hexString = md5($working_key);
            $length = strlen($hexString); 
        	$binString="";   
        	$count=0; 
        	while($count<$length) 
        	{       
        	    $subString =substr($hexString,$count,2);           
        	    $packedString = pack("H*",$subString); 
        	    if ($count==0)
		    {
				$binString=$packedString;
		    } 
        	    
		    else 
		    {
				$binString.=$packedString;
		    } 
        	    
		    $count+=2; 
        	} 
  	        $secretKey = $binString;
    		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
    	  	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
    	    $pad = $blockSize - (strlen($merchant_data) % $blockSize);
    	    $plainPad = $merchant_data . str_repeat(chr($pad), $pad);
    	  	if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
    		{
    		  $encryptedText = mcrypt_generic($openMode, $plainPad);
    	      	      mcrypt_generic_deinit($openMode);
    		}
    		$encrypted_data=bin2hex($encryptedText);
    		//End Encrypt Script
    		

            $production_url='https://secure.ccavenue.ae/transaction/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$access_code;

            return $production_url;
        }
        else if ($method=='coinpayment') {

            /******************************
            * CoinPayments Gateway API
            ******************************/
            if ( $gateway ) {

                $user_id = $CI->session->userdata('user_id');

                $userinfo = $CI->db->select('*')->from('dbt_user')->where('user_id',$user_id)->get()->row();

                $check = array(
                    'amount1'   =>$sdata->amount,
                    'amount2'   =>$sdata->amount,
                    'currency1' =>$sdata->currency_symbol,
                    'currency2' =>$sdata->currency_symbol,
                    'user_id'   =>$user_id
                );

                $query          = $CI->db->select('*')->from('coinpayments_payments')->where($check)->get();
                $countrow       = $query->num_rows();
                $coinpaydata    = $query->row();

                if($countrow>0){

                    $querytnxid = $CI->db->select('*')->from('coinpayments_payments')->where('txn_id',$coinpaydata->txn_id)->get();

                    $counttnxidrow  = $querytnxid->num_rows();
                    $lastrow        = $querytnxid->last_row();

                    if($counttnxidrow>1){

                        if($lastrow->status==0){

                            return json_decode($coinpaydata->status_text,true);

                        }
                        else{

                            $coinpayment = array(
                                "private_key"   =>@$gateway->private_key,
                                "public_key"    =>@$gateway->public_key
                            );

                            $public_key     =$coinpayment['public_key']; 
                            $private_key    =$coinpayment['private_key']; 

                            $req = array(
                                "version"   =>1,
                                "cmd"       =>"create_transaction",
                                "amount"    =>number_format((float)($sdata->amount),8, '.', ''),
                                "currency1" =>$sdata->currency_symbol,
                                "currency2" =>$sdata->currency_symbol,
                                "buyer_email"=>@$userinfo->email,
                                "ipn_url"   =>base_url("payment_callback/conipayment_confirm"),
                                "key"       =>$public_key,
                                "format"    =>'json',
                            );

                            $post_data = http_build_query($req, '', '&');

                            $hmac = hash_hmac('sha512', $post_data, $private_key); 

                            static $ch = NULL; 
                            if ($ch === NULL) { 
                                $ch = curl_init('https://www.coinpayments.net/api.php'); 
                                curl_setopt($ch, CURLOPT_FAILONERROR, TRUE); 
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
                            }
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac)); 
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 
                             
                            $data = curl_exec($ch);

                            if ($data !== FALSE) { 
                                if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {

                                    $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);

                                }
                                else { 

                                    $dec = json_decode($data, TRUE); 

                                } 
                                if ($dec !== NULL && count($dec)) {

                                    if($dec['error']=="ok"){

                                        $reg = array(

                                        'currency1'         =>$sdata->currency_symbol,
                                        'currency2'         =>$sdata->currency_symbol,
                                        'amount1'           =>@$dec['result']['amount'],
                                        'amount2'           =>@$dec['result']['amount'],
                                        'ipn_type'          =>'deposit',
                                        'status_text'       =>json_encode(@$dec),
                                        'txn_id'            =>@$dec['result']['txn_id'],
                                        'user_id'           =>$user_id

                                        );


                                        $CI->db->insert("coinpayments_payments",$reg);

                                        return $dec;
                                    }
                                    else{

                                        $CI->session->set_flashdata("exception",@$dec['error']);
                                        redirect("shareholder/deposit");
                                    }
                                } 
                                else { 

                                    return array('error' => 'Unable to parse JSON result ('.json_last_error().')'); 

                                } 
                            }
                            else { 

                                return array('error' => 'cURL error: '.curl_error($ch));

                            }

                        }

                    }
                    else{

                        return json_decode($coinpaydata->status_text,true);

                    }

                }
                else{

                    $coinpayment = array(
                        "private_key"   =>@$gateway->private_key,
                        "public_key"    =>@$gateway->public_key
                    );

                    $public_key     =$coinpayment['public_key']; 
                    $private_key    =$coinpayment['private_key']; 

                    $req = array(
                        "version"   =>1,
                        "cmd"       =>"create_transaction",
                        "amount"    =>number_format((float)($sdata->amount),8, '.', ''),
                        "currency1" =>$sdata->currency_symbol,
                        "currency2" =>$sdata->currency_symbol,
                        "buyer_email"=>@$userinfo->email,
                        "ipn_url"   =>base_url("payment_callback/conipayment_confirm"),
                        "key"       =>$public_key,
                        "format"    =>'json',
                    );

                    $post_data = http_build_query($req, '', '&');

                    $hmac = hash_hmac('sha512', $post_data, $private_key); 

                    static $ch = NULL; 
                    if ($ch === NULL) { 
                        $ch = curl_init('https://www.coinpayments.net/api.php'); 
                        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE); 
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
                    }
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac)); 
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 
                     
                    $data = curl_exec($ch);

                    if ($data !== FALSE) { 
                        if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {

                            $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);

                        }
                        else { 

                            $dec = json_decode($data, TRUE); 

                        } 
                        if ($dec !== NULL && count($dec)) {

                            if($dec['error']=="ok"){

                                $reg = array(

                                    'currency1'         =>$sdata->currency_symbol,
                                    'currency2'         =>$sdata->currency_symbol,
                                    'amount1'           =>@$dec['result']['amount'],
                                    'amount2'           =>@$dec['result']['amount'],
                                    'ipn_type'          =>'deposit',
                                    'status_text'       =>json_encode(@$dec),
                                    'txn_id'            =>@$dec['result']['txn_id'],
                                    'user_id'           =>$user_id

                                );

                                $CI->db->insert("coinpayments_payments",$reg);

                                return $dec;
                            }
                            else{

                                $CI->session->set_flashdata("exception",@$dec['error']);
                                redirect("shareholder/deposit");
                            }

                        } 
                        else { 

                            return array('error' => 'Unable to parse JSON result ('.json_last_error().')'); 

                        } 
                    }
                    else { 

                        return array('error' => 'cURL error: '.curl_error($ch));

                    }

                }

            }
            else{
                
                return false;

            }

        }
        else if ($method=='stripe') {

            /******************************
            * Stripe Payment Gateway API
            ******************************/
            if ($gateway) {
              
                require_once APPPATH.'libraries/stripe/vendor/autoload.php';
                // Use below for direct download installation

                $stripe = array(
                  "secret_key"      => @$gateway->private_key,
                  "publishable_key" => @$gateway->public_key
                );

                \Stripe\Stripe::setApiKey($stripe['secret_key']);

                $data['description']=@$gateway->agent;
                $data['stripe']     = $stripe;

                
                return $data;

            }
            else{
                return false;

            }

        }
        else if ($method=='limoney') {

            /************************************
            * Limoney Payment Gateway API
            *************************************/
            if ($gateway) {

                $user = $CI->db->select('*')->from('dbt_user')->where('user_id', $sdata->user_id)->get()->row();

                // Products List
                $products = array();

                $datapush = array(
                    'product_name'    => "STO",
                    'product_qty'     => 1,
                    'product_model'   => "STO",
                    'product_price'   => @$sdata->amount+(float)@$sdata->fees_amount
                );

                //Push data here
                array_push($products, $datapush);
                $jsonencode_products = json_encode($products);


               
                $email          = @$user->email;
                $products       = $jsonencode_products;
                $total_qty      = 1;
                //$product_model  = "SIMTREX";
                $total_price    = @$sdata->amount+(float)@$sdata->fees_amount;
                //$gateway        = $this->input->post('gateway');
                $callback       = base_url('payment_callback/limoney_confirm');
                $token          = md5(@$email.@$product_model.time());


                //if (isset($_POST['submit'])) {

                    //set POST variables
                $url    = "https://www.liyeplimal.net/limoney/authcheck";
                $fields = array(
                    'email'         => urlencode($email),
                    'products'      => urlencode($jsonencode_products),
                    'total_qty'     => urlencode($total_qty),
                    //'product_model' => urlencode($product_model),
                    'total_price'   => urlencode($total_price),
                    //'gateway'       => urlencode($gateway),
                    'callback'      => urlencode($callback),                
                    'token'         => urlencode($token),
                    'domain'        => urlencode('sto'), //simtrex or limarket
                );

                $fields_string = '';
                //url-ify the data for the POST
                foreach($fields as $key=> $value) { 
                    $fields_string .= $key.'='.$value.'&'; 

                }
                $fields_string = rtrim($fields_string, '&');

                //open connection
                $ch = curl_init();

                //set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

                //execute post
                $result = curl_exec($ch);

                if (curl_errno($ch)) {
                    print "Error: " . curl_error($ch);

                } else {

                    //close connection
                    curl_close($ch);

                    $_SESSION['token'] = hash('sha256', "VXTNULL$token".'TaReQ');
                    //$this->session->set_userdata('token', hash('sha256', "VXTNULL$token".'TaReQ'));

                    // print $result ;
                    redirect("https://www.liyeplimal.net/limoney/login/?token=$token");

                }
                //}


                return true;

            }
            else{
                return false;

            }

        }
        else if($method=='phone'){

            /******************************
            * Mobile Payment (Manual)
            ******************************/            
            if ( $gateway ) {

                $data['approval_url'] = base_url('payment_callback/phone_confirm');

                return $data;

            }
            else{

                return false;

            }

        }

    }

    public function payment_withdraw($wdata,$method = NULL)
    {
        $CI =& get_instance();
        $gateway = $CI->db->select('*')->from('payment_gateway')->where('identity', $method)->where('status',1)->get()->row();

        $user_id = $CI->session->userdata('user_id');

        $coinInfo = $CI->db->select('*')->from('dbt_sto_setup')->get()->row();

        if($method=="coinpayment"){

            $coinpayment = array(    
                "private_key"   =>@$gateway->private_key,
                "public_key"    =>@$gateway->public_key
            );

            $public_key     =$coinpayment['public_key']; 
            $private_key    =$coinpayment['private_key']; 

            $req = array(
                "version"       =>1,
                "cmd"           =>"create_withdrawal",
                "amount"        =>number_format((float)($wdata['amount']),8, '.', ''),
                "currency"      =>$coinInfo->pair_with,
                "address"       =>$wdata['wallet_id'],
                "auto_confirm"  =>1,
                "ipn_url"       =>base_url("payment_callback/conipayment_withdraw"),
                "key"           =>$public_key
            );

            $post_data = http_build_query($req, '', '&');

            $hmac = hash_hmac('sha512', $post_data, $private_key); 

            static $ch = NULL; 
            if ($ch === NULL) { 
                $ch = curl_init('https://www.coinpayments.net/api.php');
                curl_setopt($ch, CURLOPT_FAILONERROR, TRUE); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac)); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 
             
            $data = curl_exec($ch);

            if ($data !== FALSE) { 
                if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {

                    $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);

                }
                else { 

                    $dec = json_decode($data, TRUE); 

                } 
                if ($dec !== NULL && count($dec)) {

                    if($dec['error']=='ok')
                    {
                        $reg = array(

                        'currency1'         =>$coinInfo->pair_with,
                        'currency2'         =>$coinInfo->pair_with,
                        'amount1'           =>@$dec['result']['amount'],
                        'amount2'           =>@$dec['result']['amount'],
                        'status_text'       =>json_encode(@$dec),
                        'txn_id'            =>@$dec['result']['id'],
                        'user_id'           =>$user_id
                        );
                        $CI->db->insert("coinpayments_payments",$reg);

                        return $dec;

                    }
                    else{
                        return $dec['error'];
                    }

                } 
                else { 

                    return array('error' => 'Unable to parse JSON result ('.json_last_error().')'); 

                } 
            }
            else { 

                return array('error' => 'cURL error: '.curl_error($ch));

            }
          
        }

    }

    private function encrypt($plainText,$key)
    {
        $secretKey = hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
	  	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
		$plainPad = pkcs5_pad($plainText, $blockSize);
	  	if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
		{
		      $encryptedText = mcrypt_generic($openMode, $plainPad);
	      	      mcrypt_generic_deinit($openMode);
		      			
		} 
		return bin2hex($encryptedText);
    }

}