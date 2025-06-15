<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\Template;
use App\Models\ManagePlan;
use App\Models\User;
use App\Models\PayMoney;
use App\Models\Subscriber;
use App\Http\Traits\Notify;
use Illuminate\Http\Request;
use App\Models\ContentDetails;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use App\Console\Commands\UpdateBadgeCron;
use App\Models\Project;
use App\Http\Traits\Common;
use App\Models\ShortListProject;
use App\Models\ShortListInvestor;
use App\Models\NewsFeedModel;
class CustomFrontendController extends Controller
{
    use Notify, Common;

    public function __construct()
    {
        $this->theme = template();
    }



    
    public function activeAccountLayout($type)
    {  
        if($type == 'phone') {
            return view('active-account.phone');
        }
        else {// email
            return view('active-account.email');
        }
        
    }
    
    
    public function viewInvestor($id)
    {  
        $user = User::where('id', $id)->first();
        if($user) {
            
            return view('fundraising.single_investor', compact('user'));
        }
        else {
            return view($this->theme .'.errors.404');
        }
        
        
    }

    public function newsfeed(Request $request) {
        
        $user_id = auth()->user()->id ?? 0 ;
        $news_feeds = NewsFeedModel::where('status', 1)->paginate(4);

        if ($request->ajax()) {
            $view = view('fundraising.ajax.ajax_newsfeed_content', compact('news_feeds'))->render();
  
            return response()->json(['html' => $view]);
        }
        
        return view('fundraising.news_feed', compact('news_feeds'));
    }
    
    
    public function investorShortList(Request $request)
    { 
        $user_id = auth()->user()->id ?? 0 ;
        
        $investors = ShortListInvestor::where('user_id', $user_id)->pluck('investor_id')->toArray();
              
        $min = $this->getPriceInvestorOption('min') ? $this->getPriceInvestorOption('min') : 1;
        $max = $this->getPriceInvestorOption('max') ? $this->getPriceInvestorOption('max') : 10000000;
        $users = User::whereIn('id', $investors )->paginate(12);
        
        return view('fundraising.investor_search', compact('min', 'max', 'users', 'total'));
        
        // dd($investors);
        
        
    }
    
    public function projectShortList(Request $request)
    { 
        $user_id = auth()->user()->id ?? 0 ;
        $min = $this->getPriceOption('min');
        $max = $this->getPriceOption('max');
        $shortlist = ShortListProject::where('user_id', $user_id)->pluck('project_id')->toArray();
                
        $projects = Project::whereIn('id', $shortlist )->paginate(12);
        $total = $projects->total();

        //dd($projects);
        return view('fundraising.investor_search', compact('projects', 'total', 'min', 'max'));
        
        
    }
    
    // myList function
    public function myList(Request $request)
    { 
        $user_id = auth()->user()->id ?? 0 ;
        $min = $this->getPriceOption('min');
        $max = $this->getPriceOption('max');
        $shortlists = ShortListProject::where(['user_id' => $user_id, 'type' => 'shortlist'])->pluck('project_id')->toArray();
        $interesteds = ShortListProject::where(['user_id' => $user_id, 'type' => 'interested'])->pluck('project_id')->toArray();
        $paymoneys = PayMoney::where(['user_id' => $user_id])->pluck('project_id')->toArray();
        
        // $count_shortlist = Project::whereIn('id', $shortlists)->get()->count();
        // $count_interested = Project::whereIn('id', $interesteds)->get()->count();
        // $count_paymoney = Project::whereIn('id', $paymoneys)->get()->count();
        
                
        $shortlists = Project::whereIn('id', $shortlists)->paginate(12);
        $interesteds = Project::whereIn('id', $interesteds)->paginate(12);
        $paymoneys = Project::whereIn('id', $paymoneys)->paginate(12);
        
        

        $total = $interesteds->total();

        $total_shortlists = $shortlists->total();
        $total_paymoneys = $paymoneys->total();


        //dd($projects);
        return view('fundraising.my_list', compact('shortlists', 'interesteds', 'paymoneys', 'total', 'total_shortlists', 'total_paymoneys'));
        
        
    }
    
    // load mylist pagenation
    public function loadMylistAjax(Request $request) {
        $user_id = auth()->user()->id ?? 0 ;
       
        
        $paymoneys = PayMoney::where(['user_id' => $user_id])->pluck('project_id')->toArray();
        if($request->type == 'invested') {
            $condictional = PayMoney::where(['user_id' => $user_id])->pluck('project_id')->toArray();
        }
        else if ($request->type == 'interested')  {
            $condictional = ShortListProject::where(['user_id' => $user_id, 'type' => 'interested'])->pluck('project_id')->toArray();
        }
        else {
            $condictional = ShortListProject::where(['user_id' => $user_id, 'type' => 'shortlist'])->pluck('project_id')->toArray();
        }

        $paged = $request->page ?? 1;
        $projects = Project::query();
        $projects = $projects->whereIn('id', $condictional);

        $data = $projects->paginate(12, ['*'], 'page', $paged);

        $total = $data->total() ?? 0;
        $perPage = $data->perPage();
        $totalResult = count($data->items());
        
        return response()->json(['view' => view('project.ajax.ajax_search_content', compact('data'))->render(), 'total' => $total, 'totalResult' => $totalResult]);
        
        
    }
    
    public function investorSearch(Request $request)
    {
        $user_id = auth()->user()->id ?? 0 ;
        $min = $this->getPriceInvestorOption('min') ? $this->getPriceInvestorOption('min') : 1;
        $max = $this->getPriceInvestorOption('max') ? $this->getPriceInvestorOption('max') : 10000000;
        $users = User::paginate(12);
        if($user_id)
            $users = User::where('id', '!=', $user_id )->paginate(12);
            
        $total = $users->total();

        if($request->ajax()){
            $data = $this->searchUserFunc($request->all());
            $total = $data->total() ?? 0;
            $perPage = $data->perPage();
            $totalResult = count($data->items());
            $sortBy = $request->sort_by ?? '';
            $fromText = ($data->currentPage() -1 ) * $data->perpage() + 1;
            $toText = (($data->currentpage()-1) * $data->perpage()) + $totalResult;

            return response()->json(['view' => view('fundraising.ajax.ajax_search_content', compact('data'))->render(), 'total' => $total, 'fromText' => $fromText, 'totalResult' => $totalResult, 'toText' => $toText, 'sortBy' => $sortBy]);
        }
        return view('fundraising.investor_search', compact('min', 'max', 'users', 'total'));        
    }
    
  





}
