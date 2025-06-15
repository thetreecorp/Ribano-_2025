<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('isLogIn'))
            redirect('login');

        if (!$this->session->userdata('user_id'))
            redirect('login');

        $this->load->model(array(
            'shareholder/transfer_model',
        ));
    }

    public function language_setting()
    {
        $user_id = $this->session->userdata('user_id');
        $data['lang'] = $this->db->select('language')->from('dbt_user')->where('user_id', $user_id)->get()->row();

        $data['title']   = display('language_setting');
        $data['languageList'] = $this->languageList();

        $data['content'] = $this->load->view('shareholder/settings/language_setting', $data, true);
        $this->load->view('shareholder/layout/main_wrapper', $data);
    }

    public function update_language()
    {
        $language = $this->input->post('language', TRUE);
        $user_id = $this->session->userdata('user_id');

        $this->db->set('language', $language)->where('user_id', $user_id)->update('dbt_user');

        $language_id     = $this->db->query("SELECT id FROM `web_language` WHERE `language_name` LIKE '%" . $language . "%'")->row();
        $language_id     = $language_id->id;

        $this->load->helper('cookie');
        $lang = $this->input->cookie('language_id', true);

        if ($lang != $language_id) {
            delete_cookie('language_id');
            $cookie = array(
                'name'    => 'language_id',
                'value'   => $language_id,
                'expire'  => 31536000
            );
            $this->input->set_cookie($cookie);
        }

        $this->session->set_flashdata('message', display('update_successfully'));

        redirect('shareholder/settings/language_setting');
    }

    /*
    |-----------------------------------
    |   Bitcoin Settings View
    |-----------------------------------
    */
    public function payment_method_setting()
    {
        $user_id = $this->session->userdata('user_id');

        $data['bitcoin'] = $this->db->select('*')->from('dbt_payout_method')->where('user_id', $user_id)->where('method', 'bitcoin')->get()->row();
        $data['payeer'] = $this->db->select('*')->from('dbt_payout_method')->where('user_id', $user_id)->where('method', 'payeer')->get()->row();
        $data['phone'] = $this->db->select('*')->from('dbt_payout_method')->where('user_id', $user_id)->where('method', 'phone')->get()->row();
        $data['ccavenue'] = $this->db->select('*')->from('dbt_payout_method')->where('user_id', $user_id)->where('method', 'ccavenue')->get()->row();
        $data['paypal'] = $this->db->select('*')->from('dbt_payout_method')->where('user_id', $user_id)->where('method', 'paypal')->get()->row();
        $data['stripe'] = $this->db->select('*')->from('dbt_payout_method')->where('user_id', $user_id)->where('method', 'stripe')->get()->row();

        $data['title']   = display('payment_method_setting');
        $data['content'] = $this->load->view('shareholder/settings/bitcoin_settings', $data, true);
        $this->load->view('shareholder/layout/main_wrapper', $data);
    }

    /*
    |-----------------------------------
    |   Payeer Settings View
    |-----------------------------------
    */
    public function payment_method_update($method = NULL)
    {

        $wallet_id = $this->input->post('wallet_id', TRUE);
        $user_id = $this->session->userdata('user_id');

        if ($method != NULL) {

            $data = array('user_id' => $user_id, 'method' => $method, 'wallet_id' => $wallet_id);
            $check = $this->db->select('*')->from('dbt_payout_method')->where('user_id', $user_id)->where('method', $method)->get()->row();
            if ($check != NULL) {
                $this->db->where('user_id', $user_id)->where('method', $method)->update('dbt_payout_method', $data);
            } else {
                $this->db->insert('dbt_payout_method', $data);
            }

            $this->session->set_flashdata('message', display('update_successfully'));
        }

        redirect('shareholder/settings/payment_method_setting');
    }

    public function languageList()
    {
        if ($this->db->table_exists("language")) {

            $fields = $this->db->field_data("language");
            $i = 1;
            foreach ($fields as $field) {
                if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
            }

            if (!empty($result)) return $result;
        } else {
            return false;
        }
    }
}