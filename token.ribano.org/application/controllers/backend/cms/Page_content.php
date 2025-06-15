<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_content extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();

 		if (!$this->session->userdata('isAdmin')) 
        	redirect('logout');

		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

 		$this->load->model(array(
 			'backend/cms/article_model',
 			'backend/cms/category_model',
 			'backend/cms/language_model',

 		));

 	}
 
	public function index()
	{  
		$data['title']  = display('content_list');
 		
 		/******************************
        * Pagination Start
        ******************************/
        $config["base_url"] = base_url('backend/cms/page_content/index');
        $config["total_rows"] = $this->db->get_where('web_article', array('page_content'=>1))->num_rows();
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
        $data['article'] = $this->article_model->multipleData();
        $data["links"] = $this->pagination->create_links();
        /******************************
        * Pagination ends
        ******************************/

		$data['content'] = $this->load->view("backend/article/article_list", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}
 
	public function form($article_id = null)
	{
		$data['title']  = display('add_content');
		$data['web_language'] = $this->language_model->single();

		$article_id = !empty($article_id)?$article_id:$this->input->post('article_id',TRUE);

		$this->form_validation->set_rules('headline_en', display('headline_en'),'required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('cat_id', display('category'),'required|max_length[10]|xss_clean');
		$this->form_validation->set_rules('position_serial', display('position_serial'),'required|max_length[10]|trim|xss_clean');

        /*-----------------------------------*/
 		$image = $this->upload_lib->do_upload(
			'upload/',
			'article_image'
		);

		// if image is uploaded then resize the image
		if ($image !== false && $image != null) {
			$this->upload_lib->do_resize(
				$image, 
				500,
				475
			);
		}
		/*-----------------------------------*/

		$data['article']   = (object)$userdata = array(
			'article_id'      	=> $this->input->post('article_id',TRUE),
			'article_image'  	=> (!empty($image)?$image:$this->input->post('article_image_old',TRUE)),
			'video' 			=> $this->input->post('video',TRUE),
			'cat_id' 			=> $this->input->post('cat_id',TRUE),
			'page_content' 		=> 1,
			'position_serial' 	=> $this->input->post('position_serial',TRUE),
			'publish_date' 		=> date("Y-m-d h:i:sa"),
			'publish_by' 		=> $this->session->userdata('email')
		);

		//From Validation Check
		if ($this->form_validation->run()) 
		{
			if (empty($userdata['article_image']) && $this->session->flashdata('exception') == null) {
				$this->session->set_flashdata('exception', display('you_did_not_upload_any_file'));
	        }
	        
			$languagelist = $this->language_model->single();
			if (empty($article_id)) 
			{
				if ($this->article_model->create($userdata)) {

					$id = $this->db->insert_id();

					foreach ($languagelist as $key => $value) {

						$langinsertdata = array(

							'table_key' 	=> 'article_data',
							'data_id'		=> $id,
							'parent_id' 	=> $this->input->post('cat_id',TRUE),
							'data_headline'	=> $this->input->post("headline_".$value->iso,TRUE),
							'data_title'	=> $this->input->post('progress_title_'.$value->iso,TRUE),
							'article_1'		=> $this->input->post("article1_".$value->iso,TRUE),
							'article_2'		=> $this->input->post("article2_".$value->iso,TRUE),
							'lang_id'		=> $value->id
						);

						$this->article_model->addArticleByLanguage($langinsertdata);
					}

					$this->session->set_flashdata('message', display('save_successfully'));

				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));

				}
				redirect("backend/cms/page_content/form");

			} 
			else 
			{
				if ($this->article_model->update($userdata)) {

					$id = $this->input->post('article_id',TRUE);

					foreach ($languagelist as $key => $value) {

						$langupdatedata = array(
							'parent_id' 	=> $this->input->post('cat_id',TRUE),
							'data_headline'	=> $this->input->post("headline_".$value->iso,TRUE),
							'data_title'	=> $this->input->post('progress_title_'.$value->iso,TRUE),
							'article_1'		=> $this->input->post("article1_".$value->iso,TRUE),
							'article_2'		=> $this->input->post("article2_".$value->iso,TRUE)
						);
						$wheredata = array(
							'table_key' 	=> 'article_data',
							'data_id'		=> $id,
							'lang_id'		=> $value->id
						);

						$this->article_model->updateArticleByLanguage($langupdatedata,$wheredata);
					}

					$this->session->set_flashdata('message', display('update_successfully'));

				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));

				}
				redirect("backend/cms/page_content/form/$article_id");

			}

		} 
		else
		{ 
			$data['parent_cat'] = $this->category_model->all();
			if(!empty($article_id)) {
				$data['title'] = display('edit_content');
				$data['article']   = $this->article_model->single($article_id);
				$data['articledetails']   = $this->article_model->singleDetailsData($article_id);
			}
		}
		
		$data['content'] = $this->load->view("backend/article/form", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);

	}


	public function delete($article_id = null)
	{  
		if ($this->article_model->delete($article_id)) {
			$this->session->set_flashdata('message', display('delete_successfully'));

		} else {
			$this->session->set_flashdata('exception', display('please_try_again'));

		}
		redirect("backend/cms/page_content");

	}


}
