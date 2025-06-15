<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Helpline extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

    	if (!$this->session->userdata('isLogIn')) 
            redirect('login');

            if (!$this->session->userdata('user_id')) 
            redirect('login'); 

    	$this->load->model(array(
    		'shareholder/currency_model'  
    	));
	}

	public function index()
	{
		$data['title'] 	 = display('helpline');

		$config["base_url"] = base_url('shareholder/helpline/index');
        $config["total_rows"] = $this->db->select('*')
        ->from('dbt_messenger')
        ->where('sender_id !=','admin')
        ->where('sender_id',$this->session->userdata('user_id'))
        ->get()->num_rows();
        $config["per_page"] = 15;
        $config["uri_segment"] = 4;
        $config["last_link"] = "Last"; 
        $config["first_link"] = "First"; 
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';  
        $config['full_tag_open'] = "<ul class='pagination col-xs pull-right'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['message'] = $this->db->select('dbt_messenger.*,dbt_user.first_name,dbt_user.last_name,dbt_user.id as user_id')
			->from('dbt_messenger')
			->join('dbt_user','dbt_messenger.sender_id = dbt_user.user_id')
			->order_by('id','DESC')
			->where('sender_id',$this->session->userdata('user_id'))
			->limit($config["per_page"], $page)
			->get()
			->result();
        
        $data["links"] = $this->pagination->create_links();

		$data['content'] = $this->load->view("shareholder/helpline/helpline", $data, true);
		$this->load->view("shareholder/layout/main_wrapper", $data);
	}

	public function subject($id=null)
	{
		$user_id = $this->session->userdata('user_id');
		$this->db->set('status',0)->where('replay_id',$id)->where('status',1)->update('dbt_messenger');
		$this->db->set('admin_status',0)->where('id',$id)->where('admin_status',1)->update('dbt_messenger');
		$this->db->set('admin_status',0)->where('replay_id',$id)->where('reciver_id',$user_id)->where('admin_status',1)->update('dbt_messenger');
		$data['usermessege'] = $this->db->select('dbt_messenger.*,dbt_user.first_name,dbt_user.last_name,dbt_user.email,,dbt_user.image as user_img')
			->from('dbt_messenger')
			->join('dbt_user','dbt_messenger.sender_id=dbt_user.user_id')
			->where('dbt_messenger.id',$id)
			->get()
			->row();

		$data['adminmessege']= $this->db->select('*')->from('dbt_messenger')->where('replay_id',$id)->get()->result();

		$data['content'] = $this->load->view("shareholder/helpline/helpline_details", $data, true);
		$this->load->view("shareholder/layout/main_wrapper", $data);
	}

	public function send_message()
	{
		$this->form_validation->set_rules('subject', display('subject'),'required|xss_clean');
		$this->form_validation->set_rules('message', display('message'),'required|xss_clean');

		if($this->form_validation->run()){

			$subject = $this->input->post('subject',TRUE);
			$message = $this->input->post('message',TRUE);

			$data = array(
				'sender_id'	=> $this->session->userdata('user_id'),
				'reciver_id'=> 'admin',
				'subject'	=> $subject,
				'messege'	=> $message,
				'date_time'	=> date('Y-m-d H:i:s'),
				'status'	=> 1
			);
			$this->db->insert("dbt_messenger",$data);
		}
		redirect("shareholder/helpline");
	}

}