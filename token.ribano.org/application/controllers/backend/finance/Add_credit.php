<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_credit extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
        if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
        
        if (!$this->session->userdata('isLogIn')) 
        redirect('admin'); 
    
		$this->load->model(array(
            'backend/dashboard/message_model' 
		));
		
		$globdata['coininfo'] = $this->db->select('*')->from('dbt_sto_setup')->get()->row();
		$this->load->vars($globdata);

	}

    public function index()
    {  

        $data['title'] = display('add_credit');
        $this->load->model('common_model');
        $data['userrole'] = $this->common_model->getMenuSingelRoleInfo(5);
        $data['content'] = $this->load->view("backend/finance/add_credit", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);  
    }

    public function send_credit()
    {
        $data['title'] = display('add_credit');
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('user_id', display('user_id') ,'required|alpha_numeric|max_length[6]|xss_clean');
        $this->form_validation->set_rules('amount', display('amount'),'required|xss_clean');
        $this->form_validation->set_rules('note', display('note'),'required|trim|xss_clean');
        /*-------------STORE DATA------------*/

        if ($this->form_validation->run()) {

            $amount = $this->input->post('amount',TRUE);
            if($amount<=0){
                $this->session->set_flashdata('exception', display('invalid_amount'));
                redirect('backend/finance/add_credit');
            }

            $balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $this->input->post('user_id',TRUE))->get()->row();

            $balance_data = array(
                'user_id'       => $this->input->post('user_id',TRUE),
                'balance'       => $amount+@$balance->balance,
                'last_update'   => date('Y-m-d h:i:s'),
            );


            if ($balance) {

               $this->db->set('balance', ($amount+@$balance->balance))->where('user_id', $this->input->post('user_id',TRUE))->update("dbt_balance");

               $balance_id = $balance->id;

            }else{
                $this->db->insert('dbt_balance', $balance_data);
                $balance_id = $this->db->insert_id();

            }

            $deposit_data = array(
                'user_id'                   => $this->input->post('user_id',TRUE),
                'amount'                    => $amount,
                'method'                    => "ADMIN",
                'fees_amount'               => 0,
                'comment'                   => $this->input->post('note',TRUE),
                'deposit_date'              => date('Y-m-d h:i:s'),
                'approved_date'             => date('Y-m-d h:i:s'),
                'status'                    => 1,
                'ip'                        => $this->input->ip_address(),
                'approved_cancel_by'        => 'admin',
            );

            $this->db->insert('dbt_deposit', $deposit_data);
            
            $balance_log = array(
                'balance_id'        => $balance_id,
                'user_id'           => $this->input->post('user_id',TRUE),
                'transaction_type'  => "CREDITED",
                'transaction_amount'=> $amount,
                'transaction_fees'  => 0,
                'ip'                => $this->input->ip_address(),
                'date'              => date('Y-m-d H:i:s'),
            );
            //User Balance log
            $this->db->insert('dbt_balance_log', $balance_log);


            $this->session->set_flashdata('message',display('send_the_amount_successfully'));
            redirect('backend/finance/add_credit');

        } else {

            $data['title'] = display('add_credit');
            $data['content'] = $this->load->view("backend/finance/add_credit", $data, true);
            $this->load->view("backend/layout/main_wrapper", $data);  

        }
    }

    public function credit_details($id=NULL)
    {

        $data['title'] = display('credit_info');

        $data['credit_info'] = $this->db->select('deposit.*,
            dbt_user.user_id,
            dbt_user.first_name,
            dbt_user.last_name,dbt_user.phone,dbt_user.email')
            ->from('dbt_deposit deposit')
            ->join('dbt_user','dbt_user.user_id=deposit.user_id')
            ->where('deposit.method','ADMIN')
            ->where('deposit.id', $id)
            ->where('deposit.status',1)
            ->get()
            ->row(); 

        $data['content'] = $this->load->view("backend/finance/credit_details", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data); 


    } 
	
}
