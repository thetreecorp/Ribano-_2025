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
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Str;

use App\Models\IndustryCategory;
use App\Models\ProjectStage;
use App\Models\IdealInvestorRole;

class AjaxController extends Controller
{
    use Upload; 
    
    
    
    function createCategory(Request $request) {
    
        try {
            $reqData = Purify::clean($request->except('_token', '_method'));
            $cat = Category::create([
                'name' => $reqData['name']
            ]);
            
            if($cat) 
                return response()->json(['success' => 1, 'message' => trans('Category create successfully')]);
            else 
                return response()->json(['success' => 0, 'message' => trans('Category create fails')]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => 0, 'message' => $th->getMessage()]);
        }
        
        
    }

    function createModule(Request $request, $slug) {
    
        try {
            $reqData = Purify::clean($request->except('_token', '_method'));

            if(in_array($slug, array(Str::slug("Industry Category"), Str::slug("Project Stage"), Str::slug("Ideal Investor Role")))) {
                if($slug == Str::slug("Industry Category")) {
                
                    $cat = IndustryCategory::create([
                        'name' => $reqData['name']
                    ]);
                    
                    if($cat) 
                        return response()->json(['success' => 1, 'message' => trans('Industry create successfully')]);
                    else 
                        return response()->json(['success' => 0, 'message' => trans('Industry create fails')]);
                }
                else if($slug == Str::slug("Project Stage")) {
                    $cat = ProjectStage::create([
                        'name' => $reqData['name']
                    ]);
                    
                    if($cat) 
                        return response()->json(['success' => 1, 'message' => trans('Stage create successfully')]);
                    else 
                        return response()->json(['success' => 0, 'message' => trans('Stage create fails')]);
                }
                else {
                
                    $cat = IdealInvestorRole::create([
                        'name' => $reqData['name']
                    ]);
                    
                    if($cat) 
                        return response()->json(['success' => 1, 'message' => trans('Investor role create successfully')]);
                    else 
                        return response()->json(['success' => 0, 'message' => trans('Investor role create fails')]);
                }
            }
            else {
                return response()->json(['success' => 0, 'message' => trans('Slug option not exist')]);
            }

           
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => 0, 'message' => $th->getMessage()]);
        }
        
        
    }
    

    function editModule(Request $request, $slug) {
    
        if(in_array($slug, array(Str::slug("Industry Category"), Str::slug("Project Stage"), Str::slug("Ideal Investor Role")))) { 
            try {
            
                if($slug == Str::slug("Industry Category")) {
                    $cat = IndustryCategory::where('id', $request->id)->first();
                    if($request->type == 'get-cat') {
                        if($cat) 
                            return response()->json(['success' => 1, 'message' => trans('Industry get info successfully'), 'data' => $cat]);
                        else 
                            return response()->json(['success' => 0, 'message' => trans('Industry not found')]);
                    }
                    else {
                        // submit here
                        if($cat) {
                            // update
                            $update = IndustryCategory::where('id', $request->id)->update([
                                'name' => $request->name
                            ]);
                            if($update)
                                return response()->json(['success' => 1, 'message' => trans('Industry updated')]);
                            else 
                                return response()->json(['success' => 0, 'message' => trans('Industry update fails')]);
                        }
                        else 
                            return response()->json(['success' => 0, 'message' => trans('Industry not found')]);
                            
                    }
                }
                else if($slug == Str::slug("Project Stage")) { 
                    $cat = ProjectStage::where('id', $request->id)->first();
                    if($request->type == 'get-cat') {
                        if($cat) 
                            return response()->json(['success' => 1, 'message' => trans('Stage get info successfully'), 'data' => $cat]);
                        else 
                            return response()->json(['success' => 0, 'message' => trans('Stage not found')]);
                    }
                    else {
                        // submit here
                        if($cat) {
                            // update
                            $update = ProjectStage::where('id', $request->id)->update([
                                'name' => $request->name
                            ]);
                            if($update)
                                return response()->json(['success' => 1, 'message' => trans('Stage updated')]);
                            else 
                                return response()->json(['success' => 0, 'message' => trans('Stage update fails')]);
                        }
                        else 
                            return response()->json(['success' => 0, 'message' => trans('Stage not found')]);
                            
                    }
                }
                else {
                    $cat = IdealInvestorRole::where('id', $request->id)->first();
                    if($request->type == 'get-cat') {
                        if($cat) 
                            return response()->json(['success' => 1, 'message' => trans('Investor role get info successfully'), 'data' => $cat]);
                        else 
                            return response()->json(['success' => 0, 'message' => trans('Investor role not found')]);
                    }
                    else {
                        // submit here
                        if($cat) {
                            // update
                            $update = IdealInvestorRole::where('id', $request->id)->update([
                                'name' => $request->name
                            ]);
                            if($update)
                                return response()->json(['success' => 1, 'message' => trans('Investor role updated')]);
                            else 
                                return response()->json(['success' => 0, 'message' => trans('Investor role update fails')]);
                        }
                        else 
                            return response()->json(['success' => 0, 'message' => trans('Investor role not found')]);
                            
                    }
                }
                
               
            } catch (\Throwable $th) {
                return response()->json(['success' => 0, 'message' => $th->getMessage()]);
            }
        }
        else {
            return response()->json(['success' => 0, 'message' => trans('Slug option not exist')]);
        }
       
        
        
    }
    
    // create faq function
    function createFaqContent(Request $request) {
        $update = Faq::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => 1,
        ]);
        if($update)
            return response()->json(['success' => 1, 'message' => trans('Faq created')]);
        else
            return response()->json(['success' => 0, 'message' => trans('Faq created fails')]);
        
    }

    function deleteFaqContent(Request $request) {
        $faq = Faq::where('id', $request->id)->first();
        if($faq) {
            $delete = Faq::where('id', $request->id)->delete();
            if($delete)
                return response()->json(['success' => 1, 'message' => trans('Faq deleted')]);
            else
                return response()->json(['success' => 0, 'message' => trans('Faq deleted fails')]);
        }
        else {
            return response()->json(['success' => 0, 'message' => trans('Faq not found')]);
        }
        
    }
    
    // Edit faq function
    function saveEditFaqContent(Request $request) {
        $faq = Faq::where('id', $request->id)->first();
        if($faq) {
            $update = Faq::where('id', $request->id)->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
            ]);
            if($update)
                return response()->json(['success' => 1, 'message' => trans('Faq updated')]);
            else
                return response()->json(['success' => 0, 'message' => trans('Faq update fails')]);
        }
        else {
            return response()->json(['success' => 0, 'message' => trans('Faq not found')]);
        }
        
    }
    // Edit faq function
    function getFaqContent(Request $request) {
        $faq = Faq::where('id', $request->id)->first();
        if($faq) {
            return response()->json(['success' => 1, 'message' => trans('Get Faq successfully'), 'data' => $faq]);
        }
        else {
            return response()->json(['success' => 0, 'message' => trans('Faq not found')]);
        }
        
    }
    
    
    
    
    // delete module
    function deleteModule(Request $request, $slug) {
        if(in_array($slug, array(Str::slug("Industry Category"), Str::slug("Project Stage"), Str::slug("Ideal Investor Role")))) {  
            if($slug == Str::slug("Industry Category")) { 
                try {
                    $update = IndustryCategory::where('id', $request->id)->delete();
                    // update in contentdetail
                    // $update_content = ContentDetails::where('category_id', $request->id)->whereNotNull('category_id')->update([
                    //     'category_id' =>    NULL
                    // ]);
                    return response()->json(['success' => 1, 'message' => trans('Industry category deleted')]);
                } catch (\Throwable $th) {
                    return response()->json(['success' => 0, 'message' => trans('Industry category deleted fails')]);
                }
            }
            else if($slug == Str::slug("Project Stage")) { 
                try {
                    $update = ProjectStage::where('id', $request->id)->delete();
                    // update in contentdetail
                    // $update_content = ContentDetails::where('category_id', $request->id)->whereNotNull('category_id')->update([
                    //     'category_id' =>    NULL
                    // ]);
                    return response()->json(['success' => 1, 'message' => trans('Project Stage deleted')]);
                } catch (\Throwable $th) {
                    return response()->json(['success' => 0, 'message' => trans('Project Stage deleted fails')]);
                }
            }
            else {
                try {
                    $update = IdealInvestorRole::where('id', $request->id)->delete();
                    // // update in contentdetail
                    // $update_content = ContentDetails::where('category_id', $request->id)->whereNotNull('category_id')->update([
                    //     'category_id' =>    NULL
                    // ]);
                    return response()->json(['success' => 1, 'message' => trans('Ideal Investor Role deleted')]);
                } catch (\Throwable $th) {
                    return response()->json(['success' => 0, 'message' => trans('Ideal Investor Role deleted fails')]);
                }
            }
            
        }
        else {
            return response()->json(['success' => 0, 'message' => trans('Slug option not exist')]);
        }
        
        
    }
    


    function editCategory(Request $request) {
    
        try {
            $cat = Category::where('id', $request->id)->first();
            if($request->type == 'get-cat') {
                if($cat) 
                    return response()->json(['success' => 1, 'message' => trans('Category create successfully'), 'data' => $cat]);
                else 
                    return response()->json(['success' => 0, 'message' => trans('Category not found')]);
            }
            else {
                // submit here
                if($cat) {
                    // update
                    $update = Category::where('id', $request->id)->update([
                        'name' => $request->name
                    ]);
                    if($update)
                        return response()->json(['success' => 1, 'message' => trans('Category updated')]);
                    else 
                        return response()->json(['success' => 0, 'message' => trans('Category update fails')]);
                }
                else 
                    return response()->json(['success' => 0, 'message' => trans('Category not found')]);
                    
            }
        
           
           
        } catch (\Throwable $th) {
            return response()->json(['success' => 0, 'message' => $th->getMessage()]);
        }
        
        
    }
    
    
    
    
    
    function deleteCategory(Request $request) {
        try {
            $update = Category::where('id', $request->id)->delete();
            // update in contentdetail
            $update_content = ContentDetails::where('category_id', $request->id)->whereNotNull('category_id')->update([
                'category_id' =>    NULL
            ]);
            return response()->json(['success' => 1, 'message' => trans('Category deleted')]);
        } catch (\Throwable $th) {
            return response()->json(['success' => 0, 'message' => trans('Category deleted fails')]);
        }
        
    }
    
    
    
    
}