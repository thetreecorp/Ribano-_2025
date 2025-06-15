<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('web_article', $data);
		
	}

	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('web_article')
			->order_by('cat_id', 'desc')
			->limit($limit, $offset)
			->get()
			->result();

	}

	public function multipleData()
	{
		return $this->db->select('web_article.*,web_language_data.*,web_category.slug')
			->from('web_article')
			->join('web_language_data','web_language_data.data_id = web_article.article_id','left')
			->join('web_category','web_category.cat_id = web_article.cat_id','left')
			->where('web_language_data.table_key','article_data')
			->where('web_language_data.lang_id',1)
			->where('web_article.data_key','page_content')
			->get()
			->result();
	}

	public function multipleAboutCoin()
	{
		return $this->db->select('web_article.*,web_language_data.*,web_category.slug')
			->from('web_article')
			->join('web_language_data','web_language_data.data_id = web_article.article_id','left')
			->join('web_category','web_category.cat_id = web_article.cat_id','left')
			->where('web_language_data.table_key','about_coin')
			->where('web_language_data.lang_id',1)
			->where('web_article.data_key','about_coin')
			->get()
			->result();
	}

	public function getmultipleArticle($key = "")
	{
		return $this->db->select('web_article.*,web_language_data.*,web_category.slug')
			->from('web_article')
			->join('web_language_data','web_language_data.data_id = web_article.article_id','left')
			->join('web_category','web_category.cat_id = web_article.cat_id','left')
			->where('web_language_data.table_key',$key)
			->where('web_language_data.lang_id',1)
			->where('web_article.data_key',$key)
			->get()
			->result();
	}

	public function single($article_id = null)
	{
		return $this->db->select('*')
			->from('web_article')
			->where('article_id', $article_id)
			->get()
			->row();

	}

	public function singleDetailsData($article_id = null)
	{

		return $this->db->select('web_language_data.*,web_language.language_name,web_language.iso')
			->from('web_language_data')
			->join('web_language','web_language.id = web_language_data.lang_id','right')
			->where("web_language_data.table_key","article_data")
			->where("web_language_data.data_id",$article_id)
			->get()
			->result();

	}

	public function allDetailsData($article_id = null,$key=null)
	{

		return $this->db->select('web_language_data.*,web_language.language_name,web_language.iso')
			->from('web_language_data')
			->join('web_language','web_language.id = web_language_data.lang_id','right')
			->where("web_language_data.table_key",$key)
			->where("web_language_data.data_id",$article_id)
			->get()
			->result();

	}

	public function all()
	{
		return $this->db->select('*')
			->from('web_article')
			->get()
			->result();

	}

	public function update($data = array())
	{
		return $this->db->where('article_id', $data["article_id"])
			->update("web_article", $data);

	}

	public function delete($article_id = null)
	{
		return $this->db->where('article_id', $article_id)
			->delete("web_article");

	}

	public function catidBySlug($slug=NULL){
		return $this->db->select("cat_id")
			->from('web_category')
			->where('slug', $slug)
			->get()
			->row();
	}

	public function articleByCatid($id=NULLL){
		return $this->db->select("*")
			->from('web_article')
			->where('cat_id', $id)
			->get()
			->row();
	}

	public function addArticleByLanguage($data = array())
	{
		return $this->db->insert('web_language_data',$data);
	}
	public function updateArticleByLanguage($data = array(),$where = array())
	{
		return $this->db->where($where)->update('web_language_data',$data);
	}

	public function singleHeadDetailsData($id = null)
	{
		return $this->db->select('web_language_data.*,web_language.language_name,web_language.iso')
			->from('web_language_data')
			->join('web_language','web_language.id = web_language_data.lang_id','right')
			->where("(`web_language_data`.`table_key` = 'headline_text' OR `web_language_data`.`table_key` is NULL ) AND (`web_language_data`.`data_id` = '".$id."' OR `web_language_data`.`data_id` is NULL)")
			->get()
			->result();

	}

	public function singleHeadline($id = null)
	{
		return $this->db->select('*')
			->from('web_headline_text')
			->where('id', $id)
			->get()
			->row();

	}

	public function create_headline($data = array())
	{
		return $this->db->insert('web_headline_text',$data);
	}

	public function update_headline($data = array())
	{
		return $this->db->where('id',$data['id'])->update('web_headline_text',$data);
	}

}
