<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_verify extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('isverifyLogin'))
            redirect('shareholder');

        $this->load->model(array(
            'common_model'
        ));
    }

    public function index()
    {
        $data['title'] = display('verify_login');
        $this->load->helper(array('cookie'));

        //Set Rules From validation
        $this->form_validation->set_rules('token', display('token'), 'required|max_length[6]|trim');

        //From Validation Check
        if ($this->form_validation->run()) {
            $user_id = $this->session->userdata('isverifyId');
            if ($this->session->userdata('isverifyMedia') == "googleauth") {
                // 2 factor authentication codes.
                $this->load->library('GoogleAuthenticator');
                $query = $this->db->select('googleauth')->from('dbt_user')->where('user_id',  $user_id)->get()->row();
                $appSetting = $this->common_model->get_setting();

                $ga                 = new GoogleAuthenticator();
                $secret             = $query->googleauth;
                $qrCodeUrl          = $ga->getQRCodeGoogleUrl($appSetting->title, $secret);
                $data['qrCodeUrl']  = $qrCodeUrl;
                $oneCode = $this->input->post('token', TRUE);
                $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
                if ($checkResult) {

                    $this->session->unset_userdata('wrong_login');
                    delete_cookie('wrong_loginx');
                    delete_cookie('wrong_login');

                    $user = $this->db->select('*')->from('dbt_user')->where('user_id', $user_id)->get()->row();

                    $sData = array(
                        'isLogIn'     => true,
                        'id'          => $user->id,
                        'user_id'     => $user->user_id,
                        'fullname'    => $user->first_name . ' ' . $user->last_name,
                        'image'       => $user->image,
                        'email'       => $user->email,
                    );

                    //store date to session 
                    $this->session->set_userdata($sData);
                    //update database status
                    //welcome message
                    $this->session->set_flashdata('message', display('welcome_back') . ' ' . $user->first_name . ' ' . $user->last_name);
                    $this->session->unset_userdata('isverifyId');
                    $this->session->unset_userdata('isverifyLogin');
                    $this->session->unset_userdata('isverifyMedia');

                    redirect('shareholder/home');
                } else {

                    $this->session->set_flashdata('exception', display('invalid_authentication_code'));
                    $this->session->unset_userdata('isverifyId');
                    $this->session->unset_userdata('isverifyLogin');
                    $this->session->unset_userdata('isverifyMedia');
                    redirect('shareholder');
                }
            } else if ($this->session->userdata('isverifyMedia') == "smsauth") {

                $oneCode = $this->input->post('token', TRUE);
                $checkResult = $this->db->select('smsauth')->from('dbt_user')->where('user_id', $user_id)->where('smsauth', $oneCode)->get()->row();
                if (!empty($checkResult)) {

                    $this->session->unset_userdata('wrong_login');
                    delete_cookie('wrong_loginx');
                    delete_cookie('wrong_login');

                    $user = $this->db->select('*')->from('dbt_user')->where('user_id', $user_id)->get()->row();

                    $sData = array(
                        'isLogIn'     => true,
                        'id'          => $user->id,
                        'user_id'     => $user->user_id,
                        'fullname'    => $user->first_name . ' ' . $user->last_name,
                        'image'       => $user->image,
                        'email'       => $user->email,
                    );

                    //store date to session 
                    $this->session->set_userdata($sData);
                    //update database status
                    //welcome message
                    $this->session->set_flashdata('message', display('welcome_back') . ' ' . $user->first_name . ' ' . $user->last_name);
                    $this->session->unset_userdata('isverifyId');
                    $this->session->unset_userdata('isverifyLogin');
                    $this->session->unset_userdata('isverifyMedia');

                    redirect('shareholder/home');
                } else {

                    $this->session->set_flashdata('exception', display('invalid_authentication_code'));
                    $this->session->unset_userdata('isverifyId');
                    $this->session->unset_userdata('isverifyLogin');
                    $this->session->unset_userdata('isverifyMedia');
                    redirect('shareholder');
                }
            } else {

                $oneCode = $this->input->post('token', TRUE);
                $checkResult = $this->db->select('smsauth')->from('dbt_user')->where('user_id', $user_id)->where('smsauth', $oneCode)->get()->row();
                if (!empty($checkResult)) {
                    $this->db->where('user_id', $user_id)->set('status', 1)->set('smsauth', NULL)->update('dbt_user');
                    $this->session->set_flashdata('message', 'Your account activated successfully. Now you can login to your account.');
                    redirect('shareholder');
                } else {
                    $this->session->set_flashdata('exception', 'Invalid Verification Code.');
                    redirect('shareholder/login_verify');
                }
            }
        }

        $this->load->view("shareholder/pages/login_verify", $data);
    }
}