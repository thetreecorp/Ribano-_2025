<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bulk_email_sender extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'backend/dashboard/setting_model',
			'backend/dashboard/email_model',
			'shareholder/transections_model',
			'common_model'
		));
	}


	public function index()
	{
		//Temporary data to send cron jobs for bulk sms.
		$tempdata = $this->db->select('*')->from('temp_cornjobs')->get()->result();

		foreach ($tempdata as $key => $value) {

			$nowtime = strtotime(date("Y-m-d H:i:s"));
			if ($nowtime >= strtotime($value->next_time)) {

				if ($value->status == 1) {

					if ($value->customer_type != "SUBSCRIBERS") {

						$nextselectid 	= $value->next_id;
						if ($value->customer_type == "ALL") {

							$userinfo = $this->db->select('user_id,email,phone')->from('user_registration')->order_by("user_id", "asc")->limit(10, $nextselectid)->get();
						} else {

							$userinfo = $this->db->select('user_id,email,phone')->from('user_registration')->where("transfer_limit", $value->customer_type)->order_by("user_id", "asc")->limit(10, $nextselectid)->get();
						}

						if ($userinfo->num_rows() > 0) {

							//All Reserve Key
							$template 		= $this->email_model->gettemplatedata($value->email_temp_id);

							// Send 10 mail
							foreach ($userinfo->result() as $key => $value1) {

								$temconfig = $this->templateconfig($value1->user_id);

								$config = array(

									'to'				=> $value1->email,
									'subject'			=> $value->subject,
									'template'			=> $template->template,
									'template_config'	=> $temconfig

								);
								//Send Mail.
								$this->common_model->send_bulk_email($config);
							}
							//Present Next time in db table
							$nextime = $value->next_time;
							//Add 15 minutes in Next time
							$nextime = date("Y-m-d H:i:s", strtotime("$nextime +15 minutes"));
							$nextselectid = $nextselectid + 10;
							$this->db->where("id", $value->id);
							$this->db->set("next_id", $nextselectid);
							$this->db->set("next_time", $nextime)->update("temp_cornjobs");
						} else {
							//Deactive Send Bulk Email
							$this->db->where("id", $value->id)->set("status", 0)->update("temp_cornjobs");
						}
					} else {

						$nextselectid 	= $value->next_id;

						$subscribinfo = $this->db->select('email')->from('web_subscriber')->order_by("sub_id", "asc")->limit(10, $nextselectid)->get();

						if ($subscribinfo->num_rows() > 0) {

							//All Reserve Key
							$template 		= $this->email_model->gettemplatedata($value->email_temp_id);

							// Send 10 mail
							foreach ($subscribinfo->result() as $key => $value1) {

								$config = array(

									'to'				=> $value1->email,
									'subject'			=> $value->subject,
									'template'			=> $template->template,
									'template_config'	=> ''

								);
								//Send Mail.
								$this->common_model->send_bulk_email($config);
							}
							//Present Next time in db table
							$nextime = $value->next_time;
							//Add 15 minutes in Next time
							$nextime = date("Y-m-d H:i:s", strtotime("$nextime +15 minutes"));
							$nextselectid = $nextselectid + 10;
							$this->db->where("id", $value->id);
							$this->db->set("next_id", $nextselectid);
							$this->db->set("next_time", $nextime)->update("temp_cornjobs");
						} else {
							//Deactive Send Bulk Email
							$this->db->where("id", $value->id)->set("status", 0)->update("temp_cornjobs");
						}
					}
				}
			}
		}
	}

	public function gettemplatconfig($user_id = "")
	{

		$transectinfo 	= $this->transections_model->get_cata_wais_transections($user_id);
		$userinfo 		= $this->email_model->user_info($user_id);

		$data['user_name']			= $userinfo['my_info']->username;
		$data['name']				= $userinfo['my_info']->f_name . " " . $userinfo['my_info']->l_name;
		$data['email']				= $userinfo['my_info']->email;
		$data['phone']				= $userinfo['my_info']->phone;

		$data['payout']				= @$transectinfo['my_earns'] ? "$" . number_format($transectinfo['my_earns'], 2) : '$0.0';

		$data['commission']			= @$transectinfo['commission'] ? "$" . number_format($transectinfo['commission'], 2) : '$0.0';

		$data['bonus']				= @$transectinfo['team_bonus'] ? "$" . number_format($transectinfo['team_bonus'], 2) : '$0.0';

		$data['withdraw']			= @$transectinfo['withdraw'] ? "$" . number_format($transectinfo['withdraw'], 2) : '$0.0';

		$data['team_turnover']		= @$transectinfo['team_commission'] ? "$" . number_format($transectinfo['team_commission'], 2) : '$0.0';

		$data['sponser_turnover']	= @$transectinfo['sponser_commission'] ? "$" . number_format($transectinfo['sponser_commission'], 2) : '$0.0';

		$data['balance']			= @$transectinfo['balance'] ? "$" . number_format($transectinfo['balance'], 2) : '$0.0';

		$data['investment']			= @$transectinfo['investment']->total_amount ? "$" . number_format($transectinfo['investment']->total_amount, 2) : '$0.0';

		return $data;
	}

	private function templateconfig($user_id)
	{
		$data 		 = $this->gettemplatconfig($user_id);
		$reservedata = $this->email_model->assignreservekey($data);

		return $reservedata;
	}
}