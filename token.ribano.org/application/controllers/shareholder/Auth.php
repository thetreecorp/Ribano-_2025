<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'shareholder/auth_model'
		));

		$this->load->helper('captcha');
	}


	public function login()
	{

		$this->load->helper(array('cookie'));

		if ($this->session->userdata('isLogIn'))
			redirect('shareholder/home');

		$data['title']    = display('share_holder');
		#-------------------------------------#
		$this->form_validation->set_rules('email', display('email'), 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('password', display('password'), 'required|max_length[32]|trim|xss_clean');

		$security = $this->db->select('*')->from('dbt_security')->where('keyword', 'capture')->where('status', 1)->get()->row();
		if ($security) {

			$this->load->library('recaptcha');
			//If  goggle capture enable
			$this->form_validation->set_rules('g-recaptcha-response', display('recaptcha'), 'required|trim|xss_clean');
			$data = array(
				'widget' => $this->recaptcha->getWidget(),
				'script' => $this->recaptcha->getScriptTag(),
			);
		} else {
			$this->form_validation->set_rules(
				'captcha',
				display('captcha'),
				array(
					'matches[captcha]',
					function ($captcha) {
						$oldCaptcha = $this->session->userdata('captcha');

						if ($captcha == $oldCaptcha) {
							return true;
						}
					}
				)
			);
		}


		#-------------------------------------#
		$data['user'] = (object)$userData = array(
			'email' 	 => $this->input->post('email', TRUE),
			'password'   => md5($this->input->post('password', TRUE)),
		);


		#-------------------------------------#
		if ($this->form_validation->run()) {

			if ($this->session->userdata('captcha')) {
				$this->session->unset_userdata('captcha');
			}
			$security = $this->db->select('*')->from('dbt_security')->where('keyword', 'login')->where('status', 1)->get()->row();
			$security_decode = json_decode(@$security->data, TRUE);
			//Check already try

			$cookie_count = $this->input->cookie('wrong_loginx');
			if ($cookie_count) {
				//30 min
				$this->session->set_flashdata('exception', "Try it after " . $security_decode['duration'] . " min");
				redirect(base_url('shareholder'));
			}

			$user = $this->auth_model->checkUser($userData);

			if ($user->num_rows() > 0 && $user->row()->status == 1) {

				$query = $this->db->select('googleauth,smsauth')->from('dbt_user')->where('user_id',  $user->row()->user_id)->get()->row();
				if ($query->googleauth != '') {

					$sData = array('isverifyLogin' => true, 'isverifyId' => $user->row()->user_id, 'isverifyMedia' => 'googleauth');
					$this->session->set_userdata($sData);
					redirect('shareholder/login_verify');
				} else if ($query->smsauth != '') {

					$varify_code = $this->randomID();
					$this->db->where('user_id', $user->row()->user_id)->set('smsauth', $varify_code)->update('dbt_user');

					$this->load->library('sms_lib');

					$template = array(
						'code'      => $varify_code
					);

					if ($user->row()->phone) {
						$code_send = $this->sms_lib->send(array(
							'to'       => $user->row()->phone,
							'template' => 'Verification Code is %code% ',
							'template_config' => $template,
						));
					} else {
						$this->session->set_flashdata('exception', display('there_is_no_phone_number'));
					}
					$sData = array('isverifyLogin' => true, 'isverifyId' => $user->row()->user_id, 'isverifyMedia' => 'smsauth');
					$this->session->set_userdata($sData);
					redirect('shareholder/login_verify');
				} else {

					$this->session->unset_userdata('wrong_login');
					delete_cookie('wrong_loginx');
					delete_cookie('wrong_login');

					$sData = array(
						'isLogIn' 	  => true,
						'id' 		  => $user->row()->id,
						'user_id' 	  => $user->row()->user_id,
						'fullname'	  => $user->row()->first_name . ' ' . $user->row()->last_name,
						'image'		  => $user->row()->image,
						'email' 	  => $user->row()->email,
					);

					//store date to session 
					$this->session->set_userdata($sData);
					//update database status
					//welcome message
					$this->session->set_flashdata('message', display('welcome_back') . ' ' . $user->row()->first_name . ' ' . $user->row()->last_name);

					redirect('shareholder/home');
				}
			} else {

				if ($user->num_rows() > 0 && $user->row()->status == 0) {
					$this->session->set_flashdata('exception', 'Please active your account');
					$this->session->set_userdata(array('issignverify' => true, 'issignverifyid' => $user->row()->user_id));
					redirect('signup-verify');
				}

				//Security module
				$wrong_login = $this->session->userdata('wrong_login');

				if ($wrong_login) {

					$this->session->set_userdata('wrong_login', $wrong_login + 1);
					$wrong_login = $this->session->userdata('wrong_login');

					if ($wrong_login % @$security_decode['wrong_try'] == 0) {

						//database update ip/account deactive base on session
						# code...

						$cookie_count = get_cookie('wrong_loginc', TRUE);
						if ($cookie_count) {
							$this->session->unset_userdata('wrong_login');
							//30 min
							set_cookie('wrong_loginc', $cookie_count + 1, 3600 * 24);
							$cookie_count = get_cookie('wrong_loginc', TRUE);
							if ($cookie_count >= @$security_decode['ip_block']) {
								//database update ip/account deactive base on cookie
								$this->db->insert('dbt_blocklist', array('ip_mail' => $this->input->ip_address()));
							}
						} else {
							$this->session->unset_userdata('wrong_login');
							//30 min
							set_cookie('wrong_loginc', 1, 3600 * 24);
							set_cookie('wrong_loginx', 1, 60 * @$security_decode['duration']);
						}

						$this->session->set_flashdata('exception', "Try it after " . $security_decode['duration'] . " min");
					}
				} else {

					if ($security_decode['wrong_try'] > 0) {

						if (1 % @$security_decode['wrong_try'] == 0) {
							//database update ip/account deactive base on session
							# code...

							$cookie_count = get_cookie('wrong_loginc', TRUE);
							if ($cookie_count) {
								$this->session->unset_userdata('wrong_login');
								//1 day
								set_cookie('wrong_loginc', $cookie_count + 1, 3600 * 24);
								$cookie_count = get_cookie('wrong_loginc', TRUE);

								if ($cookie_count >= @$security_decode['ip_block']) {
									//database update ip/account deactive base on cookie
									$this->db->insert('dbt_blocklist', array('ip_mail' => $this->input->ip_address()));
								}
							} else {
								$this->session->unset_userdata('wrong_login');
								//30 min
								set_cookie('wrong_loginc', 1, 3600 * 24);
								set_cookie('wrong_loginx', 1, 60 * @$security_decode['duration']);
							}

							$cookie_count = get_cookie('wrong_loginc', TRUE);
							$this->session->set_flashdata('exception', "Try it after " . $security_decode['duration'] . " min");
						} else {
							$this->session->set_userdata('wrong_login', 1);
						}
					}
				}

				$this->session->set_flashdata('exception', display('incorrect_email_password'));
				redirect('shareholder');
			}
		} else {

			$captcha = create_captcha(array(
				'img_path'      => FCPATH . './assets/images/captcha/',
				'img_url'       => base_url('assets/images/captcha/'),
				'font_path'     => FCPATH . './assets/fonts/captcha.ttf',
				'img_width'     => '300',
				'img_height'    => 64,
				'expiration'    => 600, //5 min
				'word_length'   => 4,
				'font_size'     => 26,
				'img_id'        => 'Imageid',
				'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz',

				// White background and border, black text and red grid
				'colors'        => array(
					'background' => array(255, 255, 255),
					'border' => array(228, 229, 231),
					'text' => array(49, 141, 1),
					'grid' => array(241, 243, 246)
				)
			));
			$data['captcha_word'] = $captcha['word'];
			$data['captcha_image'] = $captcha['image'];

			$this->session->set_userdata('captcha', $captcha['word']);
			$this->load->view("shareholder/layout/login_wrapper", $data);
		}
	}

	public function logout()
	{
		//update database status
		//destroy session
		$this->session->sess_destroy();
		redirect(base_url());
	}

	/*
	|----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
    */
	public function randomID($mode = 2, $len = 6)
	{
		$result = "";
		if ($mode == 1) :
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		elseif ($mode == 2) :
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		elseif ($mode == 3) :
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		elseif ($mode == 4) :
			$chars = "0123456789";
		endif;

		$charArray = str_split($chars);
		for ($i = 0; $i < $len; $i++) {
			$randItem = array_rand($charArray);
			$result .= "" . $charArray[$randItem];
		}
		return $result;
	}
	/*
    |----------------------------------------------
    |         Ends of id genaretor
    |----------------------------------------------
    */
}