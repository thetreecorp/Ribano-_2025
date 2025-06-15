<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Twoauthentication extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
  
        if (!$this->session->userdata('isLogIn')) 
        redirect('shareholder');

        $this->load->model(array(
            'common_model'
        ));

    }

    public function index()
    {
        $data['title']      = display('two_factor_authentication');
        $user_id = $this->session->userdata('user_id');

        //Set Rules From validation
        $this->form_validation->set_rules('twoauthentication', display('authenticate'), 'required|xss_clean');
        $this->form_validation->set_rules('password', display('password'), 'required|xss_clean');
        
        //From Validation Check
        if ($this->form_validation->run())
        {
            
            $authenticator = $this->input->post('twoauthentication',TRUE);
            $password = $this->input->post('password',TRUE);
            $password = md5($password);
            
            $check = $this->db->select('*')->from('dbt_user')->where('user_id',$user_id)->where('password',$password)->get()->num_rows();
            
            if($check>0){
                $this->session->set_userdata(['isauthLogin'=>true]);
                if($authenticator=="googleauthenticator"){
                    redirect('shareholder/googleauth');
                }
                else if($authenticator=="smsauthenticator"){
                    redirect('shareholder/twoauthentication/smsauth');
                }
                else{
                    $this->session->set_flashdata('exception',display('invalid_authentication'));
                }
            }
            else{
                $this->session->set_flashdata('exception',display('invalid_password'));
            }
            
        }
        
        $data['get_auth_getway_email'] = $this->db->select('authentication')->from('sms_email_send_setup')->where('method','email')->get()->row();
        $data['get_auth_getway_sms']   = $this->db->select('authentication')->from('sms_email_send_setup')->where('method','sms')->get()->row();
        
        $data['select_auth'] = $this->db->select('googleauth,smsauth')->from('dbt_user')->where('user_id',$user_id)->get()->row();

        $data['content'] = $this->load->view("shareholder/pages/twoauthentication", $data, true);
        $this->load->view("shareholder/layout/main_wrapper", $data);
    }

    public function smsauth()
    {
        if($this->session->userdata('isauthLogin')){
            $user_id = $this->session->userdata('user_id');
            $userphone = $this->db->select('phone')->from('dbt_user')->where('user_id',$user_id)->get()->row();
            if(!empty($userphone->phone)){
                
                $this->db->where('user_id',$user_id)->set('smsauth',1)->update('dbt_user');
                $this->db->where('user_id',$user_id)->set('googleauth',NULL)->update('dbt_user');
                $this->session->set_flashdata('message','SMS Authenticator update successfully.');
                
            }
            else{
                $this->session->set_flashdata('exception',display('setup_your_phone_number_in_profile'));
            }
            
            $this->session->unset_userdata('isauthLogin');
            redirect('shareholder/twoauthentication');
        }
        else{
            redirect('shareholder/twoauthentication');
        }
    }

}