<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('isLogIn'))
            redirect('shareholder');

        $this->load->model(array(

            'shareholder/auth_model',
            'shareholder/deposit_model',
            'shareholder/deshboard_model',
            'shareholder/token_model',
            'shareholder/profile_model',
            'common_model',

        ));

        $globdata['stoinfo'] = $this->common_model->get_coin_info();
        $this->load->vars($globdata);
    }



    /*
|-------------------------------------
|   shareholder Deshboard
|-------------------------------------
*/
    public function index()
    {
        $user_id = $this->session->userdata('user_id');

        //change language in fronted
        $language        = $this->db->select('language')->from('dbt_user')->where('user_id', $user_id)->get()->row();
        $language_id     = $this->db->query("SELECT id FROM `web_language` WHERE `language_name` LIKE '%" . $language->language . "%'")->row();
        $language_id     = $language_id->id;

        $this->load->helper('cookie');
        $lang = $this->input->cookie('language_id', true);

        if ($lang != $language_id) {
            delete_cookie('language_id');
            $cookie = array(
                'name'    => 'language_id',
                'value'   => $language_id,
                'expire'  => 31536000
            );
            $this->input->set_cookie($cookie);
        }

        $data = $this->deshboard_model->get_cata_wais_transections($user_id);
        $data['title']           = display('home');
        $data['transaction']     = $this->token_model->retriveUserCryptoTransaction();
        $data['securepackage']   = $this->deshboard_model->securedPackage();
        $data['gurentedpackage'] = $this->deshboard_model->gurenteedPackage();
        $data['content'] = $this->load->view('shareholder/dashboard/home', $data, true);
        $this->load->view('shareholder/layout/main_wrapper', $data);
    }



    public function bank_info_update()
    {

        $user_id = $this->session->userdata('user_id');

        $bank_data = array(
            'user_id'           => $this->session->userdata('user_id'),
            'beneficiary_name'    => $this->input->post('beneficiary_name', TRUE),
            'bank_name'    => $this->input->post('bank_name', TRUE),
            'branch'              => $this->input->post('branch', TRUE),
            'account_number' => $this->input->post('account_number', TRUE),
            'ifsc_code' => $this->input->post('code', TRUE),
        );

        $data = $this->db->select('*')->from('bank_info')->where('user_id', $user_id)->get()->num_rows();
        if ($data > 0) {
            $this->db->where('user_id', $user_id)->update('bank_info', $bank_data);
        } else {
            $this->db->insert('bank_info', $bank_data);
        }
        $this->session->set_flashdata('message', display('bank_information_update_successfully'));
        redirect("shareholder/home/");
    }


    /*
|-------------------------------------
|   Diposit pament for bitcoin
|-------------------------------------
*/
    public function payment()
    {


        if ($this->input->post('method', TRUE) == 'payeer') {

            $deposit_data = array(

                'user_id'           => $this->session->userdata('user_id'),
                'deposit_amount'    => $this->input->post('deposit_amount', TRUE),
                'deposit_method'    => $this->input->post('method', TRUE),
                'fees'              => $this->input->post('fees', TRUE),
                'comments'          => $this->input->post('comments', TRUE),
                'deposit_date'      => date('Y-m-d h:i:s'),
                'deposit_ip'        => $this->input->ip_address()

            );


            $result = $this->deposit_model->save_deposit($deposit_data);

            if (@$result['deposit_id'] != NULL) {

                $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'payeer')->where('status', 1)->get()->row();

                $data['m_shop']     = @$gateway->public_key;
                $data['m_orderid']  = 'dp_' . (@$result['deposit_id'] != '' ? @$result['deposit_id'] : '');
                $data['m_amount']   = number_format($this->input->post('deposit_amount', TRUE), 2, '.', '');
                $data['m_curr']     = 'USD';
                $data['m_desc']     = base64_encode($this->input->post('comments', TRUE));
                $data['m_key']      = @$gateway->private_key;
                $data['user_id']    = $this->session->userdata('user_id');

                $arHash = array(
                    $data['m_shop'],
                    $data['m_orderid'],
                    $data['m_amount'],
                    $data['m_curr'],
                    $data['m_desc']
                );

                $arHash[] = $data['m_key'];

                $data['sign'] = strtoupper(hash('sha256', implode(':', $arHash)));

                $data['content'] = $this->load->view("shareholder/dashboard/payeer_form", $data, true);
                $this->load->view("shareholder/layout/main_wrapper", $data);
            } else {

                $this->session->set_flashdata('exception',  display('please_try_again'));
                redirect("shareholder/deposit");
            }
        }


        #----------------------------------
        #   Data send to deposit tbl
        #----------------------------------
        else if ($this->input->post('method', TRUE) == 'bitcoin') {

            $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'bitcoin')->where('status', 1)->get()->row();

            $deposit_data = array(
                'user_id'           => $this->session->userdata('user_id'),
                'deposit_amount'    => $this->input->post('deposit_amount', TRUE),
                'deposit_method'    => $this->input->post('method', TRUE),
                'fees'              => $this->input->post('fees', TRUE),
                'comments'          => $this->input->post('comments', TRUE),
                'deposit_date'      => date('Y-m-d h:i:s'),
                'deposit_ip'        => $this->input->ip_address()
            );

            $result = $this->deposit_model->save_deposit($deposit_data);

            $ulang = $this->db->select('language')->where('user_id', $this->session->userdata('user_id'))->get('dbt_user')->row();
            if ($ulang->language == 'french') {
                $lang = 'fr';
            } else {
                $lang = 'en';
            }


            $message    = "";
            require_once APPPATH . 'libraries/cryptobox/cryptobox.class.php';
            $userID         = $this->session->userdata('user_id');            // place your registered userID or md5(userID) here (user1, user7, uo43DC, etc).
            // you don't need to use userID for unregistered website visitors
            // if userID is empty, system will autogenerate userID and save in cookies
            $userFormat     = "COOKIE";      // save userID in cookies (or you can use IPADDRESS, SESSION)
            $orderID        = (@$result['deposit_id'] != '' ? @$result['deposit_id'] : $this->input->post('orderID', TRUE));    // invoice number 22
            $amountUSD      = $this->input->post('deposit_amount', TRUE);          // invoice amount - 2.21 USD
            $period         = "NOEXPIRY";    // one time payment, not expiry
            $def_language   = $lang;          // default Payment Box Language
            $public_key     = @$gateway->public_key;   // from gourl.io
            $private_key    = @$gateway->private_key;  // from gourl.io

            /** PAYMENT BOX **/
            $options = array(
                "public_key"  => $public_key,        // your public key from gourl.io
                "private_key" => $private_key,       // your private key from gourl.io
                "webdev_key"  => "DEV1124G19CFB313A993D68G453342148",                 // optional, gourl affiliate key
                "orderID"     => $orderID,           // order id or product name
                "userID"      => $userID,            // unique identifier for every user
                "userFormat"  => $userFormat,        // save userID in COOKIE, IPADDRESS or SESSION
                "amount"      => 0,                  // product price in coins OR in USD below
                "amountUSD"   => $amountUSD,         // we use product price in USD
                "period"      => $period,            // payment valid period
                "language"    => $def_language       // text on EN - english, FR - french, etc
            );

            // Initialise Payment Class
            $box = new Cryptobox($options);

            // coin name
            $coinName = $box->coin_name();

            // Payment Received
            if ($box->is_paid()) {

                $text = "User will see this message during " . $period . " period after payment has been made!"; // Example

                $text .= "<br>" . $box->amount_paid() . " " . $box->coin_label() . "  received<br>";
            } else {

                $text = "The payment has not been made yet";
            }


            // Notification when user click on button 'Refresh'
            if (isset($_POST["cryptobox_refresh_"])) {

                $message = "<div class='gourl_msg'>";
                if (!$box->is_paid()) $message .= '<div style="margin:50px" class="well"><i class="fa fa-info-circle fa-3x fa-pull-left fa-border" aria-hidden="true"></i> ' . str_replace(array("%coinName%", "%coinNames%", "%coinLabel%"), array($box->coin_name(), ($box->coin_label() == 'DASH' ? $box->coin_name() : $box->coin_name() . 's'), $box->coin_label()), json_decode(CRYPTOBOX_LOCALISATION, true)[CRYPTOBOX_LANGUAGE]["msg_not_received"]) . "</div>";
                elseif (!$box->is_processed()) {
                    // User will see this message one time after payment has been made
                    $message .= '<div style="margin:70px" class="alert alert-success" role="alert"> ' . str_replace(array("%coinName%", "%coinLabel%", "%amountPaid%"), array($box->coin_name(), $box->coin_label(), $box->amount_paid()), json_decode(CRYPTOBOX_LOCALISATION, true)[CRYPTOBOX_LANGUAGE][($box->cryptobox_type() == "paymentbox" ? "msg_received" : "msg_received2")]) . "</div>";
                    $box->set_status_processed();
                }
                $message .= "</div>";
            }


            $data['jsurl'] = (object) array(

                'u1' => $box->cryptobox_json_url(),
                'u2' => intval($box->is_paid()),
                'u3' => base_url('bitcoin-plug/'),
                'u4' => base_url("shareholder/deposit/store/") . $result['deposit_id'],
                'coin_name' => $box->coin_name(),
                'message' => $message,
                'text' => $text,
                'deposit_id' => (@$result['deposit_id'] != '' ? @$result['deposit_id'] : $this->input->post('orderID', TRUE)),

            );

            $data['post_info'] = (object)$options;
            $data['title']   = 'Bitcoin Payment';
            $data['content'] = $this->load->view('shareholder/dashboard/json', $data, true);
            $this->load->view('shareholder/layout/main_wrapper', $data);
        } else if ($this->input->post('method', TRUE) == 'phone') {

            $mobiledata =  array(
                'om_name'         => $this->input->post('om_name', TRUE),
                'om_mobile'       => $this->input->post('om_mobile', TRUE),
                'transaction_no'  => $this->input->post('transaction_no', TRUE),
                'idcard_no'       => $this->input->post('idcard_no', TRUE),
            );

            $deposit_data = array(
                'user_id'           => $this->session->userdata('user_id'),
                'deposit_amount'    => $this->input->post('deposit_amount', TRUE),
                'deposit_method'    => $this->input->post('method', TRUE),
                'fees'              => $this->input->post('fees', TRUE),
                'comments'          => json_encode($mobiledata),
                'deposit_date'      => date('Y-m-d h:i:s'),
                'deposit_ip'        => $this->input->ip_address()
            );

            $result = $this->deposit_model->save_deposit($deposit_data);

            if ($result) {
                $this->session->set_flashdata('message',  display('payment_successfully'));
                redirect("shareholder/deposit");
            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
                redirect("shareholder/deposit");
            }
        } else if ($this->input->post('method', TRUE) == 'paypal') {

            $deposit_data = array(
                'user_id'           => $this->session->userdata('user_id'),
                'deposit_amount'    => $this->input->post('deposit_amount', TRUE),
                'deposit_method'    => $this->input->post('method', TRUE),
                'fees'              => $this->input->post('fees', TRUE),
                'comments'          => $this->input->post('comments', TRUE),
                'deposit_date'      => date('Y-m-d h:i:s'),
                'deposit_ip'        => $this->input->ip_address()
            );

            $result = $this->deposit_model->save_deposit($deposit_data);

            $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'paypal')->where('status', 1)->get()->row();


            require APPPATH . 'libraries/paypal/vendor/autoload.php';
            // Use below for direct download installation

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

            // After Step 2
            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');

            $item1 = new \PayPal\Api\Item();
            $item1->setName(display('deposit'));
            $item1->setCurrency('USD');
            $item1->setQuantity(1);
            $item1->setPrice($this->input->post('deposit_amount', TRUE));

            $itemList = new \PayPal\Api\ItemList();
            $itemList->setItems(array($item1));

            $amount = new \PayPal\Api\Amount();
            $amount->setCurrency("USD");
            $amount->setTotal($this->input->post('deposit_amount', TRUE));

            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amount);
            $transaction->setItemList($itemList);
            $transaction->setDescription(display('deposit'));

            $redirectUrls = new \PayPal\Api\RedirectUrls();
            $redirectUrls->setReturnUrl(base_url('shareholder/home/paypal_confirm/?depositid=' . $result['deposit_id']))->setCancelUrl(base_url('shareholder/deposit'));

            $payment = new \PayPal\Api\Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);


            // After Step 3
            try {
                $payment->create($apiContext);

                $data['payment'] = $payment;
                $data['approval_url'] = $payment->getApprovalLink();
                $data['user_id'] = $this->session->userdata('user_id');
                $data['deposit_amount'] = $this->input->post('deposit_amount', TRUE);

                $data['content'] = $this->load->view("shareholder/dashboard/paypal_confirm", $data, true);
                $this->load->view("shareholder/layout/main_wrapper", $data);
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                // This will print the detailed information on the exception.
                //REALLY HELPFUL FOR DEBUGGING
                echo $ex->getData();
                echo $ex->getData();
            }
        } else if ($this->input->post('method', TRUE) == 'stripe') {

            $deposit_data = array(
                'user_id'           => $this->session->userdata('user_id'),
                'deposit_amount'    => $this->input->post('deposit_amount', TRUE),
                'deposit_method'    => $this->input->post('method', TRUE),
                'fees'              => $this->input->post('fees', TRUE),
                'comments'          => $this->input->post('comments', TRUE),
                'deposit_date'      => date('Y-m-d h:i:s'),
                'deposit_ip'        => $this->input->ip_address()
            );

            $result = $this->deposit_model->save_deposit($deposit_data);

            $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'stripe')->where('status', 1)->get()->row();


            require_once APPPATH . 'libraries/stripe/vendor/autoload.php';
            // Use below for direct download installation

            $stripe = array(
                "secret_key"      => @$gateway->private_key,
                "publishable_key" => @$gateway->public_key
            );

            \Stripe\Stripe::setApiKey($stripe['secret_key']);

            $data['deposit_id'] = $result['deposit_id'];
            $data['user_id'] = $this->session->userdata('user_id');
            $data['deposit_amount'] = $this->input->post('deposit_amount', TRUE);
            $data['description'] = $this->input->post('comments', TRUE);
            $data['stripe'] = $stripe;

            $data['content'] = $this->load->view("shareholder/dashboard/stripe_confirm", $data, true);
            $this->load->view("shareholder/layout/main_wrapper", $data);
        } else {
            $this->session->set_flashdata('exception',  display('please_try_again'));
            redirect("shareholder/deposit");
        }
    }

    public function callbackBitcoin()
    {
        require_once APPPATH . 'libraries/cryptobox/cryptobox.callback.php';
    }


    public function exchange_confirm()
    {

        if ($this->buy_model->create($this->session->userdata('buy'))) {
            $this->session->unset_userdata('buy');
            $this->session->unset_userdata('deposit_id');
            $this->session->set_flashdata('message', display('payment_successfully'));
            redirect("shareholder/buy/form");
        } else {
            $this->session->unset_userdata('buy');
            $this->session->unset_userdata('deposit_id');
            $this->session->set_flashdata('exception', display('please_try_again'));
            redirect("shareholder/buy/form");
        }
    }
    public function stripe_confirm()
    {

        $token  = $this->input->post('stripeToken', TRUE);
        $email  = $this->input->post('stripeEmail', TRUE);
        $deposit_id  = $this->input->post('asdfasd', TRUE);

        $data = $this->db->select('*')->from('deposit')->where('deposit_id', $deposit_id)->get()->row();


        $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'stripe')->where('status', 1)->get()->row();
        require_once APPPATH . 'libraries/stripe/vendor/autoload.php';
        // Use below for direct download installation

        $stripe = array(
            "secret_key"      => @$gateway->private_key,
            "publishable_key" => @$gateway->public_key
        );

        \Stripe\Stripe::setApiKey($stripe['secret_key']);

        $shareholder = \Stripe\shareholder::create(array(
            'email' => $email,
            'source'  => $token
        ));

        $charge = \Stripe\Charge::create(array(
            'shareholder' => $shareholder->id,
            'amount'   => round($data->deposit_amount * 100),
            'currency' => 'usd'
        ));

        if ($charge) {
            redirect("shareholder/deposit/store/$data->deposit_id");
        }
    }

    public function paypal_confirm()
    {


        if (isset($_GET['paymentId'])) {

            $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'paypal')->where('status', 1)->get()->row();
            require APPPATH . 'libraries/paypal/vendor/autoload.php';
            // Use below for direct download installation

            // After Step 1
            $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    @$gateway->public_key,     // ClientID
                    @$gateway->private_key      // ClientSecret
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
            $depositid = $_GET['depositid'];
            $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
            $payerId = $_GET['PayerID'];

            // Execute payment with payer id
            $execution = new \PayPal\Api\PaymentExecution();
            $execution->setPayerId($payerId);

            try {
                // Execute payment
                $result = $payment->execute($execution, $apiContext);
                if ($result) {
                    redirect("shareholder/deposit/store/$depositid");
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


    public function deposit_confirm()
    {


        $data = $this->db->select('*')->from('deposit')->where('deposit_id', $this->session->userdata('deposit_id'))->get()->row();
        $this->db->set('status', 1)->where('deposit_id', $this->session->userdata('deposit_id'))->update('deposit');

        if ($data != NULL) {

            $transections_data = array(
                'user_id'                   => $data->user_id,
                'transection_category'      => 'deposit',
                'releted_id'                => $data->deposit_id,
                'amount'                    => $data->deposit_amount,
                'comments'                  => $data->comments,
                'transection_date_timestamp' => date('Y-m-d h:i:s')
            );

            $this->deposit_model->save_transections($transections_data);
            $this->session->unset_userdata('deposit_id');
        }

        $appSetting = $this->common_model->get_setting();

        #----------------------------
        #      email verify smtp
        #----------------------------
        $post = array(
            'title'             => $appSetting->title,
            'subject'           => display('deposit'),
            'to'                => $this->session->userdata('email'),
            'message'           => 'You successfully deposit the amount $' . $data->deposit_amount . '.',
        );
        $send_email = $this->common_model->send_email($post);

        if ($send_email) {
            $n = array(
                'user_id'                => $this->session->userdata('user_id'),
                'subject'                => display('deposit'),
                'notification_type'      => 'deposit',
                'details'                => 'You Deposit The Amount Is ' . $data->deposit_amount . '.',
                'date'                   => date('Y-m-d h:i:s'),
                'status'                 => '0'
            );
            $this->db->insert('notifications', $n);
        }

        $this->load->library('sms_lib');
        $template = array(
            'name'      => $this->session->userdata('fullname'),
            'amount'    => $data->deposit_amount,
            'date'      => date('d F Y')
        );

        #------------------------------
        #   SMS Sending
        #------------------------------
        $send_sms = $this->sms_lib->send(array(
            'to'              => $this->session->userdata('phone'),
            'template'        => 'Hi, %name% You Deposit The Amount Is %amount% ',
            'template_config' => $template,
        ));

        if ($send_sms) {

            $message_data = array(
                'sender_id' => 1,
                'receiver_id' => $this->session->userdata('user_id'),
                'subject' => 'Deposit',
                'message' => 'Hi,' . $this->session->userdata('fullname') . ' You Deposit The Amount Is ' . $data->deposit_amount,
                'datetime' => date('Y-m-d h:i:s'),
            );

            $this->db->insert('message', $message_data);
        }

        $this->session->set_flashdata('message', display('deopsit_add_msg'));
        redirect('shareholder/deposit');
    }



    /*
|-------------------------------------
|   View profile 
|-------------------------------------
*/
    public function profile()
    {
        $data['title'] = display('profile');
        $data['user']  = $this->home_model->profile($this->session->userdata('id'));
        $data['content'] = $this->load->view('backend/dashboard/profile', $data, true);
        $this->load->view('backend/layout/main_wrapper', $data);
    }

    /*
|-------------------------------------
|   Update profile 
|-------------------------------------
*/
    public function edit_profile()
    {
        $data['title']    = display('edit_profile');
        $id = $this->session->userdata('id');
        /*-----------------------------------*/
        $this->form_validation->set_rules('firstname', display('first_name'), 'required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('lastname', display('last_name'), 'required|max_length[50]|xss_clean');
        #------------------------#
        $this->form_validation->set_rules('email', display('email_address'), "required|valid_email|max_length[100]|xss_clean");
        $this->form_validation->set_rules('password', display('password'), 'required|max_length[32]|md5|xss_clean');
        $this->form_validation->set_rules('about', display('about'), 'max_length[1000]|xss_clean');
        /*-----------------------------------*/
        //set config 
        $config = [
            'upload_path'   => './assets/images/uploads/',
            'allowed_types' => 'gif|jpg|png|jpeg',
            'overwrite'     => false,
            'maintain_ratio' => true,
            'encrypt_name'  => true,
            'remove_spaces' => true,
            'file_ext_tolower' => true
        ];
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $data = $this->upload->data();
            $image = $config['upload_path'] . $data['file_name'];

            $config['image_library']  = 'gd2';
            $config['source_image']   = $image;
            $config['create_thumb']   = false;
            $config['encrypt_name'] = TRUE;
            $config['width']          = 115;
            $config['height']         = 90;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->session->set_flashdata('message', display("image_upload_successfully"));
        }
        /*-----------------------------------*/
        $data['user'] = (object)$userData = array(
            'id'          => $this->input->post('id', TRUE),
            'firstname'   => $this->input->post('firstname', TRUE),
            'lastname'    => $this->input->post('lastname', TRUE),
            'email'       => $this->input->post('email', TRUE),
            'password'    => md5($this->input->post('password', TRUE)),
            'about'       => $this->input->post('about', true),
            'image'       => (!empty($image) ? $image : $this->input->post('old_image', TRUE))
        );

        /*-----------------------------------*/
        if ($this->form_validation->run()) {

            if (empty($userData['image'])) {
                $this->session->set_flashdata('exception', $this->upload->display_errors());
            }

            if ($this->home_model->update_profile($userData)) {
                $this->session->set_userdata(array(
                    'fullname'   => $this->input->post('firstname', TRUE) . ' ' . $this->input->post('lastname', TRUE),
                    'email'       => $this->input->post('email', TRUE),
                    'image'       => (!empty($image) ? $image : $this->input->post('old_image', TRUE))
                ));
                $this->session->set_flashdata('message', display('update_successfully'));
            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }
            redirect("backend/dashboard/home/edit_profile");
        } else {
            $data['user']   = $this->home_model->profile($id);
            $data['content'] = $this->load->view('backend/dashboard/edit_profile', $data, true);
            $this->load->view('backend/layout/main_wrapper', $data);
        }
    }
}