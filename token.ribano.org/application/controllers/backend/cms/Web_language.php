<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_language extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();

 		if (!$this->session->userdata('isAdmin')) 
        	redirect('logout');

		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

 		$this->load->model(array(
 			'backend/cms/language_model',

 		));

 	}
 
	public function index($id="")
	{
		$this->load->library('Lang_lib');
		$data['lang_list']  = $this->lang_lib->language_list();
		$data['flag_list']  = $this->language_model->flag_list();
	
		$this->form_validation->set_rules('lang_name',display('language_name'),'required|xss_clean');
		$this->form_validation->set_rules('flag', display('flag'),'required|xss_clean');

		if ($this->form_validation->run()) 
		{

			$lang_data 	= $this->input->post('lang_name',TRUE);
			$lang_data	= explode(".",$lang_data);
			$lang_name 	= $lang_data[0];
			$iso_code 	= $lang_data[1];
			$flag 		= $this->input->post('flag',TRUE);
			$querydata  = array('language_name'=>$lang_name,'iso'=>$iso_code,'flag'=>$flag);

			if($this->language_model->checkExistsLang($querydata)>0)
			{
				$this->session->set_flashdata('exception',display('language_or_iso_all_ready_exists'));
			}
			else{
				if($this->language_model->add($querydata)){

					$this->session->set_flashdata('message',display('language_add_successfully'));
				}
				else{
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
			}
			
			redirect("backend/cms/web_language");

		}

		$data['title']  	= display('web_language');
		
		$data['content'] = $this->load->view("backend/article/language", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}

	public function language_list()
	{
		$data['title']    = display('language_list');
		$data['language'] = $this->language_model->lang_list();
		$data['content']  = $this->load->view("backend/article/language_list", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}

	//Delete Language 
	public function delete($id="")
	{
		$result = $this->db->where('id',$id)->delete('web_language');
		if($result){
			//Delete This Language All Data
			$this->db->where('lang_id',$id)->delete('web_language_data');
			$this->session->set_flashdata('exception',display('delete_successfully'));
		}
		redirect('backend/cms/web_language/language_list');
	}


}
