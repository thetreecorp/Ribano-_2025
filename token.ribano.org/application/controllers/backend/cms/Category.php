<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();

 		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

 		$this->load->model(array(
 			'backend/cms/category_model',
 			'backend/cms/language_model',

 		)); 
 				
 	}
 
	public function index()
	{  
		$data['title']  = display('cat_list');
 		
 		/******************************
        * Pagination Start
        ******************************/
        $config["base_url"] = base_url('backend/cms/category/index');
        $config["total_rows"] = $this->db->count_all('web_category');
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
        $data['category'] = $this->category_model->read($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        /******************************
        * Pagination ends
        ******************************/

        $data['blog_info']	  = $this->db->select('cat_id')->from('web_category')->where('slug','blog')->get()->row();

		$data['content'] = $this->load->view("backend/category/list", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);

	}

	public function slug_check($cat_name_en, $cat_id)
    { 
        $packageExists = $this->db->select('*')
            ->where('cat_name_en',$cat_name_en) 
            ->where_not_in('cat_id',$cat_id) 
            ->get('web_category')
            ->num_rows();

        if ($packageExists > 0) {
            $this->form_validation->set_message('cat_name_en', 'The {field} is already registered.');
            return false;
            
        } else {
            return true;

        }

    }
 
	public function form($cat_id = null)
	{ 
		$data['title']  = display('add_cat');
		$data['web_language'] = $this->language_model->single('1');

		$this->form_validation->set_rules('cat_name', display('category_name'),'required|xss_clean');
		$this->form_validation->set_rules('position_serial', display('position_serial'),'required|trim|xss_clean');

		$data['category']   = (object)$userdata = array(
			'cat_id'      	=> $this->input->post('cat_id',TRUE),
			'slug'      	=> $this->input->post('cat_name',TRUE),
			'parent_id' 	=> $this->input->post('parent_id',TRUE),
			'position_serial'=> $this->input->post('position_serial',TRUE),
			'status' 		=> $this->input->post('status',TRUE)
		);
		
		//From Validation Check
		if ($this->form_validation->run()) 
		{

			if (empty($cat_id)) 
			{
				if ($this->category_model->create($userdata)) {
					$this->session->set_flashdata('message', display('save_successfully'));

				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));

				}
				redirect("backend/cms/category/form");

			} 
			else 
			{
				if ($this->category_model->update($userdata)) {
					$this->session->set_flashdata('message', display('update_successfully'));

				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));

				}
				redirect("backend/cms/category/form/$cat_id");

			}

		} 
		else
		{
			$data['parent_menu'] = $this->category_model->getParentId();
			if(!empty($cat_id)) {
				$data['title'] = display('edit_cat');
				$data['category']   = $this->category_model->single($cat_id);

			}

		}

		$data['content'] = $this->load->view("backend/category/form", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);

	}


	public function delete($cat_id = null)
	{

		$checkmainmenu = $this->db->select('link')->from('web_category')->where('cat_id', $cat_id)->get()->row();
		$cat_cont = $this->db->select('cat_id')->from('web_article')->where('cat_id', $cat_id)->get()->num_rows();
        
        if (!empty($checkmainmenu->link)) {
			$this->session->set_flashdata('exception', display('this_category_not_permission_for_delete'));
			redirect("backend/cms/category/");

		}
		if ($cat_cont>0) {
			$this->session->set_flashdata('exception', display('this_category_containt_exist'));
			redirect("backend/cms/category/");

		}
		if($cat_id==5){
			$this->session->set_flashdata('exception', display('this_category_not_permission_for_delete'));
			redirect("backend/cms/category/");
		}

		if ($this->category_model->delete($cat_id)) {
			$this->session->set_flashdata('message', display('delete_successfully'));

		} else {
			$this->session->set_flashdata('exception', display('please_try_again'));

		}
		redirect("backend/cms/category/");

	}


}
