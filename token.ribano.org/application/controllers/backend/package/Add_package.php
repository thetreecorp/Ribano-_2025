<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_package extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();
 		
 		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
 		
		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

		$this->load->model(array(
 			'backend/package/package_model',
 			'common_model' 
 		));
			
		$globdata['stoinfo'] = $this->db->select('*')->from('dbt_sto_setup')->get()->row();
		$this->load->vars($globdata);
 	}
 
	public function index($package_id = null)
	{ 
		$data['title']  = display('add_package');
		$data['userrole'] = $this->common_model->getMenuSingelRoleInfo(17);
		
		$this->form_validation->set_rules('package_name', display('package_name'),'required|max_length[20]|xss_clean');
		$this->form_validation->set_rules('pack_type', display('pack_type'),'required|xss_clean');
		$this->form_validation->set_rules('num_share', display('num_share'),'required|trim|xss_clean');
		$this->form_validation->set_rules('package_price', display('package_price'),'required|trim|xss_clean');
		$this->form_validation->set_rules('package_term', display('package_term'),'required|xss_clean');
		$this->form_validation->set_rules('package_period', display('period'),'required|trim|xss_clean|greater_than_equal_to[7]');
		$this->form_validation->set_rules('facility_type', display('facility_type'),'required|trim|xss_clean');

		if($this->input->post('facility_type',TRUE)==1){

			$this->form_validation->set_rules('weekly_roi', display('weekly_roi'),'required|max_length[11]|xss_clean');
			$this->form_validation->set_rules('monthly_roi', display('monthly_roi'),'required|max_length[11]|xss_clean');
			$this->form_validation->set_rules('yearly_roi', display('yearly_roi'),'required|max_length[11]|xss_clean');
			$this->form_validation->set_rules('total_percent', display('total_percent'),'required|max_length[11]|xss_clean');
			$this->form_validation->set_rules('status', display('status'),'required|max_length[1]|xss_clean');
		}

		if ($this->form_validation->run()) 
		{
			$package_name 		= $this->input->post('package_name',TRUE);
			$pack_type 			= $this->input->post('pack_type',TRUE);
			$num_share 			= $this->input->post('num_share',TRUE);
			$package_price 		= $this->input->post('package_price',TRUE);
			$package_term 		= $this->input->post('package_term',TRUE);
			$package_period 	= $this->input->post('package_period',TRUE);

			if($num_share<=0 || $package_price<=0){
				$this->session->set_flashdata('exception', display('invalid_amount'));
                redirect("backend/package/add_package");
			}

			$facility_data 		= array();

			if($this->input->post('facility',TRUE)){
				$facility = $this->input->post('facility',TRUE);
				foreach ($facility as $value) {
					if(!empty($value)){
						if(empty($facility_data)){
							$facility_data = array($value);
						}
						else{
							array_push($facility_data,$value);
						}
					}
				}
			}

			$jsondata = $facility_data?json_encode($facility_data):"";

			if($this->input->post('facility_type',TRUE)==1){

				$packdata = array(
					'package_name'		=> $package_name,
					'pack_type'			=> $pack_type,
					'num_share'			=> $num_share,
					'package_price'		=> $package_price,
					'period'			=> $package_period,
					'package_term'		=> $package_term,
					'facility_type'		=> $this->input->post('facility_type',TRUE),
					'weekly_roi' 	  	=> $this->input->post('weekly_roi',TRUE),
					'monthly_roi' 	  	=> $this->input->post('monthly_roi',TRUE), 
					'yearly_roi' 	  	=> $this->input->post('yearly_roi',TRUE), 
					'total_percent'   	=> $this->input->post('total_percent',TRUE), 
					'status'          	=> $this->input->post('status',TRUE),
					'data' 				=> ""
				);
			}
			else{

				$packdata = array(
					'package_name'		=> $package_name,
					'pack_type'			=> $pack_type,
					'num_share'			=> $num_share,
					'package_price'		=> $package_price,
					'period'			=> $package_period,
					'package_term'		=> $package_term,
					'facility_type'		=> $this->input->post('facility_type',TRUE),
					'status'			=> $this->input->post('status',TRUE),
					'data' 				=> $jsondata,
					'weekly_roi' 	  	=> 0,
					'monthly_roi' 	  	=> 0, 
					'yearly_roi' 	  	=> 0, 
					'total_percent'   	=> ""
				);

			}

			$packageExists = $this->db->select('*')
		            ->where('package_name',$package_name)
		            ->where('pack_type',$pack_type)
		            ->where_not_in('package_id',$package_id) 
		            ->get('package')
		            ->num_rows();

			if (empty($package_id)) 
			{

		        if ($packageExists > 0) {

		        	$this->session->set_flashdata('exception',display('package_name_exists'));

		        } else {

		        	$packageusesSTO = $this->db->select_sum('num_share')->from('package')->where('pack_type',$pack_type)->get()->row();
		        	$totalSTO = $this->db->select_sum($pack_type)->from('dbt_sto_manager')->get()->row();
					$totaluseSTO = @$packageusesSTO->num_share?@$packageusesSTO->num_share+$num_share:$num_share;

		        	if($totalSTO->$pack_type >= $totaluseSTO){

		        		if ($this->package_model->create($packdata)) {
							$this->session->set_flashdata('message', display('save_successfully'));
						} else {
							$this->session->set_flashdata('exception', display('please_try_again'));
						}
		        	}
		        	else{
		        		$this->session->set_flashdata('exception',display('insufficent_sto'));
		        	}
		            
		        }
		        redirect("backend/package/add_package");

			} 
			else 
			{
				if ($packageExists > 1) {

		        	$this->session->set_flashdata('exception',display('package_name_exists'));

		        } else {

					$packageusesSTO = $this->db->select_sum('num_share')->from('package')->where('pack_type',$pack_type)->where_not_in('package_id',$package_id)->get()->row();
		        	$totalSTO = $this->db->select_sum($pack_type)->from('dbt_sto_manager')->get()->row();

		        	$totaluseSTO = @$packageusesSTO->num_share?@$packageusesSTO->num_share+$num_share:$num_share;

		        	if($totalSTO->$pack_type >= $totaluseSTO){

		        		if ($this->package_model->update($packdata,$package_id)) {
							$this->session->set_flashdata('message', display('update_successfully'));
						} else {
							$this->session->set_flashdata('exception', display('please_try_again'));
						}
		        	}
		        	else{
			        	$this->session->set_flashdata('exception',display('insufficent_sto'));
			        }
			    }
				redirect("backend/package/add_package/index/$package_id");
			}
		} 
		else 
		{ 
			if(!empty($package_id)) {
				$data['title'] = display('edit_package');
				$data['package']   = $this->package_model->single($package_id);
			}
			$data['content'] = $this->load->view("backend/package/add_package", $data, true);
			$this->load->view("backend/layout/main_wrapper", $data);
		}
	}

    /*
    |----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
    */
    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if($mode == 1):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 2):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif($mode == 3):
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 4):
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++) {
                $randItem = array_rand($charArray);
                $result .="".$charArray[$randItem];
        }
        return $result;
    }
    /*
    |----------------------------------------------
    |         Ends of id genaretor
    |----------------------------------------------
    */


}
