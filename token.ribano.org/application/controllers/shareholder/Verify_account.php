<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify_account extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
  
        if (!$this->session->userdata('isLogIn')) 
        redirect('login');

        if (!$this->session->userdata('user_id')) 
        redirect('login');  
 
		$this->load->model(array(
            
            'shareholder/deposit_model',
            'website/web_model',
        ));  
	}


    public function index()
    {   
    	$data['title']   = display('verify_account');

    	$date = new DateTime();
        $submit_time = $date->format('Y-m-d H:i:s');

        $this->form_validation->set_rules('verify_type', display('verify_type'),'required|trim|xss_clean');
        $this->form_validation->set_rules('first_name', display('first_name'),'required|trim|xss_clean');
        $this->form_validation->set_rules('last_name', display('last_name'),'required|trim|xss_clean');
        $this->form_validation->set_rules('gender', display('gender'),'required|trim|xss_clean');
        $this->form_validation->set_rules('id_number', display('id_number'),'required|trim|xss_clean');

        $user_id = $this->session->userdata('user_id');
        

        //From Validation Check
        if ($this->form_validation->run()) 
        {
            //Set Upload File Config 
            $config = [
                'upload_path'       => 'upload/documents/',
                'allowed_types'     => 'jpg|png|jpeg', 
                'overwrite'         => false,
                'maintain_ratio'    => true,
                'encrypt_name'      => true,
                'remove_spaces'     => true,
                'file_ext_tolower'  => true 
            ];

            $document1="";
            $document2="";

            $document1 = $this->upload_lib->do_upload(
                'upload/documents/',
                'document1'
            );
            $document2 = $this->upload_lib->do_upload(
                'upload/documents/',
                'document2'
            );


            $data['verify_info']   = (object)$verify_info = array(
                'user_id'     => $this->session->userdata('user_id'),
                'verify_type' => $this->input->post('verify_type',TRUE), 
                'first_name'  => $this->input->post('first_name',TRUE),
                'last_name'   => $this->input->post('last_name',TRUE),
                'gender'      => $this->input->post('gender',TRUE),
                'id_number'   => $this->input->post('id_number',TRUE),
                'document1'   => $document1,
                'document2'   => $document2,
                'date'        => $submit_time
            );

            if ($this->web_model->userVerifyDataStore($verify_info)) {

                //Update User table for Verify Processing
                $this->db->set('verified', '3')->where('user_id', $this->session->userdata('user_id'))->update("dbt_user");
                $this->session->set_flashdata('message', display('verification_is_being_processed'));

            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));

            }

            redirect("shareholder/verify_account");
        }

        $data['verify_status'] = $this->db->select('verified')
                                    ->from('dbt_user')
                                    ->where('user_id',$user_id)
                                    ->get()
                                    ->row();
                                    
        $data['content'] = $this->load->view('shareholder/pages/verify_account', $data, true);
        $this->load->view('shareholder/layout/main_wrapper', $data);
    
    }


}