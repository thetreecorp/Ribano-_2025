<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {
 
	public function create($data = array())
	{
		return $this->db->insert('web_article', $data);
		
	}

	public function read($limit, $offset)
	{
		return $this->db->select("web_article.*,web_language_data.data_headline,web_category.slug")
			->from('web_article')
			->join('web_language_data','web_language_data.data_id=web_article.article_id')
			->join('web_category','web_category.cat_id=web_article.cat_id','left')
			->where('web_article.data_key','blog_news')
			->where('web_language_data.lang_id',1)
			->order_by('web_article.article_id', 'asc')
			->limit($limit, $offset)
			->get()
			->result();

	}

	public function singleHeadDetailsData($id = null)
	{
		return $this->db->select('web_language_data.*,web_language.language_name,web_language.iso')
			->from('web_language_data')
			->join('web_language','web_language.id = web_language_data.lang_id','right')
			->where("(`web_language_data`.`table_key` = 'blog_news' OR `web_language_data`.`table_key` is NULL ) AND (`web_language_data`.`data_id` = '".$id."' OR `web_language_data`.`data_id` is NULL)")
			->get()
			->result();

	}

	public function addArticleByLanguage($data = array())
	{
		return $this->db->insert('web_language_data',$data);
	}

	public function updateArticleByLanguage($data = array(),$where = array())
	{
		return $this->db->where($where)->update('web_language_data',$data);
	}

	public function single($article_id = null)
	{
		return $this->db->select('*')
			->from('web_article')
			->where('article_id', $article_id)
			->get()
			->row();

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

	public function getBlogCategory()
	{
		$blog = $this->db->select('*')->from('web_category')->where('slug','blog')->get()->row();
		return $this->db->select('*')
				->from('web_category')
				->where('parent_id',$blog->cat_id)
				->get()
				->result();
	}
}
