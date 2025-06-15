<?php defined('BASEPATH') OR exit('No direct script access allowed');

class common_model extends CI_Model {

	//Send email via SMTP server in CodeIgniter
	public function send_email($post=array()){

		$email = $this->db->select('*')->from('email_sms_gateway')->where('es_id', 2)->get()->row();

		//SMTP & mail configuration
		$config = array(
		    'protocol'  => $email->protocol,
		    'smtp_host' => $email->host,
		    'smtp_port' => $email->port,
		    'smtp_user' => $email->user,
		    'smtp_pass' => $email->password,
		    'mailtype'  => $email->mailtype,
		    'charset'   => 'iso-8859-1',
            'wordwrap'  => TRUE,
		    'newline'   => "\r\n"
		);
		//Load email library
		$this->load->library('email',$config);
		$this->email->initialize($config);

		//Email content
		$htmlContent = $post['message'];

		$this->email->to($post['to']);
		$this->email->from($email->user, $email->title);
		$this->email->subject($post['subject']);
		$this->email->message($htmlContent);
		
		//Send email
		if($this->email->send()){

			return 1;

		} else{
			
			return 0;

		}
		
	}


	public function email_sms($method)
	{
        
	   return $this->db->select('*')
       ->from('sms_email_send_setup')
       ->where('method',$method)
       ->get()
       ->row();

	}
	
	public function send_bulk_email($config = array())
    {
        if (isset($config['from']) && !empty($config['from']))
        {
            $_from = $config['from'];
        } 

        $_message = $config['template'];
        if (is_array($config['template_config']) && sizeof($config['template_config']) > 0)
        {
            $_message = $this->bulk_template($config['template'], $config['template_config']);
        }

        if (isset($config['attach']) && is_array($config['attach']) && sizeof($config['attach']) > 0)
        {
            $_attach = $config['attach'];
        }

        $data['to']		= $config['to'];
        $data['subject']= $config['subject'];
        $data['title']	= 'Crypto Currency MLM System';
        $data['message']= $_message;
        

        $nowtime = date("Y-m-d H:i:s");
        $delivary = array(
        	'reciver_email'			=>$data['to'],
        	'delivery_date_time'	=>$nowtime,
        	'message'				=>$data['message']
        );

        $this->db->insert("email_delivery",$delivary);

        #send mail
        $this->send_email($data);
    }

	private function bulk_template($template = null, $data = array())
    {

        $newStr = $template;
        foreach ($data as $key => $value) {

            $fkey = array_keys($value);
            $newStr = str_replace("{".$fkey[0]."}", $value[$fkey[0]], $newStr);

        }

        return $newStr; 

    }


	public function get_setting(){
		return $settings = $this->db->select("email,phone,time_zone,title")
    		->get('setting')
    		->row();
	}

	public function getFees($table,$id)
	{
		return $this->db->select('*')
		->from($table)
		->where($table.'_id',$id)
		->get()
		->row();
	}


	public function payment_gateway()
	{
		return $this->db->select('*')
		->from('payment_gateway')
		->where('status', 1)
		->get()
		->result();
	}

	public function payment_gateway_common()
	{
		$coininfo 	= $this->get_coin_info();
		$p 			= $coininfo->pair_with;
		$identity 	= "";

		if($p=="USD"){
			$identity 	= array('payeer','paypal','stripe','phone','bank','limoney','ccavenue');
		}
		else if($p=="INR"||$p=="SGD"||$p=="GBP"||$p=="EUR"){
			$identity 	= array('ccavenue');
		}
		else if($p=="BTC"){
			$identity = array('payeer','bitcoin','coinpayment');
		}
		else if($p=="BCH"||$p=="LTC"||$p=="DASH"||$p=="DOGE"||$p=="POT"||$p=="VTC"||$p=="PPC"||$p=="MUE"||$p=="UNIT"){
			$identity = array('bitcoin','coinpayment');
		}
		else if($p=="BSV"||$p=="SPD"||$p=="RDD"||$p=="FTC"){
			$identity = array('bitcoin');
		}
		else{
			$identity = array('phone','bank','coinpayment');
		}

		return $this->db->select('*')
			->from('payment_gateway')
			->where_in('identity',$identity)
			->where('status', 1)
			->get()
			->result();
	}

	public function get_coin_info()
	{
		return $this->db->select('*')
		->from('dbt_sto_setup')
		->get()
		->row();
	}

	public function getMenuSingelRoleInfo($id="")
	{
		$role_id = $this->session->userdata('role_id');

		if($role_id!=0){

			return $this->db->select('*')
				->from('dbt_role_permission')
				->where('role_id',$role_id)
				->where('sub_menu_id',$id)
				->get()
				->row();
		}
		else{
			return "";
		}
	}

	public function getMenuLink($id="")
	{
		return $this->db->select('*')
				->from('dbt_sub_menu')
				->where('id',$id)
				->get()
				->row();
	}


}