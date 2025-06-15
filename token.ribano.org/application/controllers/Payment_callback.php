<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_callback extends CI_Controller
{
    function __construct() {
        parent::__construct();

        $this->load->model(array(

 			'payment_model',
 			'website/web_model',
 			'common_model',
 		));

        
    }

    public function bitcoin_confirm($orderid = null){

		// Bitcoin Tranction log

		$payment_type 	= $this->session->userdata('payment_type');
		$paymentID 		= $this->session->userdata('paymentID');

    	$deposit      	= $this->db->select('*')->from('crypto_payments')->where('orderID', $orderid)->get()->row();

		if ($payment_type == 'deposit' && $deposit) {

			$userinfo = $this->web_model->retriveUserInfo();    		
        	$appSetting = $this->common_model->get_setting();

        	$set_email = $this->common_model->email_sms('email');
			if($set_email->deposit!=NULL){
			    #----------------------------
			    #      email verify smtp
			    #----------------------------
			    $post = array(
			        'title'             => $appSetting->title,
			        'subject'           => 'Deposit',
			        'to'                => $userinfo->email,
			        'message'           => 'You Deposit The Amount Is '.$deposit->coinLabel.' '.$deposit->amount.'.',
			    );
			    if(@$this->common_model->send_email($post)){
			        $n = array(
			            'user_id'                => $userinfo->user_id,
			            'subject'                => display('diposit'),
			            'notification_type'      => 'deposit',
			            'details'                => 'You Deposit The Amount Is '.$deposit->coinLabel.' '.$deposit->amount.'.',
			            'date'                   => date('Y-m-d h:i:s'),
			            'status'                 => '0'
			        );
			        $this->db->insert('notifications',$n);    
			    }
			    else{
			    	$n = array(
			            'user_id'                => $userinfo->user_id,
			            'subject'                => display('diposit'),
			            'notification_type'      => 'deposit',
			            'details'                => 'You Deposit The Amount Is '.$deposit->coinLabel.' '.$deposit->amount.'.',
			            'date'                   => date('Y-m-d h:i:s'),
			            'status'                 => '0'
			        );
			        $this->db->insert('notifications',$n);
			    }
			}

			$set_sms = $this->common_model->email_sms('sms');
			if($set_sms->deposit!=NULL){

			    $this->load->library('sms_lib');
			    $template = array( 
			        'name'      => $this->session->userdata('fullname'),
			        'amount'    => $deposit->amount,
			        'currency_symbol'    => $deposit->coinLabel,
			        'date'      => date('d F Y')
			    );
			    #------------------------------
			    #   SMS Sending
			    #------------------------------
			    if (@$userinfo->phone) {
				    $send_sms = $this->sms_lib->send(array(
				        'to'              => $userinfo->phone, 
				        'template'        => 'Hi, %name% You Deposit The Amount Is %currency_symbol% %amount% ', 
				        'template_config' => $template, 
				    ));

			    }else{

				  $this->session->set_flashdata('exception', display('there_is_no_phone_number'));

				}

			    if(@$send_sms){
			        $message_data = array(
			            'sender_id' 	=>1,
			            'receiver_id' 	=> @$userinfo->user_id,
			            'subject' 		=> display('diposit'),
			            'message' 		=> 'Hi,'.$this->session->userdata('fullname').' You Deposit The Amount Is '.$deposit->coinLabel.' '.$deposit->amount,
			            'datetime' => date('Y-m-d h:i:s'),
			        );
			        $this->db->insert('message',$message_data);    
			    }
			}

			$this->session->unset_userdata('payment_type');
			$this->session->unset_userdata('deposit');
			$this->session->set_flashdata('message', display('payment_successfully'));
			redirect("shareholder/deposit/show");

		}elseif ($payment_type == 'buy') {
			# code...

		}elseif ($payment_type == 'sell') {
			# code...

		}else {
			# code...

		}

    }

    public function bitcoin_cancel(){

    	

    }
    //Bitcoin Callback
    public function bitcoin(){


    }

    public function payeer_confirm(){

    	$request = $this->input->get();

    	$payment_type = $this->session->userdata('payment_type');


		// Payeer Tranction log
		$this->payment_model->payeerPaymentLog($request);

		if ($payment_type == 'deposit') {
			$this->deposit_confirm();

		}elseif ($payment_type == 'buy') {
			# code...

		}elseif ($payment_type == 'sell') {
			# code...

		}else {
			# code...

		}

    }

    public function payeer_cancel(){

    	$this->session->set_flashdata('exception', display('payment_cancel'));
		redirect('shareholder/deposit');

    }

    private function hextobin($hexString) 
   	{
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
	    return $binString; 
	}
    
    public function ccavenue_confirm()
    {
        error_reporting(0);
        if($this->input->post('encResp',TRUE)){
            
            $workingKey     = 'EC272042F550D2322116F94AF1863307';
            $encResponse    = $this->input->post('encResp',TRUE);
            $secretKey 		= $this->hextobin(md5($workingKey));
            $initVector 	= pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
			$encryptedText	= $this->hextobin($encResponse);
			$openMode 		= mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
			mcrypt_generic_init($openMode, $secretKey, $initVector);
			$decryptedText 	= mdecrypt_generic($openMode, $encryptedText);
			$decryptedText 	= rtrim($decryptedText, "\0");
		 	mcrypt_generic_deinit($openMode);
			$rcvdString 	= $decryptedText;

        	$decryptValues=explode('&', $rcvdString);
        	$dataSize=sizeof($decryptValues);
        	for($i = 0; $i < $dataSize; $i++) 
        	{
        		$information[]=explode('=',$decryptValues[$i]);
        	}

        	$order_status 	= $information[3][1];
        	$failur_message = $information[4][1];
        	$userid 		= $information[26][1];
        	$currency 		= $information[9][1];
        	$amount 		= $information[10][1];
        	$feesamount 	= !empty($information[27][1])?$information[27][1]:0;
        	$amount         = number_format($amount-$feesamount,2);

        	$date 			= new DateTime();
			$deposit_date 	= $date->format('Y-m-d H:i:s');
			
			$logdata = array(

    			'tracking_id'		=> $information[1][1],
    			'bank_ref_no'		=> $information[2][1],
    			'failure_message'	=> $information[4][1],
    			'order_status'		=> $information[3][1],
    			'payment_mode'		=> $information[5][1],
    			'card_name'			=> $information[6][1],
    			'currency'			=> $information[9][1],
    			'amount'			=> $amount,
    			'fees_amount'		=> $feesamount,
    			'billing_id'		=> $information[26][1],
    			'eci_value'			=> $information[36][1],
    			'card_holder_name'	=> $information[37][1],
    			'bank_receipt_no'	=> $information[38][1],
    		);
    		$this->payment_model->ccavenuePaymentLog($logdata);
        	
        	if($order_status==="Success"){

        		$balance_add = array(
	                'user_id'           => $userid,
	                'amount'           	=> $amount,
	                'last_update' 		=> $deposit_date,
	            );

	            $deposit_balance 	= $this->payment_model->coinpayments_balanceAdd($balance_add);

	            if ($deposit_balance) {
	    			
	                $depositdata = array(
	                    'balance_id'         => @$deposit_balance,
	                    'user_id'            => @$userid,
	                    'transaction_type'   => 'DEPOSIT',
	                    'transaction_amount' => $amount,
	                    'transaction_fees' 	 => 0,
	                    'ip'                 => @$this->input->ip_address(),
	                    'date'               => @$deposit_date
	                );

	    			$this->payment_model->balancelog($depositdata);

	    		}

				$date 			= new DateTime();
				$deposit_date 	= $date->format('Y-m-d H:i:s');

				$dbt_deposit_data 		= array(

					'user_id'			=> @$userid,
					'amount'         	=> @$amount,
					'method'      	    => 'CCAvenue',
					'fees_amount'    	=> @$feesamount,
					'comment'           => $information[2][1],
					'status'         	=> 1,
					'deposit_date'   	=> @$deposit_date,
					'ip'             	=> @$this->input->ip_address()

		        );
	    		$this->payment_model->paymentStore($dbt_deposit_data);
	    		$this->session->set_flashdata('message',display('deposit_successfully'));
	    		redirect(base_url('shareholder/deposit/show'));

        	}
        	else if($order_status==="Aborted"){
        	    $this->session->set_flashdata('exception',display('deposit_cancel_by_users'));
        	    redirect(base_url('shareholder/deposit'));
        	}
        	else if($order_status==="Failure"){
        	    $this->session->set_flashdata('exception',$failur_message);//Add Failer Messae
        	    redirect(base_url('shareholder/deposit'));
        	}
        	else{
        		echo "<br>Security Error. Illegal access detected";
        	}
			
        }
        else{
            echo "<br>Security Error. Illegal access detected";
        }
    }

    public function paypal_confirm(){

    	if (isset($_GET['paymentId'])) {

            $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'paypal')->where('status',1)->get()->row();

            if ($gateway) {

            	require APPPATH.'libraries/paypal/vendor/autoload.php';

	            // After Step 1
	            $apiContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(
                        @$gateway->public_key,     // ClientID
                        @$gateway->private_key     // ClientSecret
                    )
	            );

	            // Step 2.1 : Between Step 2 and Step 3
	            $apiContext->setConfig(
	              array(
	                'mode' => @$gateway->secret_key,
	                'log.LogEnabled' => true,
	                'log.FileName' => 'PayPal.log',
	                'log.LogLevel' => 'FINE'
	              )
	            );

	            // Get payment object by passing paymentId
	            $paymentId = $_GET['paymentId'];

	            $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
	            $payerId = $_GET['PayerID'];

	            // Execute payment with payer id
	            $execution = new \PayPal\Api\PaymentExecution();
	            $execution->setPayerId($payerId);

	            try {
	              // Execute payment
	              	$result = $payment->execute($execution, $apiContext);

	              	$subtotal = $payment->transactions[0]->related_resources[0]->sale->amount->details->subtotal;


					if ($result) {
						$request = $this->input->get();
				    	$payment_type = $this->session->userdata('payment_type');

				    	// Paypal Tranction log
				    	$this->payment_model->paypalPaymentLog($request);

				    	if ($payment_type == 'deposit') {


				    		$deposit = $this->session->userdata('deposit');
				    		$this->session->unset_userdata('deposit');
				    		$sdata['deposit']   = (object)$userdata = array(
				                'user_id'        => $deposit->user_id,
				                'currency_symbol'=> $deposit->currency_symbol,
				                'amount'         => $subtotal - $deposit->fees_amount,
				                'method'      => $deposit->method,
				                'fees_amount'    => $deposit->fees_amount,
				                'comment'        => $deposit->comment,
				                'status'         => 1,
				                'deposit_date'   => $deposit->deposit_date,
				                'ip'             => $deposit->ip,
				            );

				    		$deposit = $this->session->set_userdata($sdata);

							$this->deposit_confirm();

						}elseif ($payment_type == 'buy') {
							# code...

						}elseif ($payment_type == 'sell') {
							# code...

						}else {
							# code...

						}
					}


	            } catch (PayPal\Exception\PayPalConnectionException $ex) {
	              echo $ex->getCode();
	              echo $ex->getData();
	              die($ex);

	            } catch (Exception $ex) {
	              die($ex);

	            }
            }

        }

    }


    public function paypal_cancel(){

    	$this->session->set_flashdata('exception', "Payment Canceled/Faild");
        redirect('shareholder/deposit');
    	

    }

    private function errorAndDie($error_msg,$cp_debug_email) {

		if (!empty($cp_debug_email)) { 
		$report = 'Error: '.$error_msg."\n\n"; 
		$report .= "POST Data\n\n"; 
		foreach ($_POST as $k => $v) { 
		    $report .= "|$k| = |$v|\n"; 
		} 
		mail($cp_debug_email, 'CoinPayments IPN Error', $report); 
		} 
		die('IPN Error: '.$error_msg);

	} 


    public function conipayment_confirm(){


    	$gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'coinpayment')->where('status', 1)->get()->row();

    	if (is_string($gateway->data) && is_array(json_decode($gateway->data, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {

    		$data 			= json_decode(@$gateway->data, true);
			$cp_merchant_id = @$data['marcent_id'];
			$cp_ipn_secret 	= @$data['ipn_secret'];
			$debug_active	= @$data['debuging_active'];
			$debug_email 	= @$data['debug_email'];

    	}
    	else{

			$cp_merchant_id = "";
			$cp_ipn_secret 	= "";
			$debug_active	= "";
			$debug_email 	= "";

    	}

		$order_currency	= $this->input->post("currency1",TRUE);
		$amount1 		= number_format((float)($this->input->post("amount1",TRUE)), 8, '.', '');
		$order_total 	= $amount1;

		$reg = array(

			'amount1'			=>$this->input->post("amount1",TRUE),
			'amount2'			=>$this->input->post("amount2",TRUE),
			'buyer_name'		=>$this->input->post("buyer_name",TRUE),
			'currency1'			=>$this->input->post("currency1",TRUE),
			'currency2'			=>$this->input->post("currency2",TRUE),
			'fee'				=>$this->input->post("fee",TRUE),
			'ipn_id'			=>$this->input->post("ipn_id",TRUE),
			'ipn_mode'			=>$this->input->post("ipn_mode",TRUE),
			'ipn_type'			=>$this->input->post("ipn_type",TRUE),
			'ipn_version'		=>$this->input->post("ipn_version",TRUE),
			'merchant'			=>$this->input->post("merchant",TRUE),
			'received_amount'	=>$this->input->post("received_amount",TRUE),
			'received_confirms'	=>$this->input->post("received_confirms",TRUE),
			'status'			=>$this->input->post("status",TRUE),
			'status_text'		=>$this->input->post("status_text",TRUE),
			'txn_id'			=>$this->input->post("txn_id",TRUE)

		);

		$date 			= new DateTime();
        $deposit_date 	= $date->format('Y-m-d H:i:s');

        $wheredata 		= "txn_id='".$this->input->post("txn_id",TRUE)."' AND user_id!=''";

        $instantdata	= $this->db->select("*")->from("coinpayments_payments")->where($wheredata)->get()->row();

        $dbt_deposit_data 		= array(

			'user_id'			=> @$instantdata->user_id,
			'amount'         	=> @$this->input->post("amount2",TRUE),
			'method'      	    => @$gateway->identity,
			'fees_amount'    	=> @$this->input->post("fee",TRUE),
			'comment'        	=> @$this->input->post("txn_id",TRUE),
			'status'         	=> 0,
			'deposit_date'   	=> @$deposit_date,
			'ip'             	=> @$this->input->ip_address()

        );
        

		if (!$this->input->post("ipn_mode",TRUE) || $this->input->post("ipn_mode",TRUE)!= 'hmac') { 

			if($debug_active==1){
				$this->errorAndDie('IPN Mode is not HMAC',$debug_email);
			}
			
		}

		if (!$this->input->server("HTTP_HMAC") || empty($this->input->server("HTTP_HMAC"))) { 

			if($debug_active==1){
				$this->errorAndDie('No HMAC signature sent.',$debug_email);
			}

		} 

		$request = file_get_contents('php://input'); 
		if ($request === FALSE || empty($request)) {

			if($debug_active==1){
				$this->errorAndDie('Error reading POST data',$debug_email);
			}

		} 

		if (!$this->input->post("merchant",TRUE) || $this->input->post("merchant",TRUE) != trim($cp_merchant_id)) {

			if($debug_active==1){
				$this->errorAndDie('No or incorrect Merchant ID passed',$debug_email);
			}

		} 

		$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
		if (!hash_equals($hmac, $this->input->server("HTTP_HMAC"))) { 

			if($debug_active==1){
				$this->errorAndDie('HMAC signature does not match',$debug_email);
			}

		}

		$txn_id 		= $this->input->post("txn_id",TRUE); 
		$item_name 		= $this->input->post("item_name",TRUE); 
		$item_number	= $this->input->post("item_number",TRUE);
		$amount1 		= number_format((float)($this->input->post("amount1",TRUE)),8, '.', '');
		$amount2 		= number_format((float)($this->input->post("amount2",TRUE)),8, '.', '');
		$currency1 		= $this->input->post("currency1",TRUE); 
		$currency2 		= $this->input->post("currency2",TRUE); 
		$status 		= intval($this->input->post("status",TRUE)); 
		$status_text 	= $this->input->post("status_text",TRUE);

		if ($currency1 != $order_currency) {

			if($debug_active==1){
				$this->errorAndDie('Original currency mismatch!',$debug_email);
			}

		}

		if ($amount1 < $order_total) {

			if($debug_active==1){
				$this->errorAndDie('Amount is less than order total!',$debug_email);
			}

		} 

		if ($status >= 100 || $status == 2) {

			$dbt_deposit_check = $this->db->select('*')->from("dbt_deposit")->where("user_id",@$instantdata->user_id)->where("comment",$this->input->post("txn_id",TRUE))->where("status",1)->get()->num_rows();

			if(@$dbt_deposit_check==0){

				$this->payment_model->coinpaymentsPaymentLog($reg);
			
				$balance_add = array(
	                'user_id'           => @$instantdata->user_id,
	                'amount'           	=> @$this->input->post("amount2",TRUE),
	                'last_update' 		=> @$deposit_date,
	            );

	            $deposit_balance 	= $this->payment_model->coinpayments_balanceAdd($balance_add);

	            if ($deposit_balance) {
	    			
	                $depositdata = array(
	                    'balance_id'         => @$deposit_balance,
	                    'user_id'            => @$instantdata->user_id,
	                    'transaction_type'   => 'DEPOSIT',
	                    'transaction_amount' => @$this->input->post("amount2",TRUE),
	                    'transaction_fees' 	 => 0,
	                    'ip'                 => @$this->input->ip_address(),
	                    'date'               => @$deposit_date
	                );

	    			$this->payment_model->balancelog($depositdata);

	    		}

				$date 			= new DateTime();
				$deposit_date 	= $date->format('Y-m-d H:i:s');

	    		$confirmdeposit = array(

	    			'depositdate'		=> $deposit_date,
	    			'user_id'			=>@$instantdata->user_id,
	    			'comment'			=>@$txn_id

	    		);
	    		$this->payment_model->confirm_coinpayment_deposit($confirmdeposit);

			}

		}
		else if ($status < 0) {

			$this->payment_model->coinpaymentsPaymentLog($reg);

			if($status==-1){
				$this->coinpayments_cancel();
			}

		}
		else {

			$this->payment_model->coinpaymentsPaymentLog($reg);

			$dbt_deposit = $this->db->select('*')->from("dbt_deposit")->where("comment",$this->input->post("txn_id",TRUE))->get()->row();
			if(!$dbt_deposit){
				$this->payment_model->paymentStore($dbt_deposit_data);
			}
		}
    }

    public function coinpayments_cancel(){

    	$this->session->set_flashdata('exception', "Payment Canceled/Failed");

    }

    public function conipayment_withdraw()
    {
    	$gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'coinpayment')->where('status', 1)->get()->row();

    	if (is_string($gateway->data) && is_array(json_decode($gateway->data, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {

    		$data 			= json_decode(@$gateway->data, true);
			$cp_merchant_id = @$data['marcent_id'];
			$cp_ipn_secret 	= @$data['ipn_secret'];
			$debug_active	= @$data['debuging_active'];
			$debug_email 	= @$data['debug_email'];

    	}
    	else{

			$cp_merchant_id = "";
			$cp_ipn_secret 	= "";
			$debug_active	= "";
			$debug_email 	= "";

    	}

    	if (!$this->input->post("ipn_mode",TRUE) || $this->input->post("ipn_mode",TRUE)!= 'hmac') { 

			if($debug_active==1){
				$this->errorAndDie('IPN Mode is not HMAC',$debug_email);
			}
			
		}

		if (!$this->input->server("HTTP_HMAC") || empty($this->input->server("HTTP_HMAC"))) { 

			if($debug_active==1){
				$this->errorAndDie('No HMAC signature sent.',$debug_email);
			}

		} 

		$request = file_get_contents('php://input'); 
		if ($request === FALSE || empty($request)) {

			if($debug_active==1){
				$this->errorAndDie('Error reading POST data',$debug_email);
			}

		} 

		if (!$this->input->post("merchant",TRUE) || $this->input->post("merchant",TRUE) != trim($cp_merchant_id)) {

			if($debug_active==1){
				$this->errorAndDie('No or incorrect Merchant ID passed',$debug_email);
			}

		}

		$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
		if (!hash_equals($hmac, $this->input->server("HTTP_HMAC"))) { 

			if($debug_active==1){
				$this->errorAndDie('HMAC signature does not match',$debug_email);
			}

		}

		$status 		= intval($this->input->post("status",TRUE)); 
		$status_text 	= $this->input->post("status_text",TRUE);

		if ($status >= 100 || $status == 2) {
			
			$set_status   = 1;
			$wheredata 		= "txn_id='".$this->input->post("id",TRUE)."' AND user_id!=''";
        	$instantdata	= $this->db->select("*")->from("coinpayments_payments")->where($wheredata)->get()->row();
			$user_id      = $instantdata->user_id;

			$dbt_withdraw_check = $this->db->select('*')->from("dbt_withdraw")->where("user_id",@$instantdata->user_id)->where("comment",$this->input->post("id",TRUE))->where("status",1)->get()->num_rows();

			if(@$dbt_withdraw_check==0){
			
				$data         = array(
					'success_date' 	=>date('Y-m-d h:i:s'),
					'status' 		=> $set_status,
				);

				$wheredata = array(

					'user_id'			=> $user_id,
					'comment'			=> $this->input->post("id",TRUE)
				);

		        $this->db->where($wheredata)->update('dbt_withdraw', $data);

		        $t_data     = $this->db->select('*')->from('dbt_withdraw')->where($wheredata)->get()->row();

		        $userinfo   =  $this->db->select('*')->from('dbt_user')->where('user_id', $user_id)->get()->row();
				
		        $appSetting = $this->common_model->get_setting();

		        $reg = array(

					'amount1'			=>$this->input->post("amount",TRUE),
					'amount2'			=>$this->input->post("amount",TRUE),
					'buyer_name'		=>'',
					'currency1'			=>$this->input->post("currency",TRUE),
					'currency2'			=>$this->input->post("currency",TRUE),
					'fee'				=>'',
					'ipn_id'			=>$this->input->post("ipn_id",TRUE),
					'ipn_mode'			=>$this->input->post("ipn_mode",TRUE),
					'ipn_type'			=>$this->input->post("ipn_type",TRUE),
					'ipn_version'		=>$this->input->post("ipn_version",TRUE),
					'merchant'			=>$this->input->post("merchant",TRUE),
					'received_amount'	=>'',
					'received_confirms'	=>'',
					'status'			=>$this->input->post("status",TRUE),
					'status_text'		=>$this->input->post("status_text",TRUE),
					'txn_id'			=>$this->input->post("txn_id",TRUE)

				);

				$this->payment_model->coinpaymentsPaymentLog($reg);

				$withdrawamount = $this->input->post("amount",TRUE);

		            $check_user_balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $user_id)->get()->row();
		            $new_balance = $check_user_balance->balance-$withdrawamount;


		            $this->db->set('balance', $new_balance)->where('user_id', $user_id)->update("dbt_balance");

		            //User Financial Log
		            if ($check_user_balance) {

		                $depositdata = array(
		                    'balance_id'         => $check_user_balance->id,
		                    'user_id'            => $user_id,
		                    'transaction_type'   => 'WITHDRAW',
		                    'transaction_amount' => $t_data->amount,
		                    'transaction_fees'   => $t_data->fees_amount,
		                    'ip'                 => $t_data->ip,
		                    'date'               => $t_data->request_date
		                );

		                $this->payment_model->balancelog($depositdata);

		            }


				$set_email = $this->common_model->email_sms('email');
				if($set_email->withdraw!=NULL){
		            #----------------------------
		            #      email verify smtp
		            #----------------------------
		            $post = array(
		                'title'             => $appSetting->title,
		                'subject'           => 'Withdraw',
		                'to'                => $this->session->userdata('email'),
		                'message'           => 'You successfully withdraw the amount Is '.$t_data->amount.'. from your account. Your new balance is '.$new_balance,
		            );
		            
		            
		            if(@$this->common_model->send_email($post)){
		                    $n = array(
		                    'user_id'                => $user_id,
		                    'subject'                => display('withdraw'),
		                    'notification_type'      => 'withdraw',
		                    'details'                => 'You successfully withdraw the amount Is '.$t_data->amount.'. from your account. Your new balance is '.$new_balance,
		                    'date'                   => date('Y-m-d h:i:s'),
		                    'status'                 => '0'
		                );
		                $this->db->insert('notifications',$n);    
		            }
		            else{
		            	$n = array(
		                    'user_id'                => $user_id,
		                    'subject'                => display('withdraw'),
		                    'notification_type'      => 'withdraw',
		                    'details'                => 'You successfully withdraw the amount Is '.$t_data->amount.'. from your account. Your new balance is '.$new_balance,
		                    'date'                   => date('Y-m-d h:i:s'),
		                    'status'                 => '0'
		                );
		                $this->db->insert('notifications',$n);
		            }
		        }

		        $set_sms = $this->common_model->email_sms('sms');
				if($set_sms->withdraw!=NULL){
		            #----------------------------
		            #      Sms verify
		            #----------------------------
		                
		            $this->load->library('sms_lib');

		                $template = array( 
		                    'name'      => $userinfo->first_name." ".$userinfo->last_name,
		                    'amount'    => $t_data->amount,
		                    'new_balance' => $new_balance,
		                    'date'      => date('d F Y')
		                );

		            if (@$userinfo->phone) {
		                $send_sms = $this->sms_lib->send(array(
		                    'to'       => $userinfo->phone, 
		                    'subject'         => 'Withdraw',
		                    'template'         => 'You successfully withdraw the amount is %amount% from your account. Your new balance is %new_balance%', 
		                    'template_config' => $template, 
		                ));

		            }else{

		                $this->session->set_flashdata('exception', display('there_is_no_phone_number'));
		            }
		                    


		            if(@$send_sms){
		                $message_data = array(
		                    'sender_id' =>1,
		                    'receiver_id' => $userinfo->user_id,
		                    'subject' => 'Withdraw',
		                    'message' => 'You successfully withdraw the amount is '.$t_data->amount.'. from your account. Your new balance is '.$new_balance,
		                    'datetime' => date('Y-m-d h:i:s'),
		                );

		                $this->db->insert('message', $message_data);
		            }
		        }  
	    	}
		}
    }


    public function stripe_confirm(){


    	$token  = $this->input->post('stripeToken',TRUE);
        $email  = $this->input->post('stripeEmail',TRUE);
        $deposit = $this->session->userdata('deposit');


        $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'stripe')->where('status',1)->get()->row();
        
        if ($gateway) {

	        require_once APPPATH.'libraries/stripe/vendor/autoload.php';

	        $stripe = array(
	          "secret_key"      => @$gateway->private_key,
	          "publishable_key" => @$gateway->public_key
	        );

	        \Stripe\Stripe::setApiKey($stripe['secret_key']);

	        $customer = \Stripe\Customer::create(array(
	          'email' => $email,
	          'source'  => $token
	        ));

	        $charge = \Stripe\Charge::create(array(
	          'customer' => $customer->id,
	          'amount'   => round(($deposit->amount+@$deposit->fees_amount)*100),
	          'currency' => 'usd'
	        ));


	        if ($charge) {

	        	$payment_type = $this->session->userdata('payment_type');

		    	// Paypal Tranction log

		    	if ($payment_type == 'deposit') {	    		

					$this->deposit_confirm();

				}elseif ($payment_type == 'buy') {
					# code...

				}elseif ($payment_type == 'sell') {
					# code...

				}else {
					# code...

				}

	        }

    	}

    }


    public function stripe_cancel(){

    	$this->session->set_flashdata('exception', "Payment Canceled/Failed");
        redirect("shareholder/deposit");

    }


    public function phone_confirm(){

    	$payment_type = $this->session->userdata('payment_type');

    	if ($payment_type == 'deposit') {
			
			$payment_type = $this->session->userdata('payment_type');
	    	$deposit = $this->session->userdata('deposit');

	    	$sdata['deposit']   = (object)$depodata = array(
	            'user_id'        => $deposit->user_id,
	            'amount'         => $deposit->amount,
	            'method'         => $deposit->method,
	            'fees_amount'    => $deposit->fees_amount,
	            'comment'        => $deposit->comment,
	            'status'         => $deposit->status,
	            'deposit_date'   => $deposit->deposit_date,
	            'ip'             => $this->input->ip_address()
	        );	

	    	//Store Data On Deposit
	    	if ($this->payment_model->paymentStore($depodata)) {

				$this->session->unset_userdata('payment_type');
				$this->session->set_flashdata('message', "Wait for Confirmation");
				redirect("shareholder/deposit/show");

			}
			else{
				$this->session->unset_userdata('payment_type');
				$this->session->set_flashdata('exception', display('please_try_again'));
				redirect("shareholder/deposit");

			}

		}elseif ($payment_type == 'buy') {
			# code...

		}elseif ($payment_type == 'sell') {
			# code...

		}else {
			# code...

		}

    	$this->session->unset_userdata($payment_type);
		$this->session->set_flashdata('message', display('payment_successfully'));
		redirect('shareholder/deposit/show');


    }

    public function phone_cancel(){


		$this->session->set_flashdata('exception', "Payment Canceled/Faild");
    	redirect('shareholder/deposit');    	

    }

    private function deposit_confirm(){

    	$payment_type = $this->session->userdata('payment_type');
    	$deposit      = $this->session->userdata('deposit');
    	
    	$sdata['deposit']   = (object)$depodata = array(
            'user_id'        => $deposit->user_id,
            'amount'         => $deposit->amount,
            'method'         => $deposit->method,
            'fees_amount'    => $deposit->fees_amount,
            'comment'        => $deposit->comment,
            'status'         => 1,
            'deposit_date'   => $deposit->deposit_date,
            'ip'             => $this->input->ip_address()
        );

    	//Update session
    	$deposit->status = 1;
    	$this->session->unset_userdata('deposit');

    	//Find same payment
    	$same_payment = $this->db->query("SELECT * FROM `dbt_deposit` WHERE user_id='".$deposit->user_id."' AND amount	='".$deposit->amount."' AND fees_amount='".$deposit->fees_amount."' AND deposit_date='".$deposit->deposit_date."'")->row();

    	//Store Data On Deposit
    	if (!$same_payment) {

    		$userinfo = $this->web_model->retriveUserInfo();

    		$this->payment_model->paymentStore($depodata);

    		//User Balance Add
    		$deposit_balance = $this->payment_model->balanceAdd($deposit);

    		//User Financial Log
    		if ($deposit_balance) {
    			
    			$depositdata = array(
	                'balance_id'         => $deposit_balance,
	                'user_id'            => $deposit->user_id,
	                'transaction_type'   => 'DEPOSIT',
	                'transaction_amount' => $deposit->amount,
	                'transaction_fees'   => $deposit->fees_amount,
	                'ip'                 => $deposit->ip,
	                'date'               => $deposit->deposit_date
	            );

    			$this->payment_model->balancelog($depositdata);

    		}
			
        	$appSetting = $this->common_model->get_setting();

			$set_email = $this->common_model->email_sms('email');
			if($set_email->deposit!=NULL){
			    #----------------------------
			    #      email verify smtp
			    #----------------------------
			    $post = array(
			        'title'             => $appSetting->title,
			        'subject'           => 'Deposit',
			        'to'                => $this->session->userdata('email'),
			        'message'           => 'You Deposit The Amount Is '.$deposit->currency_symbol.' '.$deposit->amount.'.',
			    );
			    
			    if(@$this->common_model->send_email($post)){
			            $n = array(
			            'user_id'                => $this->session->userdata('user_id'),
			            'subject'                => display('diposit'),
			            'notification_type'      => 'deposit',
			            'details'                => 'You Deposit The Amount Is '.$deposit->currency_symbol.' '.$deposit->amount.'.',
			            'date'                   => date('Y-m-d h:i:s'),
			            'status'                 => '0'
			        );
			        $this->db->insert('notifications',$n);    
			    }
			    else{
			    	$n = array(
			            'user_id'                => $this->session->userdata('user_id'),
			            'subject'                => display('diposit'),
			            'notification_type'      => 'deposit',
			            'details'                => 'You Deposit The Amount Is '.$deposit->currency_symbol.' '.$deposit->amount.'.',
			            'date'                   => date('Y-m-d h:i:s'),
			            'status'                 => '0'
			        );
			        $this->db->insert('notifications',$n);
			    }

			}

			$set_sms = $this->common_model->email_sms('sms');
			if($set_sms->deposit!=NULL){
			    $this->load->library('sms_lib');
			    $template = array( 
			        'name'      => $this->session->userdata('fullname'),
			        'amount'    => $deposit->amount,
			        'currency_symbol'    => $deposit->currency_symbol,
			        'date'      => date('d F Y')
			    );
			    #------------------------------
			    #   SMS Sending
			    #------------------------------
			    if (@$userinfo->phone) {
				    $send_sms = $this->sms_lib->send(array(
				        'to'              => $this->session->userdata('phone'), 
				        'template'        => 'Hi, %name% You Deposit The Amount Is %currency_symbol% %amount% ', 
				        'template_config' => $template, 
				    ));

			    }else{

				  $this->session->set_flashdata('exception', display('there_is_no_phone_number'));

				}

			    if(@$send_sms){
			        $message_data = array(
			            'sender_id' =>1,
			            'receiver_id' => $this->session->userdata('user_id'),
			            'subject' => 'Deposit',
			            'message' => 'Hi,'.$this->session->userdata('fullname').' You Deposit The Amount Is '.$deposit->currency_symbol.' '.$deposit->amount,
			            'datetime' => date('Y-m-d h:i:s'),
			        );
			        $this->db->insert('message',$message_data);    
			    }
			}

			$this->session->unset_userdata('payment_type');
			$this->session->set_flashdata('message', display('payment_successfully'));
			redirect("shareholder/deposit/show");

		}
		else{
			$this->session->unset_userdata('payment_type');
			$this->session->set_flashdata('exception', display('please_try_again'));
			redirect("shareholder/deposit");

		}

    }

    public function limoney_confirm()
    {

        $success_return = $this->input->get('vhut',TRUE);
        $amount         = $this->input->get('amount',TRUE); 

        if ($success_return == $this->session->userdata('token') && $amount!=""){

			//Write your code here (* After Success payment)
			$payment_type = $this->session->userdata('payment_type');

			// Limoney Tranction log

			if ($payment_type == 'deposit') {

				$this->deposit_confirm();

			}elseif ($payment_type == 'buy') {
			# code...

			}elseif ($payment_type == 'sell') {
			# code...

			}else {
			# code...

			}
			$this->session->set_flashdata('message', display('payment_successfully'));

			//Don't delete this line
			$this->session->unset_userdata('token');

	        }else{
	            redirect(base_url());

	        }        

	}


}