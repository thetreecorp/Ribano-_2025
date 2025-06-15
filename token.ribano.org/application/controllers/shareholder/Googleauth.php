<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Googleauth extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
  
        if (!$this->session->userdata('isLogIn')) 
        redirect('shareholder');
        if (!$this->session->userdata('isauthLogin')) 
        redirect('shareholder/twoauthentication');
        $this->load->model(array(
            'common_model'
        ));

    }

    public function index()
    {
        $data['title']      = $this->uri->segment(1);

        // 2 factor authentication codes.
        $this->load->library('GoogleAuthenticator');

        $ga = new GoogleAuthenticator();

        $query = $this->db->select('googleauth')->from('dbt_user')->where('user_id', $this->session->userdata('user_id'))->get()->row();
        $appSetting = $this->common_model->get_setting();

        if ($query->googleauth!='') {
            $secret = $query->googleauth;
            $data['btnenable'] = 0;

        }else{
            $secret = $ga->createSecret();
            $data['btnenable'] = 1;

        }
        
        $data['secret'] = $secret;

        $qrCodeUrl = $ga->getQRCodeGoogleUrl($appSetting->title, $secret);
        //echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."\n\n";
        $data['qrCodeUrl'] = $qrCodeUrl;


        //Set Rules From validation
        $this->form_validation->set_rules('token', display('token'), 'required|max_length[6]|trim|xss_clean');
        $this->form_validation->set_rules('secret', display('secret'), 'required|max_length[16]|trim|xss_clean');
        
        //From Validation Check
        if ($this->form_validation->run())
        {
            if (isset($_POST['disable'])) {
                $oneCode = $this->input->post('token', TRUE);
                $secret = $query->googleauth;
                $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance

                if ($checkResult) {
                    $secret = NULL;
                    $this->db->set('googleauth', $secret)->where('user_id', $this->session->userdata('user_id'))->update("dbt_user");
                    $this->session->set_flashdata('message', display('google_authenticator_disabled'));
                    redirect("shareholder/twoauthentication");

                } else {

                    $this->session->set_flashdata('exception', display('invalid_authentication_code'));
                    redirect("shareholder/twoauthentication");

                }
            }

            if (isset($_POST['enable'])) {
                $oneCode = $this->input->post('token', TRUE);
                $secret = $this->input->post('secret', TRUE);
                $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
                
                if ($checkResult) {
                    $this->db->set('googleauth', $secret)->where('user_id', $this->session->userdata('user_id'))->update("dbt_user");
                    $this->db->set('smsauth', NULL)->where('user_id', $this->session->userdata('user_id'))->update("dbt_user");
                    $this->session->set_flashdata('message', display('google_authenticator_enabled'));
                    redirect("shareholder/twoauthentication");

                } else {

                    $this->session->set_flashdata('exception', display('invalid_authentication_code'));
                    redirect("shareholder/twoauthentication");

                }
            }
            $this->session->unset_userdata('isauthLogin');
            
        }

        $data['content'] = $this->load->view("shareholder/pages/googleauthenticator", $data, true);
        $this->load->view("shareholder/layout/main_wrapper", $data);
    }

}