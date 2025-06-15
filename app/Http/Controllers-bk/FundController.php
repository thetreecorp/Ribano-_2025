<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\PayMoney;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Http\Traits\CommonFunctionTrait;
use App\Http\Traits\Common;
use App\Models\Project;
use App\Models\ShortListProject;
use App\Models\ShortListInvestor;
class FundController extends Controller
{
    use CommonFunctionTrait, Common;
     public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }
    public function dashboard()
    {
        $projects = Project::where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        $total = $projects->total();
        return view('fundraising.my_pitches', compact('projects', 'total'));        
    }
    public function myInvestors()
    {
        $user_id = auth()->user()->id ?? 0 ;
        $min = $this->getPriceOption('min');
        $max = $this->getPriceOption('max');
        $shortlists = ShortListInvestor::where(['user_id' => $user_id, 'type' => 'shortlist'])->pluck('investor_id')->toArray();
        $interesteds = ShortListInvestor::where(['user_id' => $user_id, 'type' => 'interested'])->pluck('investor_id')->toArray();
       // $paymoneys = PayMoney::where(['user_id' => $user_id])->pluck('project_id')->toArray();
        
                
        $shortlists = User::whereIn('id', $shortlists)->paginate(12);
        $interesteds = User::whereIn('id', $interesteds)->paginate(12);
        
        

        $total = $shortlists->total();

        $total_shortlists = $interesteds->total();
        return view('fundraising.my_investors',compact('shortlists', 'interesteds', 'total', 'total_shortlists'));    
    }
    
   
    
   
}
