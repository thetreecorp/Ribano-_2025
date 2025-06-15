<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Web_model extends CI_Model {

	function __construct() {

    }
    public function checkUseridExist($key)
	{	 
		$query = $this->db->where('user_id', $key)->get('dbt_user')->num_rows();
		
		return ($query > 0) ? true : false;

	}

	public function checkEmailExist($key)
	{	 
		$query = $this->db->where('email', $key)->get('dbt_user')->num_rows();

		return ($query > 0) ? true : false;

	}

	public function checkPhoneExist($key)
	{	 
		$query = $this->db->where('phone', $key)->get('dbt_user')->num_rows();

		return ($query > 0) ? true : false;

	}

	public function registerUser($data = array())
	{	 
		$data['created'] = date("Y-m-d H:i:s");        
		return $this->db->insert('dbt_user',$data);

	}

	public function updateUser($data = array())
	{	        
		return $this->db->where('user_id', $data['user_id'])->update("dbt_user", $data);		 

	}

	public function accountStatusCheck($key)
	{	 
		$where = "(email ='".$key."' OR username = '".$key."')";

		$query = $this->db->select('status')->from('dbt_user')->where($where)->get()->row();
		
        return $query->status;

	}

	public function loginCheckUser($data = array())
	{

		$where = "(email ='".$data['email']."' OR username = '".$data['email']."') AND password = '".$data['password']."'";

		return $this->db->select("*")
			->from('dbt_user')
			->where($where)
			->get()
			->row();
	}

	public function passwordtokenCheck($key)
	{	 
		$query = $this->db->select('status')->from('dbt_user')->where('password_reset_token', $key)->get()->row();
		
        return $query;

	}

	public function activeUserAccount($key)
	{
		return $this->db->set('status', '1')
			->where('password_reset_token', $key)
			->update("dbt_user");
	}

	public function storeUserLogData($data = array())
	{
		return $this->db->insert('dbt_user_log', $data);

	}

	public function userVerifyDataStore($data = array())
	{
		return $this->db->insert('dbt_user_verify_doc', $data);

	}

    public function tradeCreate($data = array())
	{
		$this->db->insert('dbt_biding', $data);
		return  $this->db->insert_id();

	}

	public function pendingTrade()
	{
		return $this->db->select('*')
			->from('dbt_biding')
			->where('status', 2)
			->get()
			->result();

	}

	public function openTrade()
	{
		return $this->db->select('*')
			->from('dbt_biding')
			->where('status', 2)
			->where('user_id', $this->session->userdata('user_id'))
			->get()
			->result();

	}

	public function completeTrade()
	{
		return $this->db->select('*')
			->from('dbt_biding')
			->where('status', 1)
			->where('user_id', $this->session->userdata('user_id'))
			->get()
			->result();

	}

	public function tradeHistory($key)
	{
		return $this->db->select('*')
			->from('dbt_biding_log')
			->where('market_symbol', $key)
			->get()
			->result();

	}

	public function coinMarkets()
	{
		return $this->db->select('*')
			->from('dbt_market')
			->where('status', 1)
			->get()
			->result();

	}

	public function coinPairs()
	{
		return $this->db->select('*')
			->from('dbt_coinpair')
			->where('status', 1)
			->get()
			->result();

	}

	public function marketDetails($key=null)
	{
		return $this->db->select('*')
			->from('dbt_coinpair')
			->where('symbol', $key)
			->where('status', 1)
			->get()
			->row();

	}

	public function userTradeHistory()
	{
		return $this->db->select('bidmaster.*, biddetail.bid_type as bid_type1, biddetail.bid_price as bid_price1, biddetail.market_symbol as market_symbol1, biddetail.complete_amount as complete_amount1, biddetail.success_time as success_time1, biddetail.complete_qty, biddetail.complete_amount, biddetail.success_time')
			->from('dbt_biding bidmaster')
			->join('dbt_biding_log biddetail', 'biddetail.bid_id = bidmaster.id', 'left')
			->where('bidmaster.user_id', $this->session->userdata('user_id'))
			->get()
			->result();

	}

	public function checkCoinrate($key)
	{
		return $this->db->select('*')
			->from('dbt_biding_log')
			->where('currency_symbol', $key)
			->where('bid_type', 'buy')
			->order_by("bid_price", "desc")
			->limit(2, 0)
			->get()
			->result();

	}

	public function checkBalance($key, $user=null)
	{
		if ($user==null) {
			$user = $this->session->userdata('user_id');
		}

		return $this->db->select('*')
			->from('dbt_balance')
			->where('user_id', $user)
			->where('currency_symbol', $key)
			->get()
			->row();

	}

	public function balanceLog($key = null, $user = null)
	{
		if ($user==null) {
			$user = $this->session->userdata('user_id');
		}

		return $this->db->select('*')
			->from('dbt_balance_log balancelog')
			->join('dbt_cryptocoin coin', 'balancelog.currency_symbol = coin.symbol')
			->where('user_id', $user)
			->order_by('transaction_type', 'desc')
			->get()
			->result();

	}
	
	public function checkFees($type, $coin)
	{
		return $this->db->select('*')
			->from('dbt_fees')
			->where('level', $type)
			->where('currency_symbol', $coin)
			->get()
			->row();

	}

	public function balanceAdd($data = array())
	{
		$this->db->insert('dbt_balance', $data);
		return  $this->db->insert_id();

	}
	public function balanceDebit($data = array())
	{
		$check_user_balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $data->user_id)->where('currency_symbol', $data->currency_symbol)->get()->row();

		$updatebalance = array(
            'balance'     => $check_user_balance->balance-$data->bid_qty-$data->fees_amount,
        );

        return $this->db->where('user_id', $data->user_id)->where('currency_symbol', $data->currency_symbol)->update("dbt_balance", $updatebalance);

	}

	public function balanceCredit($data = array(), $coin_symbol)
	{
		$check_user_balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $data->user_id)->where('currency_symbol', $coin_symbol)->get()->row();

		$updatebalance = array(
            'balance'     => $check_user_balance->balance-$data->total_amount-$data->fees_amount,
        );

        return $this->db->where('user_id', $data->user_id)->where('currency_symbol', $coin_symbol)->update("dbt_balance", $updatebalance);

	}

	public function checkUserAllBalance()
	{
		return $this->db->select('*')
			->from('dbt_balance balance')
			->join('dbt_cryptocoin coin', 'coin.symbol = balance.currency_symbol', 'left')
			->where('balance.user_id', $this->session->userdata('user_id'))
			->get()
			->result();

	}

	public function withdraw($data)
	{
		$this->db->insert('dbt_withdraw',$data);
		return array('id'=>$this->db->insert_id());
	}

	public function get_withdraw_by_id($id)
	{
		return $this->db->select('*')
		->from('dbt_withdraw')
		->where('id',$id)
		->where('user_id',$this->session->userdata('user_id'))
		->get()->row();
	}
	public function transfer($data)
	{
		$this->db->insert('dbt_transfer',$data);
		return array('id'=>$this->db->insert_id());
	}
	public function availableForBuy($key)
	{
		$sum = $this->db->select_sum('bid_qty_available')
			->from('dbt_biding')
			->where('bid_type', 'buy')
			->where('currency_symbol', $key)
			->get()
			->row();

		return $sum;

	}

	public function verify($data)
	{
		$this->db->insert('dbt_verify',$data);
		return array('id'=>$this->db->insert_id());
	}


    public function get_verify_data($id)
    {
        $v = $this->db->select('*')
        ->from('dbt_verify')
        ->where('id',$id)
        ->where('session_id', $this->session->userdata('isLogIn'))
        ->where('ip_address', $this->input->ip_address())
        ->get()
        ->row();

        return $v;
    }

	public function availableForSell($key)
	{
		$sum = $this->db->select_sum('bid_qty_available')
			->from('dbt_biding')
			->where('bid_type', 'sell')
			->where('currency_symbol', $key)
			->get()
			->row();

		return $sum;

	}

	public function retriveUserInfo()
	{
		return $this->db->select('*')
			->from('dbt_user')
			->where('user_id', $this->session->userdata('user_id'))
			->get()
			->row();

	}

	public function retriveUserlog()
	{
		return $this->db->select('*')
			->from('dbt_user_log')
			->where('user_id', $this->session->userdata('user_id'))
			->order_by('access_time', 'desc')
			->limit(10, 0)
			->get()
			->result();

	}

	//CMS Query Function
	public function slider()
	{
		return $this->db->select('*')
			->from('web_slider')
			->where('status', 1)
			->order_by('id', 'desc')
			->get()
			->result();
	}

	public function subscribe($data = [])
	{	 
		return $this->db->insert('web_subscriber',$data);
	}

	public function socialLink()
	{
		return $this->db->select('*')
			->from('web_social_link')
			->where('status', 1)
			->order_by('id', 'asc')
			->get()
			->result();
	}
	public function cat_info($slug=NULL){
		return $this->db->select("*")
			->from('web_category')
			->where('slug', $slug)
			->where('status', 1)
			->get()
			->row();
	}

	public function blogCatListBySlug($slug=NULL)
	{	 
		$cat_id = $this->db->select('cat_id')->from('web_category')->where('slug', $slug)->get()->row();

		return $this->db->select('*')
			->from('web_category')
			->where('status', 1)
			->order_by('cat_id', 'desc')
			->where('parent_id', $cat_id->cat_id)
			->get()
			->result();
	}

	public function catidBySlug($slug=NULL){
		return $this->db->select("cat_id")
			->from('web_category')
			->where('slug', $slug)
			->where('status', 1)
			->get()
			->row();
	}

	public function advertisement($id=NULL){
		return $this->db->select("*")
			->from('advertisement')
			->where('page', $id)
			->where('status', 1)
			->order_by('serial_position', 'asc')
			->get()
			->result();
	}

	public function article($id=NULL, $limit=NULL){
		return $this->db->select("*")
			->from('web_article')
			->where('cat_id', $id)
			->order_by('position_serial', 'asc')
			->limit($limit)
			->get()
			->result();
	}
