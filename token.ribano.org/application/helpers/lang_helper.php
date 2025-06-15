<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('display')) {

    function display($text = null)
    {
        $ci = &get_instance();
        $ci->load->database();
        $table  = 'language';
        $phrase = 'phrase';

        #---------------------------------------
        #   modify function 09-05-2021
        #--------------------------------------
        $user_id = $ci->session->userdata('user_id');

        if (!empty($user_id)) {
            $data       = $ci->db->where('user_id', $user_id)->get('dbt_user')->row();
            $language   = $data->language;
        } else if ($ci->session->userdata('id')) {
            $data       = $ci->db->get('setting')->row();
            $language   = $data->language;
        } else {
            $ci->load->helper(array('cookie'));
            $language_id = $ci->input->cookie('language_id', true);

            if ($language_id) {
                $data     = $ci->db->where('id', $language_id)->get('web_language')->row();
                $language = strtolower($data->language_name);
            } else {
                //set language  
                $data       = $ci->db->get('setting')->row();
                $language   = $data->language;
            }
        }

        if (!empty($text)) {

            if ($ci->db->table_exists($table)) {

                if ($ci->db->field_exists($phrase, $table)) {

                    if ($ci->db->field_exists($language, $table)) {

                        $row = $ci->db->select($language)
                            ->from($table)
                            ->where($phrase, $text)
                            ->get()
                            ->row();

                        if (!empty($row->$language)) {
                            return html_escape($row->$language);
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}