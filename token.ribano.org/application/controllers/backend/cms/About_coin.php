<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_coin extends CI_Controller {
 	
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
		$data['title']  = display('about_coin_list');
 		
 		/******************************
        * Pagination Start
        ******************************/
        $config["base_url"] = base_url('backend/cms/aboutcoin/index');
        $config["total_rows"] = $this->db->get_where('web_article', array('cat_id'=>1))->num_rows();
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
        $data['article'] = $this->article_model->multipleAboutCoin();

        $data["links"] = $this->pagination->create_links();
        /******************************
        * Pagination ends
        ******************************/

		$data['content'] = $this->load->view("backend/article/about_coin_list.php", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}

	public function form($article_id = null)
	{
		$data['title']  = display('add_about_coin');
		$data['web_language'] = $this->language_model->single();

		//Set Rules From validation
		if (!empty($article_id)) {   
       		$this->form_validation->set_rules('headline_en', display("headline_en"), "required|xss_clean"); 

		} else {
			$this->form_validation->set_rules('headline_en', display('headline_en'),'required|xss_clean');
			
		}

		$data['article']   = (object)$userdata = array(
			'article_id'      	=> $this->input->post('article_id',TRUE),
			'data_key'			=> 'about_coin',
			'publish_date' 		=> date("Y-m-d h:i:s"),
			'publish_by' 		=> $this->session->userdata('email')
		);

		//From Validation Check
		if ($this->form_validation->run()) 
		{
			$languagelist = $this->language_model->single();
			if (empty($article_id)) 
			{
				if ($this->article_model->create($userdata)) {

					$id = $this->db->insert_id();

					foreach ($languagelist as $key => $value) {

						$langinsertdata = array(

							'table_key' 	=> 'about_coin',
							'data_id'		=> $id,
							'data_headline'	=> $this->input->post("headline_".$value->iso,TRUE),
							'article_1'		=> $this->input->post("article1_".$value->iso,TRUE),
							'lang_id'		=> $value->id
						);

						$this->article_model->addArticleByLanguage($langinsertdata);
					}

					$this->session->set_flashdata('message', display('save_successfully'));

				}else {
					$this->session->set_flashdata('exception', display('please_try_again'));

				}
				redirect("backend/cms/about_coin/form");

			} 
			else 
			{
				if ($this->article_model->update($userdata)) {

					$id = $this->input->post('article_id',TRUE);

					foreach ($languagelist as $key => $value) {

						$langupdatedata = array(
							'data_headline'	=> $this->input->post("headline_".$value->iso,TRUE),
							'article_1'		=> $this->input->post("article1_".$value->iso,TRUE),
						);
						$wheredata = array(
							'table_key' 	=> 'about_coin',
							'data_id'		=> $id,
							'lang_id'		=> $value->id
						);

						$this->article_model->updateArticleByLanguage($langupdatedata,$wheredata);

					}

					$this->session->set_flashdata('message', display('update_successfully'));

				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));

				}
				redirect("backend/cms/about_coin/form/$article_id");

			}

		} 
		else
		{
			if(!empty($article_id)) {
				$data['title'] = display('edit_aboutcoin');
				$data['article']   = $this->article_model->single($article_id);
				$data['article_details']   = $this->article_model->allDetailsData($article_id,"about_coin");

			}
		}
		
		$data['content'] = $this->load->view("backend/article/aboutcoin", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);

	}


	public function delete($article_id = null)
	{  
		if ($this->article_model->delete($article_id)) {
			$this->session->set_flashdata('message', display('delete_successfully'));

		} else {
			$this->session->set_flashdata('exception', display('please_try_again'));

		}
		redirect("backend/cms/about_coin");

	}


}
