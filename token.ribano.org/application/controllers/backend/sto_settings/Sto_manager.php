<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sto_manager extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();
 		
 		if (!$this->session->userdata('isAdmin')) 
                redirect('logout');
 		
		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

        $this->load->model(array(
            'backend/sto_manager_model',
            'common_model' 
        ));
 	}
 
	public function index($id = 1)
	{

        $data['title']    = display('sto_manager');
        $data['userrole'] = $this->common_model->getMenuSingelRoleInfo(21);

        $this->form_validation->set_rules('secured_sto', display('secured_sto'),'required|trim|xss_clean');
        $this->form_validation->set_rules('non_secured_sto', display('non_secured_sto'),'required|trim|xss_clean');
        $this->form_validation->set_rules('guaranteed_sto', display('guaranteed_sto'),'required|trim|xss_clean');

        $data['sto_manager'] = (object)$userdata = array(
            'id'            => $this->input->post('id',TRUE),
            'secured'       => $this->input->post('secured_sto',TRUE),
            'non_secured'   => $this->input->post('non_secured_sto',TRUE),
            'guaranteed'    => $this->input->post('guaranteed_sto',TRUE)
        );

        if ($this->form_validation->run()) 
        {
            $secured_sto     = $this->input->post('secured_sto',TRUE);
            $non_secured_sto = $this->input->post('non_secured_sto',TRUE);
            $guaranteed_sto  = $this->input->post('guaranteed_sto',TRUE);

            if($secured_sto<=0 || $non_secured_sto<=0 || $guaranteed_sto<=0){
                $this->session->set_flashdata('exception', display('invalid_amount'));
                redirect("backend/sto_settings/sto_manager/index/$id");
            }

            if ($this->sto_manager_model->update($userdata)) {
                $this->session->set_flashdata('message', display('update_successfully'));

            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));

            }
            redirect("backend/sto_settings/sto_manager/index/$id");
            
        }


        if(!empty($id)) {
            $data['title']       = display('sto_manager');
            $data['sto_manager'] = $this->sto_manager_model->single($id);
        }

        $data['content'] = $this->load->view("backend/sto_manager/form", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);


	}
	

}
