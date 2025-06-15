<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_shareholder extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        
        if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
        
        if (!$this->session->userdata('isLogin') 
            && !$this->session->userdata('isAdmin'))
            redirect('admin');

        $this->load->model(array(
            'backend/user/user_model',
            'shareholder/transections_model',
            'common_model'
        ));
    }

    public function index($id = null)
    { 
        $data['title']  = display('add_user');
        $data['userrole'] = $this->common_model->getMenuSingelRoleInfo(9);


        $this->form_validation->set_rules('first_name', display('firstname'),'required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('mobile', display('mobile'),'is_unique[dbt_user.phone]|max_length[100]|xss_clean');

        if (!empty($id)) {   
            $this->form_validation->set_rules('email', display('email_address'), "required|valid_email|max_length[100]|callback_email_check[$id]|trim|xss_clean"); 
        } else {
            $this->form_validation->set_rules('email', display('email'),'required|valid_email|is_unique[dbt_user.email]|max_length[100]|xss_clean');
        }

        $this->form_validation->set_rules('password', display('password'),'required|min_length[6]|max_length[32]|md5|xss_clean');
        $this->form_validation->set_rules('conf_password', display('conf_password'),'required|min_length[6]|max_length[32]|md5|matches[password]|xss_clean');
        $this->form_validation->set_rules('status', display('status'),'required|max_length[1]|xss_clean');
        $this->form_validation->set_rules('referral_id', 'Referral Id','exact_length[6]|xss_clean|alpha_numeric');

        if (empty($id))
        { 
            $data['user'] = (object)$userdata = array(
                'id'          => $this->input->post('id',TRUE),
                'user_id'     => $this->randomID(),
                'referral_id' => $this->input->post('referral_id',TRUE),
                'first_name'  => $this->input->post('first_name',TRUE),
                'last_name'   => $this->input->post('last_name',TRUE),
                'email'       => $this->input->post('email',TRUE),
                'password'    => md5($this->input->post('password',TRUE)),
                'phone'       => $this->input->post('mobile',TRUE),
                'ip'          => $this->input->ip_address(),
                'status'      => $this->input->post('status',TRUE),
            );
        }
        else
        {
            $data['user'] = (object)$userdata = array(
                'id'          => $this->input->post('id',TRUE),
                'user_id'     => $this->input->post('user_id',TRUE),
                'first_name'  => $this->input->post('first_name',TRUE),
                'last_name'   => $this->input->post('last_name',TRUE),
                'email'       => $this->input->post('email',TRUE),
                'password'    => md5($this->input->post('password',TRUE)),
                'phone'       => $this->input->post('mobile',TRUE),
                'ip'          => $this->input->ip_address(),
                'status'      => $this->input->post('status',TRUE),
            );
        }

        if ($this->form_validation->run()) 
        {

            if (empty($id)) 
            {
                if ($this->user_model->create($userdata)) {
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect("backend/shareholders/add_shareholder");

            } 
            else 
            {
                if ($this->user_model->update($userdata)) {
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect("backend/shareholders/add_shareholder/index/$id");
            }
        } 
        else 
        { 
            if(!empty($id)) {
                $data['title'] = display('edit_user');
                $data['user']   = $this->user_model->single($id);
            }
            
            $data['content'] = $this->load->view("backend/shareholders/add_shareholder", $data, true);
            $this->load->view("backend/layout/main_wrapper", $data);
        }
    }

    public function email_check($email, $id)
    { 
        $emailExists = $this->db->select('email')
            ->where('email',$email) 
            ->where_not_in('id',$id) 
            ->get('dbt_user')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} is already registered.');
            return false;
        } else {
            return true;
        }
    }

    /*
    |----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
    */
    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if($mode == 1):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 2):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif($mode == 3):
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 4):
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++) {
                $randItem = array_rand($charArray);
                $result .="".$charArray[$randItem];
        }
        return $result;
    }
    /*
    |----------------------------------------------
    |         Ends of id genaretor
    |----------------------------------------------
    */


}
