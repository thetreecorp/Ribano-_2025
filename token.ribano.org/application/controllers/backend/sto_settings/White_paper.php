<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class White_paper extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('isAdmin')) 
        	redirect('logout');

		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');
        $this->load->model('common_model');
	}

	public function index()
	{
		$data['title'] 	  = display('white_paper');
        $data['userrole'] = $this->common_model->getMenuSingelRoleInfo(24);
		$data['white_paper'] = $this->db->select('white_paper')->from('dbt_sto_setup')->get()->row();
		$data['content'] = $this->load->view("backend/white_paper/white_paper", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}

	public function form()
	{
        $config = [
            'upload_path'   	=> 'upload/pdf/',
            'allowed_types' 	=> 'pdf',
            'max_size'			=> 20480,
            'overwrite'     	=> false,
            'maintain_ratio' 	=> true,
            'encrypt_name'  	=> true,
            'remove_spaces' 	=> true,
            'file_ext_tolower' 	=> true
        ];

        $this->load->library('upload');
        $this->upload->initialize($config);

        if( ! $this->upload->do_upload('white_paper_pdf'))
    	{
            $this->session->set_flashdata('exception',$this->upload->display_errors());
        }
        else
        {
            $data = $this->upload->data();  
            $urlLink = $config['upload_path'].$data['file_name'];

            $this->db->set('white_paper',$urlLink)->update('dbt_sto_setup');
			$this->session->set_flashdata('message',display('update_successfully'));
        }
        redirect('backend/sto_settings/white_paper');
	}
	
	
}