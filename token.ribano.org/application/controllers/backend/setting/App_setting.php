<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_setting extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

		if (!$this->session->userdata('isLogIn') 
			&& !$this->session->userdata('isAdmin')
		) 
		redirect('admin'); 
		
		$this->load->model(array(
			'backend/dashboard/setting_model',
			'common_model'
		));
		
	}
 
 
	public function index()
	{
		$data['title'] = display('application_setting');
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(25);
		$this->check_setting();
		#-------------------------------#
		$this->form_validation->set_rules('title',display('website_title'),'required|max_length[50]|xss_clean');
		$this->form_validation->set_rules('description', display('address') ,'max_length[255]|xss_clean');
		$this->form_validation->set_rules('email',display('email'),'max_length[100]|valid_email|xss_clean');
		$this->form_validation->set_rules('phone',display('phone'),'max_length[20]|xss_clean');
		$this->form_validation->set_rules('language',display('language'),'max_length[250]|xss_clean'); 
		$this->form_validation->set_rules('footer_text',display('footer_text'),'max_length[255]|xss_clean'); 
		$this->form_validation->set_rules('time_zone',display('time_zone'),'required|max_length[100]|xss_clean'); 
		#-------------------------------#
		//logo upload
		$logo = $this->upload_lib->do_upload(
			'upload/settings/',
			'logo'
		);
		// if logo is uploaded then resize the logo
		if ($logo !== false && $logo != null) {
			$this->upload_lib->do_resize(
				$logo, 
				181,
				46
			);
		}
		//if logo is not uploaded
		if ($logo === false) {
			$this->session->set_flashdata('exception', display('invalid_logo'));
		}

		//Web logo_web upload
		$logo_web = $this->upload_lib->do_upload(
			'upload/settings/',
			'logo_web'
		);
		// if logo_web is uploaded then resize the logo_web
		if ($logo_web !== false && $logo_web != null) {
			$this->upload_lib->do_resize(
				$logo_web, 
				150,
				40
			);
		}
		//if logo_web is not uploaded
		if ($logo_web === false) {
			$this->session->set_flashdata('exception', display('invalid_logo'));
		}


		//favicon upload
		$favicon = $this->upload_lib->do_upload(
			'upload/settings/',
			'favicon'
		);
		// if favicon is uploaded then resize the favicon
		if ($favicon !== false && $favicon != null) {
			$this->upload_lib->do_resize(
				$favicon, 
				32,
				32
			);
		}
		//if favicon is not uploaded
		if ($favicon === false) {
			$this->session->set_flashdata('exception',  display('invalid_favicon'));
		}		
		#-------------------------------#

		$data['setting'] = (object)$postData = [
			'setting_id'  => $this->input->post('setting_id',TRUE),
			'title' 	  => $this->input->post('title',TRUE),
			'description' => $this->input->post('description', TRUE),
			'email' 	  => $this->input->post('email',TRUE),
			'phone' 	  => $this->input->post('phone',TRUE),
			'logo' 	      => (!empty($logo)?$logo:$this->input->post('old_logo',TRUE)),
			'logo_web' 	  => (!empty($logo_web)?$logo_web:$this->input->post('old_web_logo',TRUE)),
			'favicon' 	  => (!empty($favicon)?$favicon:$this->input->post('old_favicon',TRUE)),
			'language'    => $this->input->post('language',TRUE), 
			'time_zone'   => $this->input->post('time_zone',TRUE), 
			'site_align'  => $this->input->post('site_align',TRUE), 
			'office_time' => $this->input->post('office_time',TRUE), 
			'latitude' 	  => $this->input->post('latitude',TRUE), 
			'footer_text' => $this->input->post('footer_text', TRUE),
		]; 
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $setting_id then insert data
			if (empty($postData['setting_id'])) {
				if ($this->setting_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message',display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
			} else {
				if ($this->setting_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message',display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				} 
			} 
			redirect('backend/setting/app_setting');

		} else {  
			$data['languageList'] = $this->languageList(); 
			$data['setting'] = $this->setting_model->read();
			$data['content'] = $this->load->view('backend/dashboard/setting',$data,true);
			$this->load->view('backend/layout/main_wrapper',$data);

		} 

	}

	//check setting table row if not exists then insert a row
	public function check_setting()
	{
		if ($this->db->count_all('setting') == 0) {
			$this->db->insert('setting',[
				'title' => 'bdtask Treading System',
				'description' => '123/A, Street, State-12345, Demo',
				'time_zone' => 'Asia/Dhaka',
				'footer_text' => '2018&copy;Copyright',
			]);

		}

	}

	public function languageList()
    { 
        if ($this->db->table_exists("language")) { 

                $fields = $this->db->field_data("language");

                $i = 1;
                foreach ($fields as $field)
                {  
                    if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
                }

                if (!empty($result)) return $result;
 

        } else {
            return false;

        }
    }

}