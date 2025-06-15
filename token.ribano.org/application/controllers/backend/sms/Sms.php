<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

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
			'backend/dashboard/sms_model'
		));
		
	}
 
 
	public function index()
	{
		$data['title'] 	  = display('send_bulk_sms');
		$data['template'] = $this->sms_model->template();
		$data['content']  = $this->load->view('backend/dashboard/sms/bulk_sms',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function custom_sms()
	{
		$data['title'] 	  = display('send_custom_sms');
		$data['content']  = $this->load->view('backend/dashboard/sms/custom_sms',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function send_custom_sms()
	{
		$this->load->library('sms_lib');

		$receiver 	  = $this->input->post("receiver",TRUE);
		$sms_template = $this->input->post("sms_template",TRUE);

		$config = array(
			'template'			=>@$sms_template,
			'to'			 	=>@$receiver,
			'template_config'	=>''
		);

		$data = $this->sms_lib->sms_rank_send($config);
		
        if($data=='true')
        {
            $this->session->set_flashdata("message",display('send_successfully'));

            $nowtime	  = date("Y-m-d H:i:s");
            $data = array(
            	'receiver'	=>@$receiver,
            	'date_time'	=>$nowtime,
            	'message'	=>$sms_template
            );
            $this->db->insert("sms_delivery",$data);
        }
        else{
            $this->session->set_flashdata("exception",display('sms_not_send'));
        }

		redirect('backend/sms/sms/custom_sms');
	}

	public function send_bulk_sms()
	{
		$user_type				= $this->input->post('user_type',TRUE);
		$selected_template		= $this->input->post('selected_template',TRUE);

		$nowtime 		= date('Y-m-d H:i:s');

		$insert_data = array(
			'sms_temp_id'	=>$selected_template,
			'next_id'		=>0,
			'next_time'		=>$nowtime,
			'status'		=>1
		);

		$this->db->insert("sms_temp_cornjobs",$insert_data);

		
        $this->session->set_flashdata("message",display('send_successfully'));

		redirect('backend/sms/sms');

	}

	public function template()
	{
		$data['title'] 		= display('sms_template');
		$data['template'] 	= $this->sms_model->template();
		$data['content'] 	= $this->load->view('backend/dashboard/sms/list',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function add_template()
	{
		$data['title'] 		= display('add_template');
		$data['content'] 	= $this->load->view('backend/dashboard/sms/form',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function template_save()
	{
		$template_name = $this->input->post('template_name',TRUE);
		$template = $this->input->post('template',TRUE);

		$data = array(
			'teamplate_name'=>$template_name,
			'teamplate'		=>$template
		);

		$this->sms_model->save_template($data);
		$this->session->set_flashdata("message",display('add_successfully'));

		redirect("backend/sms/sms/template");
	}

	public function set_template_status($id){

		if($id==""){
			$id = $this->uri->segment(5);
		}

        $status = 1;

        $this->db->set('default_status',$status);

        $this->db->where('teamplate_id', $id);

        $this->db->update('sms_teamplate');

        $this->session->set_flashdata('message',display('active_successfully'));

        redirect('backend/sms/sms/template');

 	}

 	public function edit_template($id){

		$data['template'] = $this->sms_model->template($id);
		$data['title'] 	  = display('edit_template');

		$data['content'] 	= $this->load->view('backend/dashboard/sms/edit_template',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);

	}

	public function update_template(){

		$Template = array(

			'teamplate_name'	=> $this->input->post('template_name',TRUE),
			'teamplate' 		=> $this->input->post('template',TRUE)

		);

		$id = $this->input->post('id',TRUE);

		$this->db->where('teamplate_id',$id)->update('sms_teamplate',$Template);

		$this->session->set_flashdata('message',display('update_successfully'));

    	redirect('backend/sms/sms/template');

	}

 	public function delete_template($id){

		$this->db->where('teamplate_id',$id)->delete('sms_teamplate');

		$this->session->set_flashdata('exception',display('delete_successfully'));

    	redirect('backend/sms/sms/template');
	}

	private function templateconfig($user_id)
	{
		$data 		 = $this->email_model->gettemplatconfig($user_id);
		$reservedata = $this->email_model->assignreservekey($data);

		return $reservedata;
	}

	public function sms_schedule()
	{
		$data['title'] 			= display('sms_schedule');
		$data['template']		= $this->sms_model->template();
		$data['schedule_list'] 	= $this->sms_model->sms_schedule_list();
		$data['content'] 		= $this->load->view('backend/dashboard/sms/sms_schedule',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function save_schedule()
	{

		$user_type 		= $this->input->post('user_type',TRUE);
		$shedule_time 	= $this->input->post('shedule_time',TRUE);
	    $schedule 		= $shedule_time;

	    $hit_time	= $shedule_time;

    	$check_exist = $this->db->select('hit_time')->from('sms_schedule')->where('hit_time',$schedule)->get()->row();

    

	    if($check_exist){

	      $this->session->set_flashdata('exception',$schedule. ', Its Allrady Exist');

	      redirect("backend/sms/sms/sms_schedule");

	    }else{

		    $data = array(
		        'ss_teamplate_id'	=> $this->input->post('template_id',TRUE),
		        'ss_name'			=> $this->input->post('schedule_name',TRUE),
				'hit_time'			=> $hit_time,
				'ss_status'			=> 1
		    );

		    $this->db->insert('sms_schedule',$data);

			$this->session->set_flashdata('message',display('add_successfully'));

	    	redirect("backend/sms/sms/sms_schedule");

	    }
	}

	public function delete_schedule($id)
	{

		$this->db->where('ss_id',$id)->delete('sms_schedule');

		$this->session->set_flashdata('exception',display('delete_successfully'));

    	redirect("backend/sms/sms/sms_schedule");

	}

	public function reciever_list()
	{
		$data['title'] 			= display('reciever_list');
		
		$config["base_url"] = base_url('backend/dashboard/sms/reciever_list');
        $config["total_rows"] = $this->db->count_all('sms_delivery');
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
        $data['receiver_list'] = $this->sms_model->sms_delivery_list($config["per_page"], $page);
        $data["links"] 		= $this->pagination->create_links();
		$data['content'] 		= $this->load->view('backend/dashboard/sms/reciever_list',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}


}