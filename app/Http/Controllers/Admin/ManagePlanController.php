<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\Configure;
use App\Models\Gateway;
use App\Models\ManagePlan;
use App\Models\ManageTime;
use App\Models\Project;
use App\Models\Ranking;
use App\Models\Referral;
use App\Models\NearAccountKey;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\RequiredIf;
use Stevebauman\Purify\Facades\Purify;
use PayMoney\Api\Payer;
use PayMoney\Api\Amount;
use PayMoney\Api\Transaction;
use PayMoney\Api\RedirectUrls;
use PayMoney\Api\Payment;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\UserWallet;

class ManagePlanController extends Controller
{
    use Upload, Notify;

    public function rankingsUser(Ranking $ranking)
    {
        $data['allRankings'] = Ranking::orderBy('sort_by', 'asc')->get();
        $data['page_title'] = 'Rank List';
        return view('admin.rank.index', $data);
    }

    public function rankCreate()
    {
        return view('admin.rank.create');
    }

    public function rankStore(Request $request)
    {

        $rules = [
            'rank_name' => 'required',
            'rank_lavel' => 'required',
            'rank_icon' => 'required'
        ];

        $this->validate($request, $rules);

        $rank = new Ranking();
        $rank->rank_name = $request->rank_name;
        $rank->rank_lavel = $request->rank_lavel;
        $rank->min_invest = isset($request->min_invest) ? $request->min_invest : 0;
        $rank->min_deposit = isset($request->min_deposit) ? $request->min_deposit : 0;
        $rank->min_earning = isset($request->min_earning) ? $request->min_earning : 0;
        $rank->description = $request->description;
        $rank->status = isset($request->status) ? 1 : 0;

        if ($request->hasFile('rank_icon')) {
            try {
                $rank->rank_icon = $this->uploadImage($request->rank_icon, config('location.rank.path'), config('location.rank.size'));
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $rank->save();
        return redirect()->route('admin.rankingsUser')->with('success', 'Ranking create successfully');
    }


    public function rankEdit($id)
    {
        $data['singleRanking'] = Ranking::findOrFail($id);
        return view('admin.rank.edit', $data);
    }

    public function rankUpdate(Request $request, $id){
        $rules = [
            'rank_name' => 'required',
            'rank_lavel' => 'required',
        ];

        $this->validate($request, $rules);

        $rank = Ranking::findOrFail($id);
        $rank->rank_name = $request->rank_name;
        $rank->rank_lavel = $request->rank_lavel;
        $rank->min_invest = isset($request->min_invest) ? $request->min_invest : 0;
        $rank->min_deposit = isset($request->min_deposit) ? $request->min_deposit : 0;
        $rank->min_earning = isset($request->min_earning) ? $request->min_earning : 0;
        $rank->description = $request->description;
        $rank->status = isset($request->status) ? 1 : 0;

        if ($request->hasFile('rank_icon')) {
            try {
                $rank->rank_icon = $this->uploadImage($request->rank_icon, config('location.rank.path'), config('location.rank.size'));
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $rank->save();
        return redirect()->route('admin.rankingsUser')->with('success', 'Ranking Update successfully');

    }

    public function rankDelete($id){
        Ranking::findOrFail($id)->delete();
        return back()->with('success', 'Delete Successfull');
    }

    public function sortBadges(Request $request){
        $data = $request->all();
        foreach ($data['sort'] as $key => $value) {

            Ranking::where('id', $value)->update([
                'sort_by' => $key + 1
            ]);
        }

    }


    public function referralCommissionAction(Request $request)
    {
        $configure = Configure::firstOrNew();
        $reqData = Purify::clean($request->except('_token', '_method'));

        $configure->fill($reqData)->save();

        config(['basic.deposit_commission' => (int)$reqData['deposit_commission']]);
        config(['basic.investment_commission' => (int)$reqData['investment_commission']]);
        config(['basic.profit_commission' => (int)$reqData['profit_commission']]);
        $fp = fopen(base_path() . '/config/basic.php', 'w');
        fwrite($fp, '<?php return ' . var_export(config('basic'), true) . ';');
        fclose($fp);

        return back()->with('success', 'Update Successfully.');
    }

    public function referralCommission()
    {
        $data['control'] = Configure::firstOrNew();
        $data['referrals'] = Referral::get();
        return view('admin.plan.referral-commission', $data);
    }

    public function referralCommissionStore(Request $request)
    {
        $request->validate([
            'level*' => 'required|integer|min:1',
            'percent*' => 'required|numeric',
            'commission_type' => 'required',
        ]);

        Referral::where('commission_type', $request->commission_type)->delete();

        for ($i = 0; $i < count($request->level); $i++) {
            $referral = new Referral();
            $referral->commission_type = $request->commission_type;
            $referral->level = $request->level[$i];
            $referral->percent = $request->percent[$i];
            $referral->save();
        }

        return back()->with('success', 'Level Bonus Has been Updated.');
    }

    public function scheduleManage()
    {
        $manageTimes = ManageTime::all();
        return view('admin.plan.schedule', compact('manageTimes'));
    }

    public function storeSchedule(Request $request)
    {

        $reqData = Purify::clean($request->except('_token', '_method'));
        $request->validate([
            'name' => 'required|string',
            'time' => 'required|integer',
        ], [
            'name.required' => 'Name is required',
            'time.required' => 'Time is required'
        ]);
        $data = ManageTime::firstOrNew(['time' => $reqData['time']]);
        $data->name = $reqData['name'];
        $data->save();
        return back()->with('success', 'Added Successfully.');
    }

    public function updateSchedule(Request $request, $id)
    {
        $reqData = Purify::clean($request->except('_token', '_method'));
        $request->validate([
            'name' => 'required|string',
            'time' => 'required|integer',
        ], [
            'name.required' => 'Name is required',
            'time.required' => 'Time is required'
        ]);

        $data = ManageTime::findOrFail($id);
        $data->time = $reqData['time'];
        $data->name = $reqData['name'];
        $data->save();
        return back()->with('success', 'Update Successfully.');
    }

    public function deletePlan(Request $request)
    {
        try {
            
            
            ManagePlan::where('id', $request->id)->delete();
            
            $data['message'] = trans('Plan deleted');
            $data['code'] = 200;
            return response()->json($data, 200);
        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['code'] = 400;
            return response()->json($data, 200);
        }
    }

    public function planList()
    {
        $managePlans = ManagePlan::latest()->get();
        return view('admin.plan.list', compact('managePlans'));
    }

    public function planCreate()
    {
        $times = ManageTime::latest()->get();
        // get the project have token
        $projectHaveToken = ManagePlan::pluck('project_id')->all();
        
        $projects = Project::whereNotIn('id', $projectHaveToken)->get();

        $sso_url = env('XWALLET_URL') . 'submit-create-currency';
        $master_account = config('constants.options.master_account_id');
        
        return view('admin.plan.create', compact('times', 'projects', 'sso_url', 'master_account'));
    }

    public function planStore(Request $request)
    {
        $reqData = Purify::clean($request->except('_token', '_method'));
        $request->validate([
            'name' => 'required',
            'min_buy_amount' => 'numeric|min:1',
            'fixed_amount' => 'numeric|min:0',
            'price' => 'numeric|min:0',
            'token_symbol' => 'required|unique:manage_plans,token_symbol,',
            'token_decimals' => 'required',
            'icon' => 'required',
        ]);

        $minimum_amount = $reqData['minimum_amount'];
        $maximum_amount = $reqData['maximum_amount'];
        $fixed_amount = isset($reqData['plan_price_type']) ? $reqData['fixed_amount'] : 0;
        $set_withdraw_date = isset($reqData['set_withdraw_date']) ? $reqData['set_withdraw_date'] : 0;
        $token_price = isset($reqData['token_price']) ? $reqData['token_price'] : 1;
        $min_buy_amount = isset($reqData['min_buy_amount']) ? $reqData['min_buy_amount'] : 1;
        $profit_type = (int)$reqData['profit_type'];

        $repeatable = isset($reqData['is_lifetime']) ? $reqData['repeatable'] : 0;
        $featured = isset($reqData['featured']) && $reqData['featured'] == 'on' ? 1 : 0;

        
        
        
        $insertToken = ManagePlan::create([
            'name' => $reqData['name'],
            'badge' => $reqData['badge'] ?? '',
            'project_id' => $reqData['project_id'] ?? 0,
            'minimum_amount' => $minimum_amount,
            'maximum_amount' => $maximum_amount,
            'fixed_amount' => $fixed_amount,
            'token_price' => $token_price,
            'set_withdraw_date' => $set_withdraw_date,
            'min_buy_amount' => $min_buy_amount ?? '',
            'profit' => $reqData['profit'],
            'profit_type' => $profit_type,
            'schedule' => $reqData['schedule'],
            'status' => isset($reqData['status']) ? 1 : 0,
            'is_capital_back' => isset($reqData['is_capital_back']) ? 1 : 0,
            'is_lifetime' => isset($reqData['is_lifetime']) ? 1 : 0,
            'repeatable' => $repeatable,
            'featured' => $featured,
            'token_symbol' => strtoupper($reqData['token_symbol']),
            'token_decimals' => $reqData['token_decimals'],
            'token_icon' => ($reqData['token_icon']),
        ]);
        

        // update near api token
        NearAccountKey::where("name", strtolower($reqData['token_symbol']) .  '.' . $reqData['master_account'])->update([
            'token_id' => $insertToken->id
        ]);

        if(isset($reqData['status'])) {
            $status = 'Active';
        }
        else {
            $status = 'Inactive';
        }

        //$sso_url = ($reqData['sso_url']);
        $sso_url = config('constants.options.xeedwallet_currency_api');
        $response = Http::withHeaders([
            'Accept' =>  'application/json',
            'Content-Type' => 'application/json'
        ])->post($sso_url, [
            'name' => $reqData['name'],
            'code' => $reqData['name'],
            'symbol' => strtoupper($reqData['token_symbol']),
            'type' => 'crypto',
            'rate' => ($token_price) ? $token_price : 1,
            'logo' => '',
            'status' => $status,
            'token_icon' => ($reqData['token_icon']),
            'total_supply' => $fixed_amount
        ]);
        
       

        return back()->with('success', 'Plan has been added');
    }
    
    // ajax near token api
    // Create subaccount deploy contract and create token
    public function nearTokenAPI(Request $request) {
    
        // Check token exist
        $reqData = Purify::clean($request->except('_token', '_method'));
       // dd($reqData['token_icon']);exit();
        $findToken = ManagePlan::where('token_symbol', strtoupper($reqData['token_symbol']))->first();
        if($findToken) {
            $data['message'] = trans('Token symbol exist');
            $data['code'] = 400;
            return response()->json($data, 200);
        }
        
        $sso_url = config('constants.options.create_sub_account_url');
        
       // dd(strtolower($reqData['name']));
       
        $sub_account = strtolower($reqData['name']);
        
        $response = Http::withHeaders([
            'Accept' =>  'application/json',
            'Content-Type' => 'application/json'
        ])->post($sso_url, [
           // 'name' => strtolower($reqData['name']),
            'name' => $sub_account,
        ]);
        
        if($response->getStatusCode() == 400) {
            return response()->json(['message' => 'Create sub account fail', 'code' => '400'], 200);
        }
        else {
            $data = $response->json();
            
            // save key to DB
            
            //$account_name = strtolower($reqData['name']) . '.' . config('constants.options.master_account_id');
            $account_name = $sub_account . '.' . config('constants.options.master_account_id');
            
            try {
            
                $findAccount = NearAccountKey::where("name", $account_name)->first();
                
                if($findAccount) {
                    
                }
                else {
                    $account = NearAccountKey::create([
                        'name' => $account_name,
                        'private_key' => $data['private_key'],
                        'public_key' => $data['public_key'],
                        'token_id' => 0 
                    ]); 

                    
            
                    // deploy contract
                    $deploy_url = config('constants.options.deploy_url');
                    $response = Http::withHeaders([
                        'Accept' =>  'application/json',
                        'Content-Type' => 'application/json'
                    ])->post($deploy_url, [
                        'account_id' => $account_name,
                        'private_key' => $data['private_key'],
                        'contract' => 'fungible_token.wasm',
                        'name_token' => ($reqData['token_name']),
                        'total_supply' => $reqData['total_supply'],
                        'symbol' => strtoupper($reqData['token_symbol']),
                        'decimals' => ($reqData['token_decimals']) ?? 0,
                        'icon' => $reqData['token_icon']
                    ]);

                    return response()->json($response, 200);
                }
                
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Insert near account fail', 'code' => '400'], 200);
            }

        }
        
    }


    public function mintTokenView($id)
    {
        
        $data = ManagePlan::findOrFail($id);
        $status = 1;
        $total_token = 0;
        $token_symbol = '';
        if($data) {
            $findAccount = NearAccountKey::where("token_id", $id)->first();
            $token_symbol = $data->token_symbol;
            if($findAccount) {
                $status = 1;
                $ft_balance_of = config('constants.options.balance_url');
                
                $response = Http::withHeaders([
                    'Accept' =>  'application/json',
                    'Content-Type' => 'application/json'
                ])->post($ft_balance_of, [
                    'account_id' => $findAccount->name,
                    'contract' => $findAccount->name,
                ]);

                $data = $response->json();
                $total_token = $data['total'];
            }
                
            else 
                $status = 0;
 
        }
        else 
            $status =0;

        
        return view('admin.plan.mint_token', compact('id', 'findAccount', 'status', 'total_token', 'token_symbol'));
        
    }
    
    
    
    // send token near api
    public function mintToken(Request $request) {
    
       

        // Check token exist
        $reqData = Purify::clean($request->except('_token', '_method'));

        $account_name = strtolower($reqData['token_symbol']) . '.' . config('constants.options.master_account_id');

        $findAccount = NearAccountKey::where("name", $account_name)->first();

        if($findAccount) {
            $mint = config('constants.options.mint_url');
            $response = Http::withHeaders([
                'Accept' =>  'application/json',
                'Content-Type' => 'application/json'
            ])->post($mint, [
                'account_id' => $reqData['account_id'],
                'private_key' => $reqData['private_key'],
                'contract' => ($reqData['contract']),
                'amount' => ($reqData['amount']),
                'recipient_id' => $reqData['recipient_id'],
            ]);
            
            // update total supply
            $findPlan = ManagePlan::findOrFail($reqData['plan_id']);
            if($findPlan) {
                $findPlan->fixed_amount = (int)$findPlan->fixed_amount + (int)($reqData['amount']);
                $findPlan->save();
            }
                
            
    
            return response()->json($response, 200);  
        }
        else { 
            return response()->json(['message' => 'Account not found', 'code' => '400'], 200);
        } 
        
    }

    public function viewWithdraw() {
        $userTokens = WithdrawRequest::with('token')
            ->selectRaw('*')
            ->latest('id')
            ->paginate(config('basic.paginate'));
            
        return view('admin.withdraw.index', compact('userTokens'));
    }
    
    public function approveWithdraw(Request $request) {
        if($request->type == 'single') {
            //dd($request->id);

            // send token
            $findAdd = WithdrawRequest::where('id', $request->id)->first();
            if($findAdd) {
                
                // find user wallet
                $find_wallet = UserWallet::where('user_id', $findAdd->user_id)->first();
                $findAccount = NearAccountKey::where("token_id", $findAdd->token->id)->first();
                
                //dd($findAccount);
                
                if($find_wallet) {
                    // send token
                    $arr = array(
                        'owner_id' => $find_wallet['wallet_address'],
                        'account_id' => $findAdd->to_wallet,
                        'contract' => $findAccount['name'],
                        'private_key' => $findAccount['private_key'],
                        'old_owner_id' => $findAccount['name'],
                        'receiver_id' => $findAdd->to_wallet,
                        'memo' => 'Token send from ' .  $find_wallet['wallet_address'] . '(Ribano)',
                        'amount' => (string) $findAdd->number_token,
                    );
                    
                    
                    $send_token = depositAndSendToken($arr);
                    
                    
                    if($send_token) {
                        // update hash
                        WithdrawRequest::where('id', $request->id)->update([
                            'hash' => $send_token,
                            'status' => 'approved'
                        ]);
                        return response()->json(['error' => 0, 'success' => 1, 'message' => 'Token sent on blockchain']);
                    }
                    else {
                        return response()->json(['error' => 1, 'success' => 0, 'message' => 'Token not sent on blockchain']);
                    }
                }
                else {
                    return response()->json(['error' => 1, 'success' => 0, 'message' => 'Sender account not found']);
                }
                
            }
            else {
                return response()->json(['error' => 1, 'success' => 0, 'message' => 'Request not found']);
            }
            
            
            
           
            
        }
        else {
            // active multi
            if ($request->strIds == null) {
                return response()->json(['error' => 1, 'success' => 0]);
            } else {
                
            
                foreach ($request->strIds as $key => $value) {
                    
                    
                    $findAdd = WithdrawRequest::where('id', $value)->first();
                    if($findAdd) {
                        
                        // find user wallet
                        $find_wallet = UserWallet::where('user_id', $findAdd->user_id)->first();
                        $findAccount = NearAccountKey::where("token_id", $findAdd->token->id)->first();
                        
                        if($find_wallet) {
                            // send token
                            $arr = array(
                                'owner_id' => $find_wallet['wallet_address'],
                                'account_id' => $findAdd->to_wallet,
                                'contract' => $findAccount['name'],
                                'private_key' => $findAccount['private_key'],
                                'old_owner_id' => $findAccount['name'],
                                'receiver_id' => $findAdd->to_wallet,
                                'memo' => 'Token send from ' .  $findAccount['name'] . '(Ribano)',
                                'amount' => (string) $findAdd->number_token,
                            );
                            
                            
                            $send_token = depositAndSendToken($arr);
                           
                            
                            if($send_token) {
                                // update hash
                                WithdrawRequest::where('id', $request->id)->update([
                                    'hash' => $send_token,
                                    'status' => 'approved'
                                ]);
                                return response()->json(['error' => 0, 'success' => 1, 'message' => 'Token sent on blockchain']);
                            }
                            else {
                                return response()->json(['error' => 1, 'success' => 0, 'message' => 'Token not sent on blockchain']);
                            }
                        }
                        else {
                            return response()->json(['error' => 1, 'success' => 0, 'message' => 'Sender account not found']);
                        }
                        
                    }
                    else {
                        return response()->json(['error' => 1, 'success' => 0, 'message' => 'Request not found']);
                    }
                }
                
                session()->flash('success', 'User Status Has Been Active');
                return response()->json(['success' => 1]);
            }
        }
        
    }
    
    public function sendTokenView($id)
    {
        
        $data = ManagePlan::findOrFail($id);
        $status = 1;
        $total_token = 0;
        $token_symbol = '';
        if($data) {
            $findAccount = NearAccountKey::where("token_id", $id)->first();
            $token_symbol = $data->token_symbol;
            if($findAccount) {
                $status = 1;
                $ft_balance_of = config('constants.options.balance_url');
                
                $response = Http::withHeaders([
                    'Accept' =>  'application/json',
                    'Content-Type' => 'application/json'
                ])->post($ft_balance_of, [
                    'account_id' => $findAccount->name,
                    'contract' => $findAccount->name,
                ]);

                $data = $response->json();
                $total_token = $data['total'];
            }
                
            else 
                $status = 0;
 
        }
        else 
            $status =0;

        
        return view('admin.plan.send_token', compact('findAccount', 'status', 'total_token', 'token_symbol'));
        
    }
    
    public function sendTokenAjax(Request $request){ 
        try {
            $reqData = Purify::clean($request->except('_token', '_method'));
            
            //replace by master account
            
            $account_id = config('constants.options.master_account_id');
            $private_key = config('constants.options.private_key');
            
            $storage_deposit = config('constants.options.storage_deposit_url');
                    
            $response = Http::withHeaders([
                'Accept' =>  'application/json',
                'Content-Type' => 'application/json'
            ])->post($storage_deposit, [
                'owner_id' => $account_id,
                'contract' => $reqData['contract'],
                'account_id' => $reqData['receiver_id'],
                'private_key' => $private_key,
                // 'account_id' => $reqData['receiver_id'],
                // 'private_key' => $reqData['private_key'],
            ]);
            

            $ft_transfer = config('constants.options.ft_transfer_url');
                    
            $response = Http::withHeaders([
                'Accept' =>  'application/json',
                'Content-Type' => 'application/json'
            ])->post($ft_transfer, [
                'old_owner_id' => $reqData['old_owner_id'],
                'receiver_id' => $reqData['receiver_id'],
                'memo' => $reqData['memo'],
                'contract' => $reqData['contract'],
                // 'private_key' => $reqData['private_key'],
                'master_id' => $account_id,
                'private_key' => $private_key,
                'amount' => $reqData['amount'],
            ]);
            return response()->json(['response' => $response, 'code' => 200], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Account not found', 'code' => 400], 200);
        }
        
    }
    

    public function planEdit($id)
    {
        
        $data = ManagePlan::findOrFail($id);
        $times = ManageTime::latest()->get();
        // get the project have token
        $projectHaveToken = ManagePlan::pluck('project_id')->all();

        if (($key = array_search($data->project_id, $projectHaveToken)) !== false) {
            unset($projectHaveToken[$key]);
        }
        $projects = Project::whereNotIn('id', $projectHaveToken)->get();
        return view('admin.plan.edit', compact('data', 'times', 'projects'));
    }
    
    

    public function planUpdate(Request $request, $id)
    {
        $data = ManagePlan::findOrFail($id);

        // $request->validate([
        //     'name' => 'required',
        //     'min_buy_amount' => 'numeric|min:1',
        //     'fixed_amount' => 'numeric|min:0',
        //     'price' => 'numeric|min:0',
        //     // 'schedule' => 'numeric|min:0',
        //     // 'profit' => 'numeric|min:0',
        //     // 'repeatable' => 'sometimes|required',
        //     'token_symbol' => 'required|unique:manage_plans,token_symbol,'.$id,
        //     'token_decimals' => 'required',
        // ], [
        //    // 'schedule|numeric' => 'Accrual field is required'
        // ]);
        $reqData = Purify::clean($request->except('_token', '_method'));

        //dd($reqData['project_id']);

        $minimum_amount = $reqData['minimum_amount'];
        $maximum_amount = $reqData['maximum_amount'];
        // $fixed_amount = isset($reqData['plan_price_type']) ? $reqData['fixed_amount'] : 0;
        $min_buy_amount = isset($reqData['min_buy_amount']) ? $reqData['min_buy_amount'] : 1;
        $set_withdraw_date = isset($reqData['set_withdraw_date']) ? $reqData['set_withdraw_date'] : 0;
        $token_price = isset($reqData['token_price']) ? $reqData['token_price'] : 1;
        // $profit_type = (int)$reqData['profit_type'];
        // $repeatable = isset($reqData['is_lifetime']) ? $reqData['repeatable'] : 0;
        // $featured = isset($reqData['featured']) && $reqData['featured'] == 'on' ? 1 : 0;

        // $data->name = $reqData['name'];
        $data->project_id = $reqData['project_id'];
        $data->badge = $reqData['badge'] ?? '';
        // $data->minimum_amount = $minimum_amount;
        // $data->maximum_amount = $maximum_amount;
        // $data->fixed_amount = $fixed_amount;
        $data->token_price = $token_price;
        $data->set_withdraw_date = $set_withdraw_date;
        $data->min_buy_amount = $min_buy_amount;
        // $data->profit = $reqData['profit'];
        // $data->profit_type = $profit_type;
        // $data->schedule = $reqData['schedule'];
        // $data->status = isset($reqData['status']) ? 1 : 0;
        // $data->is_capital_back = isset($reqData['is_capital_back']) && $reqData['is_capital_back'] == 'on' ? 1 : 0;
        // $data->is_lifetime = isset($reqData['is_lifetime']) && $reqData['is_lifetime'] == 'on' ? 0 : 1;


        // $data->repeatable = $repeatable;
        // $data->featured = $featured;
        
       // $data->token_symbol = $reqData['token_symbol'];
        // $data->token_decimals = $reqData['token_decimals'];
        // $data->token_icon = ($reqData['token_icon']);
        
        $data->save();
        
        
        // insert in xwallet
        try {
            if(isset($reqData['status'])) {
                $status = 'Active';
            }
            else {
                $status = 'Inactive';
            }

        //     $sso_url = config('constants.options.xeedwallet_currency_api');
        //     $response = Http::withHeaders([
        //         'Accept' =>  'application/json',
        //         'Content-Type' => 'application/json'
        //    ])->post($sso_url, [
        //         'name' => $reqData['name'],
        //         'code' => $reqData['name'],
        //         'symbol' => strtoupper($reqData['token_symbol']),
        //         'type' => 'crypto',
        //         'rate' => ($token_price) ? $token_price : 1,
        //         'logo' => '',
        //         'status' => $status,
        //         'token_icon' => ($reqData['token_icon']),
        //         'total_supply' => $fixed_amount
        //     ]);
            
        }
        catch(Exception $e) {
            return response()->json(
            [
                'message' =>  $e->getMessage(),
                'code' => 400,
            
            ]);
        }
        

        return back()->with('success', 'Plan has been Updated');
    }

    
    public function activeMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            ManagePlan::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            
            
            foreach ($request->strIds as $key => $value) {
                $findToken = ManagePlan::where('id', $value)->first();
                
                if($findToken) {
                    // get token
                    $sso_url = env('XWALLET_URL') . 'submit-create-currency';
                        $response = Http::withHeaders([
                            'Accept' =>  'application/json',
                            'Content-Type' => 'application/json'
                       ])->post($sso_url, [
                            'name' => $findToken['name'],
                            'code' => $findToken['name'],
                            'symbol' => $findToken['token_symbol'],
                            'type' => 'crypto',
                            'rate' => 0,
                            'logo' => '',
                            'status' => 'Active',
                            'token_icon' => ($findToken['token_icon']),
                        ]);
                }
                
            }
            
            
            session()->flash('success', 'User Status Has Been Active');
            return response()->json(['success' => 1]);
        }
    }

    public function inActiveMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            ManagePlan::whereIn('id', $request->strIds)->update([
                'status' => 0,
            ]);


            foreach ($request->strIds as $key => $value) {
                $findToken = ManagePlan::where('id', $value)->first();
                
                if($findToken) {
                    // get token
                    $sso_url = env('XWALLET_URL') . 'submit-create-currency';
                        $response = Http::withHeaders([
                            'Accept' =>  'application/json',
                            'Content-Type' => 'application/json'
                       ])->post($sso_url, [
                            'name' => $findToken['name'],
                            'code' => $findToken['name'],
                            'symbol' => $findToken['token_symbol'],
                            'type' => 'crypto',
                            'rate' => 0,
                            'logo' => '',
                            'status' => 'Inactive',
                            'token_icon' => ($findToken['token_icon']),
                        ]);
                }
                
            }

            session()->flash('success', 'User Status Has Been Deactive');
            return response()->json(['success' => 1]);
        }
    }


}