public function tradeNotice($id=NULL, $limit=NULL){
		return $this->db->select("*")
			->from('web_article')
			->where('cat_id', $id)
			->order_by('article_id', 'desc')
			->limit($limit)
			->get()
			->result();
	}

	public function categoryList()
	{	 
		return $this->db->select('*')
			->from('web_category')
			->where('status', 1)
			->where('parent_id',0)
			->where('menu !=',0)
			->order_by('position_serial', 'asc')
			->get()
			->result();
	}

	public function childcategoryList()
	{	 
		return $this->db->select('*')
			->from('web_category')
			->where('parent_id',5)
			->where('status', 1)
			->order_by('position_serial', 'asc')
			->get()
			->result();
	}

	public function webLanguage(){
		return $this->db->select('*')
			->from('web_language')
			->get()
			->result();
	}

	public function read($limit, $offset)
	{
		return $this->db->select("*")
			->from('dbt_biding')
			->where('bid_type', 'buy')
			->order_by('id', 'asc')
			->limit($limit, $offset)
			->get()
			->result();

	}

	public function single($bid_id = null)
	{
		return $this->db->select('*')
			->from('dbt_biding')
			->where('id', $bid_id)
			->get()
			->row();

	}

	public function all()
	{
		return $this->db->select('*')
			->from('dbt_biding')
			->get()
			->result();

	}

	public function pending_trade()
	{
		return $this->db->select('*')
			->from('dbt_biding')
			->where('status', 2)
			->get()
			->result();

	}

	public function delete($bid_id = null)
	{
		return $this->db->where('bid_id', $bid_id)
			->delete("dbt_biding");
	}

	public function checkDuplictemail($data = [])
	{
		return $this->db->select("dbt_user.email")
			->from('dbt_user')
			->where('email', $data['email'])
			->get();
	}

	public function checkDuplictuser($data = [])
	{	 
		return $this->db->select("dbt_user.username")
			->from('dbt_user')
			->where('username', $data['username'])
			->get();
	}

	public function coin_release_time($nowtime)
	{
		$rdata = $this->db->select('*')->from('dbt_release_setup')->where("status",1)->get()->result();
		foreach ($rdata as $key => $value) {
			$releasetime        = date("Y-m-d H:i:s",strtotime("$value->start_date +$value->day day"));
			if($releasetime<=$nowtime){
				$this->db->where('id',$value->id)->set('status',0)->update('dbt_release_setup');
			}
		}
		return $this->db->select("*")
			->from("dbt_release_setup")
			->where("start_date<='".$nowtime."'")
			->where("status",1)
			->order_by("id", "asc")
			->limit(1)
			->get();
	}

	public function release_coin_info()
	{
		return $this->db->select('dbt_sto_setup.*,dbt_currency.rate')
				->from('dbt_sto_setup')
				->join('dbt_currency','dbt_sto_setup.pair_with = dbt_currency.symbol')
				->get()
				->row();
	}

