<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shareholder extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'backend/user/user_model',
            'shareholder/transections_model',
            'common_model'
        ));
        
        if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
        
        if (!$this->session->userdata('isLogin') 
            && !$this->session->userdata('isAdmin'))
            redirect('admin');
    }
 
    public function index()
    {  
        $data['title']  = display('user_list');

        $data['content'] = $this->load->view("backend/shareholders/shareholder_list", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);
    }

    /*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
    public function ajax_list()
    {
        $list = $this->user_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $users) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="'.base_url("backend/shareholders/shareholder/user_details/$users->id").'">'.$users->user_id.'</a>';
            $row[] = '<a href="'.base_url("backend/shareholders/shareholder/user_details/$users->id").'">'.$users->first_name." ".$users->last_name.'</a>';
            $row[] = '<a href="'.base_url("backend/shareholders/shareholder/user_details/$users->id").'">'.$users->referral_id.'</a>';
            $row[] = $users->email;
            $row[] = $users->phone;
            $row[] = '<a href="'.base_url("backend/shareholders/add_shareholder/index/$users->id").'"'.' class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>  '.(($users->status==1)?'<button class="btn btn-success btn-sm">Active</button>':(($users->status==2)?'<button class="btn btn-danger btn-sm">Pending</button>':(($users->status==3)?'<button class="btn btn-danger btn-sm">Suspend</button>':'<a href="'.base_url("backend/shareholders/shareholder/update_shareholder/$users->id").'"><button class="btn btn-kingfisher-daisy btn-sm" type="button">Deactive</button></a>'))).'  '.(($users->verified==1)?'<button class="btn btn-success btn-sm">verified</button>':(($users->verified==2)?'<button class="btn btn-danger btn-sm">Cancel</button>':(($users->verified==3)?'<a href='.base_url("backend/shareholders/shareholder/pending_user_verification/$users->user_id").' class="btn btn-info btn-sm" data-toggle="tooltip">Requested</a>':'<button class="btn btn-danger btn-sm">Not Verified</button>')));

            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->user_model->count_all(),
                "recordsFiltered" => $this->user_model->count_filtered(),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }


    public function email_check($email, $id)
    { 
        $emailExists = $this->db->select('email')
            ->where('email',$email) 
            ->where_not_in('id',$id) 
            ->get('dbt_user')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} is already registered.');
            return false;
        } else {
            return true;
        }
    }

    public function user_details($id = null)
    {
        $data['title']  = display('details');
        $data['id']     = $id;

        $this->form_validation->set_rules('user_id','User Id','required|trim|exact_length[6]|alpha_numeric');

        if($this->form_validation->run()){
            $user_id             = $this->input->post('user_id',TRUE);
            $data                = $this->transections_model->transections_all_sums($user_id);
            $data['user']        = $user = $this->user_model->singleByUserId($user_id);
            $data['transection'] = $this->user_model->all_transection($user_id);
            $data['earning']     = $this->user_model->all_earnings($user_id);

            if(!$user){
                $this->session->set_flashdata('exception',"Sorry, we couldn't find any user for '".$user_id."'");
            }
        }
        else{
            if(!empty($id)) {
                $user_id             = $this->user_model->getUserId($id);
                $data                = $this->transections_model->transections_all_sums($user_id);
                $data['user']        = $this->user_model->single($id);
                $data['transection'] = $this->user_model->all_transection($user_id);
                $data['earning']     = $this->user_model->all_earnings($user_id);
            }
        }

        $data['coin_setup']  = $this->db->select('*')->from('dbt_sto_setup')->get()->row();
        
        $data['content'] = $this->load->view("backend/shareholders/search_user", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);
    }

    public function pending_user_verification($user_id=null)
    {
        $data['title']  = display('pending_user_verify');
        $data['userrole'] = $this->common_model->getMenuSingelRoleInfo(10);
        
        $data['user'] = $this->user_model->singleUserVerifyDoc($user_id);


        $this->form_validation->set_rules('user_id', display('user_id'),'required|trim');

        if ($this->form_validation->run()) 
        {

            if (isset($_POST['cancel'])) {

                $update_verify = $this->db->set('verified', '2')->where('user_id', $this->input->post('user_id',TRUE))->update("dbt_user");

                if ($update_verify) {
                    $this->session->set_flashdata('message', display('save_successfully'));
                    redirect("backend/shareholders/shareholder/pending_user_verification/$user_id");

                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));

                }
            }

            if (isset($_POST['approve'])) {
                
                $update_verify = $this->db->set('verified', '1')->where('user_id', $this->input->post('user_id',TRUE))->update("dbt_user");

                if ($update_verify) {
                    $this->session->set_flashdata('message', display('save_successfully'));
                    redirect("backend/shareholders/shareholder/pending_user_verification/$user_id");

                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));

                }
            }
            
        }



        $data['content'] = $this->load->view("backend/shareholders/pending_user_verification", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);

    }

    public function update_shareholder($user_id=""){
        
        $this->db->set('status',1)->where('id',$user_id)->update("dbt_user");
        $this->session->set_flashdata("message","Shareholder Active Successfully!");
        redirect("backend/shareholders/shareholder");
    }


    public function delete($user_id = null)
    {  
        if ($this->user_model->delete($user_id)) {
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect("backend/shareholders/shareholder");
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
