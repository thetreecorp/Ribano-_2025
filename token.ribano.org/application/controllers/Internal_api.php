<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Internal_api extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }

    /*********************
    |Websites Internal API|
    **********************/

    public function get_chart_data()
    {
        //Chart Data
        $this->load->model('website/web_model');

        //total token
        $secured_sto    = $this->db->select_sum('secured')->from('dbt_sto_manager')->get()->row();
        $guranteed_sto  = $this->db->select_sum('guaranteed')->from('dbt_sto_manager')->get()->row();
        $isto           = $this->db->select_sum('non_secured')->from('dbt_sto_manager')->get()->row();
        //total sold token
        $sold_secured_sto    = $this->db->select_sum('num_share')->from('package')->where('pack_type','secured')->get()->row();
        $sold_guranteed_sto  = $this->db->select_sum('num_share')->from('package')->where('pack_type','guaranteed')->get()->row();
        $sold_isto           = $this->db->select_sum('target')->from('dbt_release_setup')->get()->row();
        
        $total_token = $secured_sto->secured+$guranteed_sto->guaranteed+$isto->non_secured;
        $total_sales_token = (@$sold_secured_sto->num_share?@$sold_secured_sto->num_share:0)+(@$sold_guranteed_sto->num_share?@$sold_guranteed_sto->num_share:0)+(@$sold_isto->target?@$sold_isto->target:0);
        
        $avaible_sto = $total_token-$total_sales_token;
        
        $chartarticle1 = !empty($this->web_model->getWebArticleData('web_chart',1))?$this->web_model->getWebArticleData('web_chart',1):$this->web_model->getWebArticleData('web_chart',1);

        $chartarticle2 = !empty($this->web_model->getWebArticleData('web_chart',2))?$this->web_model->getWebArticleData('web_chart',2):$this->web_model->getWebArticleData('web_chart',2);

        $color0  = array();
        $data0   = array();
        $i=1;
        foreach ($chartarticle1 as $key0 => $value0) {
            array_push($color0, $value0->article_image);
            if($i==1){
                $data0[] = array('value'=>$secured_sto->secured,'name'=>$value0->article_data);
            }
            else if($i==2){
                $data0[] = array('value'=>$guranteed_sto->guaranteed,'name'=>$value0->article_data);
            }
            else if($i==3){
                $data0[] = array('value'=>$isto->non_secured,'name'=>$value0->article_data);
            }

            $i++;
        }

        $color1 = array();
        $data1  = array();
        $i = 1;
        foreach ($chartarticle2 as $key1 => $value1) {
            array_push($color1, $value1->article_image);
            if($i==1){
                $data1[] = array('value'=>(@$sold_secured_sto->num_share?@$sold_secured_sto->num_share:0),'name'=>$value1->article_data);
            }
            else if($i==2){
                $data1[] = array('value'=>(@$sold_guranteed_sto->num_share?@$sold_guranteed_sto->num_share:0),'name'=>$value1->article_data);
            }
            else if($i==3){
                $data1[] = array('value'=>(@$sold_isto->target?@$sold_isto->target:0),'name'=>$value1->article_data);
            }
            else if($i==4){
                $data1[] = array('value'=>$avaible_sto,'name'=>$value1->article_data);
            }
            $i++;
        }

        echo json_encode(array('color0'=>$color0,'data0'=>$data0,'color1'=>$color1,'data1'=>$data1));
    }

    public function getflipdata()
    {
        $this->load->model('website/web_model');

        $result = $this->db->select('*')->from('setting')->get()->row();
        date_default_timezone_set(@$result->time_zone);
        $nowtime      = date("Y-m-d H:i:s");

        $coinreleasetimedata    = $this->web_model->coin_release_time($nowtime);
        $checkitem              = $coinreleasetimedata->num_rows();
        $coinrelease            = $coinreleasetimedata->row();
        $fliptime               = 0;
        if($checkitem>0){

            $releasetime        = date("Y-m-d H:i:s",strtotime("$coinrelease->start_date +$coinrelease->day day"));
            $realreleasetime    = strtotime($releasetime)-strtotime($nowtime);
            if($realreleasetime>0){
                $fliptime       = $realreleasetime;
            }
        }
        
        echo json_encode(array('fliptime' => $fliptime));
    }

    public function translate_language()
    {
        $lang = $this->input->get('lang',TRUE);

        if(!empty($lang)){
            echo json_encode(array('language' => display($lang)));
        }
        else{
            echo json_encode(array('language' => ""));
        }
    }

    /*********************
    |Backend Internal API|
    **********************/
    public function getadvirtigementdata()
    {
        $id = $this->input->get('id',TRUE);

        $this->load->model('backend/cms/advertisement_model');
        $advertisement = $this->advertisement_model->single($id);

        echo json_encode($advertisement);
    }

    public function getsummernoteinformation()
    {
        $this->load->model('backend/cms/language_model');

        $web_language = $this->language_model->single();

        echo json_encode($web_language);
    }

    public function getemailsmsgateway()
    {
        $sms = $this->db->select('*')->from('email_sms_gateway')->where('es_id', 1)->get()->row();

        echo json_encode($sms);
    }

    public function getlinechartdata()
    {
        $this->load->model('backend/dashboard/dashboard_model');

        $monthlyInvestment = $this->dashboard_model->monthlyInvestment();
        
        $months       = array();
        $investamount = array();
        foreach ($monthlyInvestment as $key => $value) {
            array_push($months,$value->month);
            array_push($investamount,$value->invest);
        }
        
        echo json_encode(array('investamount'=>$investamount,'months'=>$months));
    }

    public function getdepositgatewaydata()
    {
        $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'phone')->where('status',1)->get()->row();

        echo json_encode($gateway);
    }

    public function getmenucontrollerinfo()
    {
        $menucontrol = $this->db->select('*')->from('dbt_menu_controller')->get()->row();

        echo json_encode($menucontrol);
    }

    public function gettokenbuydata()
    {
        $this->load->model('common_model');

        $coininfo   = $this->common_model->get_coin_info();
        $coin_price = $this->db->select("*")->from('dbt_currency')->where('symbol', $coininfo->pair_with)->where('status', 1)->get()->row();

        echo json_encode(array('coininfo'=>$coininfo,'coin_price'=>$coin_price));
    }

    public function getcoininfo()
    {
        $this->load->model('common_model');

        $coininfo = $this->common_model->get_coin_info();

        echo json_encode($coininfo);
    }

}