// All Get Article Data
	public function getArticleSingelWebData($data = array(),$langid = "")
	{
		return $this->db->select('web_article.*,web_language_data.*')
				->from('web_article')
				->join('web_language_data','web_language_data.data_id=web_article.article_id','left')
				->where('web_article.data_key',$data['data_key'])
				->where('web_article.cat_id',$data['cat_id'])
				->where('web_language_data.table_key',$data['table_key'])
				->where('web_language_data.lang_id',$langid)
				->get()
				->row();
	}
// All Get Head Line Data
	public function articleHeadLine($langid = "",$level = "")
	{
		return $this->db->select('web_headline_text.*,web_language_data.*')
				->from('web_headline_text')
				->join('web_language_data','web_language_data.data_id=web_headline_text.id','left')
				->where('web_language_data.table_key','headline_text')
				->where('web_language_data.lang_id',$langid)
				->where('position_key',$level)
				->get()
				->result();
	}

	public function getArticleMultipleWebData($data = array(),$langid = "")
	{
		return $this->db->select('web_article.*,web_language_data.*')
				->from('web_article')
				->join('web_language_data','web_language_data.data_id=web_article.article_id','left')
				->where('web_article.data_key',$data['data_key'])
				->where('web_article.cat_id',$data['cat_id'])
				->where('web_language_data.table_key',$data['table_key'])
				->where('web_language_data.lang_id',$langid)
				->order_by('web_article.position_serial', 'ASC')
				->get()
				->result();
	}

	public function getWebArticleData($data_key = "",$cat_id = "")
	{
		return $this->db->select('*')
				->from('web_article')
				->where('data_key',$data_key)
				->where('cat_id',$cat_id)
				->order_by('position_serial','asc')
				->get()
				->result();
	}

	public function getPackageInformation($type="")
	{
		return $this->db->select('*')
				->from('package')
				->where('pack_type',$type)
				->get()
				->result();
	}

	public function getsingelblogNews($data = array(),$langid = "")
	{
		return $this->db->select('web_article.*,web_language_data.*,web_category.slug')
		->from('web_article')
		->join('web_language_data','web_article.article_id = web_language_data.data_id')
		->join('web_category','web_article.cat_id = web_category.cat_id','left')
		->where('web_language_data.table_key',$data['data_key'])
		->where('web_language_data.lang_id',$langid)
		->where('web_article.data_key',$data['data_key'])
		->order_by('web_article.article_id', 'desc')
		->limit(3)
		->get()
		->result();
	}

	public function getAllblogNews($data = array(),$langid = "")
	{
		return $this->db->select('web_article.*,web_language_data.*,web_category.slug')
		->from('web_article')
		->join('web_language_data','web_article.article_id = web_language_data.data_id')
		->join('web_category','web_article.cat_id = web_category.cat_id','left')
		->where('web_language_data.table_key',$data['data_key'])
		->where('web_language_data.lang_id',$langid)
		->where('web_article.data_key',$data['data_key'])
		->order_by('web_article.article_id', 'desc')
		->get()
		->result();
	}

	public function getNewsByCategory($data = array(),$langid = "")
	{
		return $this->db->select('web_article.*,web_language_data.*,web_category.slug')
				->from('web_article')
				->join('web_language_data','web_language_data.data_id=web_article.article_id','left')
				->join('web_category','web_article.cat_id = web_category.cat_id','left')
				->where('web_article.data_key',$data['data_key'])
				->where('web_article.cat_id',$data['cat_id'])
				->where('web_language_data.table_key',$data['table_key'])
				->where('web_language_data.lang_id',$langid)
				->get()
				->result();
	}

	public function blogDetails($data = array(),$langid = "")
	{
		return $this->db->select('web_article.*,web_language_data.*,web_category.slug')
			->from('web_article')
			->join('web_language_data','web_language_data.data_id=web_article.article_id','left')
			->join('web_category','web_article.cat_id = web_category.cat_id','left')
			->where('custom_data',$data['slug'])
			->where('web_article.data_key',$data['data_key'])
			->where('web_language_data.table_key',$data['data_key'])
			->where('web_language_data.lang_id',$langid)
			->get()
			->row();
	}


}