<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\Content;
use App\Models\ContentDetails;
use App\Models\ContentMedia;
use App\Models\Language;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Project;
use App\Models\IndustryCategory;
use App\Models\ProjectStage;
use App\Models\IdealInvestorRole;
use App\Models\UserXeedwallet;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Str;
use App\Models\NewsFeedModel;
use Illuminate\Support\Facades\Http;
class BackendController extends Controller
{
    use Upload; 
    
    
    
    function categoryIndex() {
        $categories = Category::orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view('admin.faq.category', compact('categories'));
    }
    
    function manageProject($slug) {
        
        if(in_array($slug, array(Str::slug("Industry Category"), Str::slug("Project Stage"), Str::slug("Ideal Investor Role")))) {
            if($slug == Str::slug("Industry Category"))
                $categories = IndustryCategory::orderBy('id', 'DESC')->paginate(config('basic.paginate'));
            else if($slug == Str::slug("Project Stage"))
                $categories = ProjectStage::orderBy('id', 'DESC')->paginate(config('basic.paginate'));
            else
                $categories = IdealInvestorRole::orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        }
        else {
            abort(404);
        }

        return view('admin.manage-project.index', compact('categories', 'slug'));
    }
    
    function faqContent() {
        
        $faqs = Faq::orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.faq.lists', compact('faqs', 'categories'));
    }
    
    function manageNewsfeed() {
        $news_feeds = NewsFeedModel::orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view('admin.news-feed', compact('news_feeds'));
    }
    
    
    // xeedwallet
    
    function xeedwalletList() {
        $manageWallet = UserXeedwallet::get();
        return view('admin.xeedwallet.list', compact('manageWallet'));
    }
    
    function createXeedwallet() {
        $randomEmail = $this->generateEmailAddress();
        $randomPassword = Str::random(12);
        $firstName = "User_" . Str::random(4);
        $lastName = Str::random(4);
        return view('admin.xeedwallet.create', compact('randomEmail', 'randomPassword', 'firstName', 'lastName'));
    }
    
    function submitXeedwalletUser(Request $request) {

        try { 
            $reqData = Purify::clean($request->except('_token', '_method'));
            $sso_url = config('constants.options.xeedwallet_user_api');
           // dd($sso_url);
            
            $response = Http::withHeaders([
                'Accept' =>  'application/json',
                'Content-Type' => 'application/json'
            ])->post($sso_url, [
                'email' => $reqData['email'],
                'password' => $reqData['password'],
                'type' => 'merchant',
                'first_name' => $reqData['first_name'],
                'last_name' => $reqData['last_name'],
                'currency_id' => 1,
                'business_name' => 'Ribano',
                'site_url' => 'https://ribano.org/',
                'merchant_type' => 'express',
                'note' => 'Note',
            ]);
            
            //dd($response->json());
            $return = $response->json();
            
            if($return['code'] == 200) {
                // Save DB
                UserXeedwallet::create([
                    'email' => $reqData['email'],
                    'password' => $reqData['password'],
                    'client_id' => $return['client_id'],
                    'secret' => $return['client_secret'],
                ]);
            
                return response()->json([
                    'status' => 1,
                    'code' => 200,
                    'message' => "User created",
                    'redirect' => route("admin.xeedwalletList"),
                ]);
            }
            else {
                return response()->json([
                    'status' => 0,
                    'code' => 400,
                    'message' => "User creation failed.",
                ]);
            }
            
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'code' => 404,
                'message' => $e->getMessage(),
            ]);
        }
        
        
        
    }
    
    // view xwallet detail
    function viewXeedwallet(Request $request) { 
        $findXeedwallet = UserXeedwallet::where('id', $request->id)->first();
        if($findXeedwallet) {
            return response()->json([
                'status' => 1,
                'code' => 200,
                'message' => "Get user successfully",
                'data' => $findXeedwallet
            ]);
        }
        else {
            return response()->json([
                'status' => 0,
                'code' => 404,
                'message' => 'User not found',
            ]);
        }
    
    }
    // view xwallet detail
    function setXeedwallet(Request $request) { 
        $findXeedwallet = Project::where('id', $request->project_id)->first();
        if($findXeedwallet) {
            Project::where('id', $request->project_id)->update([
                'user_xeedwallet_id' => $request->xeedwallet_id,
            ]);
            return response()->json([
                'status' => 1,
                'code' => 200,
                'message' => "Project updated",
            ]);
        }
        else {
            return response()->json([
                'status' => 0,
                'code' => 404,
                'message' => 'Project not found',
            ]);
        }
    
    }
    
    function generateEmailAddress( $length = 8 ) {
        $numbers         = '0123456789';
        $letters         = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $extras          = '.-_';
        $all             = $numbers . $letters . $extras;
        $alpha_numeric   = $letters . $numbers;
        $alpha_numeric_p = $letters . $numbers . '-';
        $random_string   = '';
        for ( $i = 0; $i < $length; $i++ ) {
            $random_string .= $letters[rand( 0, strlen( $letters ) - 1 )];
        }
    
        $random_string .= '@gmail.com';
        return $random_string;
    }
    
}