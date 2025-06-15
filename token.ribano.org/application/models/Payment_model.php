<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model{
    function __construct() {

    }

    //All payment Log Data
    public function bitcoinPaymentLog($data = array()){
       

    }
    public function payeerPaymentLog($data = array()){

       return $this->db->insert('payeer_payments', $data);

    }
    public function paypalPaymentLog($data = array()){

               

    }
    public function stripePaymentLog($data = array()){

        

    }
    public function coinpaymentsPaymentLog($data = array()){

        $this->db->insert("coinpayments_payments",$data);

    }
    public function ccavenuePaymentLog($data = array()){

        $this->db->insert("dbt_ccavenue_history",$data);

    }

    //All payment Data
    public function paymentStore($data = array()){
       
        return $this->db->insert('dbt_deposit', $data);

    }

    //Add User Balance
    public function balanceAdd($data = array()){

        $check_user_balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $data->user_id)->get()->row();

        if ($check_user_balance) {

            $updatebalance = array(
                'balance'     => $data->amount+$check_user_balance->balance,
            );

            $this->db->where('user_id', $data->user_id)->update("dbt_balance", $updatebalance);

            return  $check_user_balance->id;

        }else{

            $insertbalance = array(
                'user_id'         => $data->user_id,
                'balance'         => $data->amount,
                'last_update'     => date('Y-m-d h:i:s'),
            );
            $this->db->insert('dbt_balance', $insertbalance);

            return  $this->db->insert_id();

        }
        

    }


    public function coinpayments_balanceAdd($data = array()){

        $check_user_balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $data['user_id'])->get()->row();
        
        if ($check_user_balance) {

            $updatebalance = array(
                'balance'     => ($data['amount']+$check_user_balance->balance)-(float)@$data['fees_amount'],
            );

            $this->db->where('user_id', $data['user_id'])->update("dbt_balance", $updatebalance);

            return  $check_user_balance->id;

        }else{

            $insertbalance = array(
                'user_id'         => $data['user_id'],
                'balance'         => $data['amount']-(float)@$data['fees_amount'],
                'last_update'     => date('Y-m-d h:i:s'),
            );
            $this->db->insert('dbt_balance', $insertbalance);

            return  $this->db->insert_id();

        }
        

    }

    //Balance Log
    public function balancelog($data = array()){
       
        return $this->db->insert('dbt_balance_log', $data);

    }

    public function checkBalance($user=null)
    {
        if ($user==null) {
            $user = $this->session->userdata('user_id');
        }

        return $this->db->select('*')
            ->from('dbt_balance')
            ->where('user_id', $user)
            ->get()
            ->row();

    }

    public function confirm_coinpayment_deposit($data = array()){

        $updatedata = array(
            'deposit_date'  =>$data['depositdate'],
            'approved_date' =>$data['depositdate'],
            'status'        =>1
        );

        $wheredata = array(
            'user_id'           =>$data['user_id'],
            'comment'           =>$data['comment']
        );

        $this->db->where($wheredata);
        $this->db->update('dbt_deposit',$updatedata);

    }


}