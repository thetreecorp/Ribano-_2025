<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Head_line_text extends CI_Controller {
 	
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
 		$data['title'] = display('all_head_line_text');
 		$data['totalheadline'] = $this->db->get('web_headline_text')->result();
 		$data['content'] = $this->load->view("backend/article/head_line_text", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
 	}

 	public function form($id="")
 	{
 		$data['title'] = display('all_head_line_text');
 		$data['web_language'] = $this->language_model->single();

 		$id = !empty($id)?$id:$this->input->post('id',TRUE);
 		$data['headline'] = (object) $insertdata = array(
 			'id'			=>$id,
 			'data_title'	=>$this->input->post('headline_en',TRUE),
 			'position_key'	=>$this->input->post('position_key',TRUE)
 		);

 		$this->form_validation->set_rules('headline_en',display('headline_english'),'required|xss_clean');

 		if($this->form_validation->run()){

 			$languagelist = $this->language_model->single();

 			if(empty($id)){


 				if($this->article_model->create_headline($insertdata)){

 					$id = $this->db->insert_id();

 					foreach ($languagelist as $key => $value) {

						$langinsertdata = array(

							'table_key' 	=> 'headline_text',
							'data_id'		=> $id,
							'data_headline'	=> $this->input->post("headline_".$value->iso,TRUE),
							'article_1'		=> $this->input->post("article_".$value->iso,TRUE),
							'lang_id'		=> $value->id
						);

						$this->article_model->addArticleByLanguage($langinsertdata);

					}

					$this->session->set_flashdata('message', display('save_successfully'));
 				}
 				else{

					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect("backend/cms/head_line_text/form");

 			}
 			else{
 				if ($this->article_model->update_headline($insertdata)) {

					$id = $this->input->post('id',TRUE);

					foreach ($languagelist as $key => $value) {

						$langupdatedata = array(
							'data_headline'	=> $this->input->post("headline_".$value->iso,TRUE),
							'article_1'		=> $this->input->post("article_".$value->iso,TRUE),
						);
						$wheredata = array(
							'table_key' 	=> 'headline_text',
							'data_id'		=> $id,
							'lang_id'		=> $value->id
						);

						$result = $this->db->select('id')->from('web_language_data')->where($wheredata)->get()->num_rows();

						$this->article_model->updateArticleByLanguage($langupdatedata,$wheredata);

					}

					$this->session->set_flashdata('message', display('update_successfully'));

				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));

				}
				redirect("backend/cms/head_line_text/form/$id");
 			}
 		}
 		else{

 			if(!empty($id)){

 				$data['title'] = display('update_head_line_text');
 				$data['headline'] = $this->article_model->singleHeadline($id);
 				$data['headlinedetails'] = $this->article_model->singleHeadDetailsData($id);
 			}
 		}

 		$data['content'] = $this->load->view("backend/article/head_line_form", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
 	}

 	public function delete($id = "")
 	{
 		$this->db->where('id',$id)->delete('web_headline_text');
 		redirect("backend/cms/head_line_text");
 	}


}
