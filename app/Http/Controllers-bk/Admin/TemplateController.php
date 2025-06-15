<?php

namespace App\Http\Controllers\Admin;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\Language;
use App\Models\Template;
use App\Models\TemplateMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class TemplateController extends Controller
{
    use Upload;

    public function show($section)
    {
        if (!array_key_exists($section, config('templates'))) {
            abort(404);
        }
        $languages = Language::all();
        $templates = Template::where('section_name', $section)->get()->groupBy('language_id');

        $templateMedia = TemplateMedia::where('section_name', $section)->first();

        return view('admin.template.show', compact('languages', 'section', 'templates', 'templateMedia'));
    }

    public function update(Request $request, $section, $language)
    {
    
        try {
            if (!array_key_exists($section, config('templates'))) {
                abort(404);
            }
            
    
            $purifiedData = Purify::clean($request->except('background_image', 'thumbnail', '_token', '_method'));
            
            // dd($purifiedData);
    
            if ($request->has('image')) {
                $purifiedData['image'] = $request->image;
            }
            if ($request->has('thumbnail')) {
                $purifiedData['thumbnail'] = $request->thumbnail;
            }
            if ($request->has('background_image')) {
                $purifiedData['background_image'] = $request->background_image;
            }
    
            $validate = Validator::make($purifiedData, config("templates.$section.validation"), config('templates.message'));
            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }
    
            // save regular field
            $field_name = array_diff_key(config("templates.$section.field_name"), config("templates.template_media"));
            foreach ($field_name as $name => $type) {
                $description[$name] = $purifiedData[$name][$language];
            }
            $template = Template::where(['section_name' => $section, 'language_id' => $language])->firstOrNew();
            $template->language_id = $language;
            $template->section_name = $section;
            $template->description = $description ?? null;
            $template->save();
    
    
            // save template media
            if ($request->hasAny(array_keys(config('templates.template_media')))) {
                $templateMedia = TemplateMedia::where(['section_name' => $section])->firstOrNew();
    
                foreach (config('templates.template_media') as $key => $media) {
                    $old_data = $templateMedia->description->{$key} ?? null;
                    if ($request->hasFile($key)) {
                        $templateMediaDescription[$key] = $this->uploadImage($purifiedData[$key][$language], config('location.template.path'), null, $old_data, null, $old_data);
                    } elseif ($request->has($key)) {
                        $templateMediaDescription[$key] = linkToEmbed($purifiedData[$key][$language]);
                    } elseif (isset($old_data)) {
                        $templateMediaDescription[$key] = $old_data;
                    }
                }
                
                // //dd($templateMediaDescription);
    
                $templateMedia->section_name = $section;
                $templateMedia->description = $templateMediaDescription ?? null;
                $templateMedia->save();
            }
            if ($request->has('image_option_2')) {
                //dd($request->image_option_2);
                $templateMedia = TemplateMedia::where(['section_name' => $section])->firstOrNew();
                $file = $this->uploadImage($request->image_option_2, config('location.content.path'));
                $templateMedia->image_2_option = $file ?? null;
                $templateMedia->save();
            }
    
            return back()->with('success', 'Template Successfully Saved');
        } catch (\Exception $e) {
            //throw $th;
            return back()->with('success', $e->getMessage());

        }
        
    }

}
