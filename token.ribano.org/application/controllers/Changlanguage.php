<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Changlanguage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('cookie'));
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $iso     = $this->input->post('lang', TRUE);
        $language = $this->db->select('id,language_name')->from('web_language')->where('iso', $iso)->get()->row();

        if ($user_id) {
            $this->db->where('user_id', $user_id)->set('language', strtolower($language->language_name))->update('dbt_user');
        } else if ($this->session->userdata('id')) {
            $language = $this->db->select('language')->from('setting')->get()->row();
            $lang     = $language->language;
            $language = $this->db->query("SELECT id,language_name FROM `web_language` WHERE `language_name` LIKE '%" . $lang . "%'")->row();
        }

        $cookie = array(
            'name'    => 'language_id',
            'value'   => $language->id,
            'expire'  => 31536000
        );

        $this->input->set_cookie($cookie);
    }
}