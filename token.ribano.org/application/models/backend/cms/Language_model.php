<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language_model extends CI_Model {
 
	public function single()
	{
		return $this->db->select('*')
			->from('web_language')
			->get()
			->result();
	}

	public function update($data = array())
	{
		return $this->db->where('id', $data["id"])
			->update("web_language", $data);
	}

	public function add($data = array())
	{
		$result = $this->db->insert("web_language", $data);

		$langid = $this->db->insert_id();

		$web_article = $this->db->select('*')->from('web_article')->get()->result();
		$headlinetext = $this->db->select('*')->from('web_headline_text')->get()->result();

		foreach ($web_article as $key => $value) {

			
			if($value->data_key!="web_chart" || $value->data_key!="member_data" || $value->data_key!="testimonial"){

				$insertdata = array(

					'table_key'	=> $value->data_key=="page_content"?"article_data":$value->data_key,
					'data_id'	=> $value->article_id,
					'lang_id'	=> $langid
				);

				$this->db->insert('web_language_data',$insertdata);

			}
			
		}

		foreach ($headlinetext as $key => $value) {
			
			$insertdata = array(

				'table_key'	=> 'headline_text',
				'data_id'	=> $value->id,
				'lang_id'	=> $langid
			);

			$this->db->insert('web_language_data',$insertdata);
		}

		return $result;
	}

	public function flag_list()
	{
		return $this->db->select('*')
				->from('dbt_country')
				->get()
				->result();
	}

	public function lang_list()
	{
		return $this->db->select('*')
				->from('web_language')
				->get()
				->result();
	}

	public function checkExistsLang($data = array())
	{
		return $this->db->select('*')
			->from('web_language')
			->where('language_name',$data['language_name'])
			->or_where('iso',$data['iso'])
			->get()
			->num_rows();
	}

	
}
