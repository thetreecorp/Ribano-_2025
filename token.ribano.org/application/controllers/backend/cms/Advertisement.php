<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisement extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();

 		if (!$this->session->userdata('isAdmin')) 
        	redirect('logout');

		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

 		$this->load->model(array(
 			'backend/cms/advertisement_model',
 			'backend/cms/category_model',

 		));

 	}
 
	public function index()
	{
		$data['title']  = display('advertisement');

 		/******************************
        * Pagination Start
        ******************************/
        $config["base_url"] = base_url('backend/cms/advertisement/index');
        $config["total_rows"] = $this->db->count_all('advertisement');
        $config["per_page"] = 25;
        $config["uri_segment"] = 5;
        $config["last_link"] = "Last"; 
        $config["first_link"] = "First"; 
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';  
        $config['full_tag_open'] = "<ul class='pagination col-xs pull-right'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $data['advertisement'] = $this->advertisement_model->read($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        /******************************
        * Pagination ends
        ******************************/

		$data['content'] = $this->load->view("backend/advertisement/list", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);

	}
 
	public function form($id = null)
	{ 
		$data['title']  = display('add_advertisement');

		//Set Rules From validation
		$this->form_validation->set_rules('page', display('page'),'required|trim|xss_clean');
		$this->form_validation->set_rules('add_type', display('add_type'),'required|trim|xss_clean');
		$this->form_validation->set_rules('serial_position', display('position_serial'),'required|trim|max_length[10]|xss_clean');

		if (!empty($id)) {
			if ($this->db->select("*")->from('advertisement')->where('page', $this->input->post('page',TRUE))->where('serial_position', $this->input->post('serial_position',TRUE))->where_not_in('id',$id)->get()->row()) {
				$this->session->set_flashdata('exception', display('already_exists'));
				redirect("backend/cms/advertisement/form/$id");
			}

		} else {
			if ($this->db->select("*")->from('advertisement')->where('page', $this->input->post('page',TRUE))->where('serial_position', $this->input->post('serial_position',TRUE))->get()->row()) {
				$this->session->set_flashdata('exception', display('already_exists'));
				redirect("backend/cms/advertisement/form");
			}
		}		
		if ($this->input->post('add_type',TRUE)=='code') {
			$this->form_validation->set_rules('script', display('script'),'required|xss_clean');

		}

        $image = $this->upload_lib->do_upload(
			'upload/advertisement/',
			'image'
		);

		$data['advertisement']   = (object)$advertisementdata = array(
			'id'      			=> $this->input->post('id',TRUE),
			'name'   			=> $this->input->post('name',TRUE),
			'page' 				=> $this->input->post('page',TRUE), 
			'image'  			=> (!empty($image)?$image:$this->input->post('image_old',TRUE)),
			'script' 			=> $this->input->post('script',TRUE),
			'url' 				=> $this->input->post('url',TRUE),
			'serial_position' 	=> $this->input->post('serial_position',TRUE),
			'status' 			=> $this->input->post('status',TRUE)
		);

		//From Validation Check
		if ($this->form_validation->run()) 
		{

			if (empty($advertisementdata['image']) && $this->session->flashdata('exception') == null) {
				$this->session->set_flashdata('exception', display('you_did_not_upload_any_file'));
	        }

			if (empty($id))
			{
				if ($this->advertisement_model->create($advertisementdata)) {
					$this->session->set_flashdata('message', display('save_successfully'));

				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));

				}
				redirect("backend/cms/advertisement/form");

			} 
			else 
			{

				if ($this->advertisement_model->update($advertisementdata)) {
					$this->session->set_flashdata('message', display('update_successfully'));

				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));

				}
				redirect("backend/cms/advertisement/form/$id");

			}

		}
		else {
			$data['parent_cat'] = $this->category_model->all();
			if(!empty($id)) {				
				$data['title'] = display('edit_advertisement');
				$data['advertisement']   = $this->advertisement_model->single($id);

			}
		}

		$data['content'] = $this->load->view("backend/advertisement/form", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);

	}

	public function delete($id = null)
	{  
		if ($this->advertisement_model->delete($id)) {
			$this->session->set_flashdata('message', display('delete_successfully'));

		} else {
			$this->session->set_flashdata('exception', display('please_try_again'));

		}
		redirect("backend/cms/advertisement/");

	}

}