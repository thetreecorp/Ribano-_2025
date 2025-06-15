<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\Content;
use App\Models\ContentDetails;
use App\Models\ContentMedia;
use App\Models\Language;
use App\Models\Category;
use App\Models\IndustryCategory;
use App\Models\ProjectStage;
use App\Models\IdealInvestorRole;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Str;
use App\Models\NewsFeedModel;
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
    
    function manageNewsfeed() {
        $news_feeds = NewsFeedModel::orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view('admin.news-feed', compact('news_feeds'));
    }
    
    
    
}