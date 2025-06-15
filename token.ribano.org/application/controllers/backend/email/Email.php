<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

		if (!$this->session->userdata('isLogIn') 
			&& !$this->session->userdata('isAdmin')
		) 
		redirect('admin'); 
		
		$this->load->model(array(
			'backend/dashboard/setting_model',
			'backend/dashboard/email_model',
			'common_model'
		));	
	}
 
 
	public function index()
	{
		$data['title'] 		= display('email_template');
	    $data['template'] = $this->email_model->gettemplatedata();

		$data['content'] 	= $this->load->view('backend/dashboard/email/list',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function template_form()
	{
		$data['title'] 		= display('add_email_template');
		$data['content'] 	= $this->load->view('backend/dashboard/email/form',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function email_template_save()
	{
		$templatedata 		= $this->input->post('email_template',TRUE);
		$template_title 	= $this->input->post('template_subject',TRUE);

		$temdata = array(

			'tem_title'	=>$template_title,
			'template'	=>$templatedata

		);
		
		$this->email_model->savetemplate($temdata);

		$this->session->set_flashdata('message', display('save_successfully'));

		redirect('backend/email/email');
	}

	public function set_default_template($id){

		if($id==""){
			$id = $this->uri->segment(5);
		}

        $status = 1;

        $this->db->set('default_status',$status);

        $this->db->where('email_temp_id', $id);

        $this->db->update('email_template');

        redirect('backend/email/email');

 	}

 	public function delete_template($id){

		$this->db->where('email_temp_id',$id)->delete('email_template');

		$this->session->set_flashdata('exception',display('delete_successfully'));

    	redirect('backend/email/email');
	}

	public function get_email_template($id){

		$data['template'] = $this->email_model->gettemplatedata($id);
		$data['title'] 	  = display('edit_template');

		$data['content'] 	= $this->load->view('backend/dashboard/email/edit_template',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);

	}

	public function update_template(){

		$Template = array(

			'tem_title'	=> $this->input->post('template_subject',TRUE),

			'template'	=> $this->input->post('email_template',TRUE)

		);

		$id = $this->input->post('id',TRUE);

		$this->db->where('email_temp_id',$id)->update('email_template',$Template);

		$this->session->set_flashdata('message',display('update_msg'));

    	redirect('backend/email/email');

	}

	public function bulk_email()
	{
		$data['template'] 	= $this->email_model->getactivetemplatedata();
		$data['title'] 		= display('bulk_email');
		$data['content'] 	= $this->load->view('backend/dashboard/email/bulk_email',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function custom_email()
	{
		$data['title'] 		= display('send_custom_email');
		$data['content'] 	= $this->load->view('backend/dashboard/email/custom_email',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function send_custom_email()
	{
		$receiver_email = $this->input->post('receiver_email',TRUE);
		$email_subject 	= $this->input->post('email_subject',TRUE);
		$email_template = $this->input->post('email_template',TRUE);

		$data = array(
			'to' =>$receiver_email,
			'subject'=>$email_subject,
			'message'=>$email_template
		);

		$this->common_model->send_email($data);
		$nowtime = date("Y-m-d H:i:s");
        $delivary = array(
        	'reciver_email'			=>@$receiver_email,
        	'delivery_date_time'	=>@$nowtime,
        	'message'				=>$email_template
        );

        $this->db->insert("email_delivery",$delivary);
		$this->session->set_flashdata('message',display('send_successfully'));

    	redirect('backend/email/email/custom_email');
	}

	public function email_schedule_setup()
	{
	    $data['title'] 			= display('email_schedule_setup');
	    $data['template'] 		= $this->email_model->gettemplatedata();
	    $data['schedule_list'] 	= $this->email_model->schedule_list();
		$data['content'] 		= $this->load->view('backend/dashboard/email/email_schedule_setup',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function save_schedule()
	{
		$shedule_time 	= $this->input->post('shedule_time',TRUE);

	    $schedule 		= $shedule_time;

	    $hit_time		= $shedule_time;
    	$check_exist 	= $this->db->select('hit_time')->from('email_schedule')->where('hit_time',$schedule)->get()->row();

	    if($check_exist){

	      $this->session->set_flashdata('exception',$schedule. ', Its Allrady Exist');

	      redirect("backend/email/email/email_schedule_setup");

	    }else{

		    $data = array(
		        'email_temp_id'	=> $this->input->post('template_id',TRUE),
		        'email_ss_name'	=> $this->input->post('schedule_name',TRUE),
		        'mail_subject'	=> $this->input->post('mail_subject',TRUE),
				'hit_time'		=> $hit_time
		    );

		    $this->db->insert('email_schedule',$data);

			$this->session->set_flashdata('message',display('add_successfully'));

	    	redirect("backend/email/email/email_schedule_setup");

	    }

	}

	public function delete_schedule($id)
	{

		$this->db->where('email_ss_id',$id)->delete('email_schedule');

		$this->session->set_flashdata('exception',display('delete_successfully'));

    	redirect("backend/email/email/email_schedule_setup");

	}

	public function reserve_list()
	{
		$reservekey 		= $this->email_model->getreservekey();
		$data['reservekey'] = $reservekey;
		$data['title'] 		= display('reserve_key');
		$data['content'] 	= $this->load->view('backend/dashboard/reserve/list',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function reserve_form()
	{
		$data['title'] 		= display('add_reserve_key');
		$data['content'] 	= $this->load->view('backend/dashboard/reserve/form',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function reserve_key_save()
	{
		$reserve_key 	 = $this->input->post("reserve_key",TRUE);
		$reserve_details = $this->input->post("reserve_details",TRUE);

		$data = array(
			'reserve_key' =>$reserve_key,
			'key_details' =>$reserve_details
		);

		$this->email_model->savereservekey($data);

		$this->session->set_flashdata('message', display('save_successfully'));

		redirect('backend/email/email/reserve_list');

	}

	public function send_bulk_email()
	{
		$mail_subject	= $this->input->post('mail_subject',TRUE);
		$user_type		= $this->input->post('user_type',TRUE);
		$temconfigid	= $this->input->post('selected_template',TRUE);

		$nowtime 		= date('Y-m-d H:i:s');

		$insert_data = array(
			'subject'		=>$mail_subject,
			'email_temp_id'	=>$temconfigid,
			'next_id'		=>0,
			'next_time'		=>$nowtime,
			'status'		=>1
		);

		$this->db->insert("temp_cornjobs",$insert_data);

		$this->session->set_flashdata('message', display('send_successfully'));

		redirect('backend/email/email/bulk_email');

	}

	public function email_list()
	{
        $config["base_url"] = base_url('backend/email/email/email_list');
        $config["total_rows"] = $this->db->count_all('email_delivery');
        $config["per_page"] = 25;
        $config["uri_segment"] = 5;
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

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $data['email_list'] = $this->email_model->email_list($config["per_page"], $page);
        $data["links"] 		= $this->pagination->create_links();

	    $data['title'] 		= display('receiver_email_list');
		$data['content'] 	= $this->load->view('backend/dashboard/email/recivelist',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);

	}


}
